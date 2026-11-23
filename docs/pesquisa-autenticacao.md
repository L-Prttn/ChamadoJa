PESQUISA SOBRE AUTENTICAÇÃO E SEGURANÇA

Objetivo:
    Registrar os conceitos básicos de autenticação e segurança estudados na Semana 6 e indicar o que deverá ser protegido no ChamadoJá.
    Este documento registra a pesquisa feita antes da implementação. A situação
    final do projeto está resumida na seção 11.

1. Autenticação e autorização

    - Autenticação confirma a identidade: "quem é você?". No ChamadoJá, seria o login com e-mail e senha.
    - Autorização verifica o que o usuário pode fazer: "o que você pode fazer?". Exemplo: somente um atendente altera o status de um chamado.
    - Estar autenticado não garante permissão. Sem autenticação, a API deve responder HTTP 401. Sem autorização, HTTP 403.
    - Proposta para o ChamadoJá: o usuário do tipo usuario acompanha os próprios chamados; o atendente atende todos e acessa relatórios.

2. Senhas e hash

    - Senhas não devem ser armazenadas em texto puro. Se o banco vazar, as credenciais ficam expostas e podem ser usadas em outros serviços.
    - Hash é uma transformação de mão única: permite verificar a senha, mas não recuperar o valor original. Não é criptografia, pois a criptografia é reversível com a chave.
    - O ideal é usar um algoritmo próprio para senhas, com salt e fator de custo. A OWASP recomenda Argon2id; bcrypt também é aceitável.
    - No Laravel: Hash::make gera o hash, Hash::check verifica a senha e Hash::needsRehash indica quando o hash deve ser atualizado.
    - No ChamadoJá, a coluna usuarios.senha_hash já existia, mas o cadastro ainda
      não recebia senha na época desta pesquisa. O campo não aparece no
      UsuarioResource. A implementação posterior está na seção 11.

3. Token de acesso

    - É uma credencial entregue após o login e enviada nas requisições seguintes como Authorization: Bearer TOKEN.
    - Identifica o usuário sem exigir e-mail e senha em todas as requisições. Deve ser protegido como uma senha.
    - Pode expirar e ser revogado. O Sanctum guarda o token como hash SHA-256 e mostra o texto puro apenas no momento da criação.

4. Laravel Sanctum

    - É um pacote de autenticação para APIs, aplicações SPA e aplicações móveis.
    - Instalação: php artisan install:api.
    - O model do usuário usa o trait HasApiTokens. O login cria o token com createToken('api')->plainTextToken.
    - As rotas são protegidas com o middleware auth:sanctum. As abilities limitam o que cada token pode fazer.
    - O Sanctum autentica, mas não autoriza. As regras de permissão continuam em Gates ou Policies.
    - No ChamadoJá, o model Usuario estende Model e o config/auth.php aponta para App\Models\User, que usa a tabela users. Antes de implementar, será necessário alinhar o model e o provider, criar o login e definir como a senha será cadastrada.

5. Proteção de rotas e revogação de tokens

    - A rota de login fica pública. As demais podem ficar em Route::middleware('auth:sanctum')->group(...).
    - Sem token válido, a resposta é HTTP 401. Com token válido, mas sem permissão, HTTP 403.
    - Revogar o token atual: $request->user()->currentAccessToken()->delete().
    - Revogar todos os tokens: $request->user()->tokens()->delete().
    - Por padrão, os tokens do Sanctum não expiram; a expiração pode ser configurada.

6. Dados que não devem aparecer nas respostas

    - senha_hash, senhas, tokens, remember_token, chaves e variáveis de ambiente.
    - Stack traces, consultas SQL e detalhes internos de exceções.
    - Dados pessoais desnecessários, como e-mail em um contexto público.
    - As respostas devem ser montadas campo a campo. No ChamadoJá, os Resources já evitam expor senha_hash e dados completos dos relacionados.
    - Erros padronizados: 422 com mensagem e erros; 404, 401, 403 e 500 com mensagem. Em produção, APP_DEBUG deve ficar desativado.

7. Riscos de deixar todos os endpoints públicos

    - Qualquer pessoa pode listar, cadastrar, alterar status, comentar e consultar relatórios.
    - Hoje o ChamadoJá recebe solicitante_id e usuario_id pelo corpo da requisição. Sem autenticação, alguém pode agir em nome de outro usuário.
    - Também há risco de exposição de dados pessoais, spam, consumo de recursos e falta de auditoria.
    - A OWASP destaca falhas de autenticação, autorização em nível de função e exposição excessiva de dados.

8. Funcionalidades a proteger em uma futura versão

    A proposta abaixo ainda não foi implementada e deve ser confirmada antes de qualquer alteração no código.

    | Funcionalidade                      | Proteção proposta                                      |
    | POST /api/usuarios                  | Autenticação; apenas atendente.                        |
    | POST /api/categorias                | Autenticação; apenas atendente.                        |
    | POST /api/chamados                  | Autenticação; solicitante vem do token.                |
    | PATCH /api/chamados/{id}/status     | Autenticação; apenas atendente.                        |
    | GET /api/relatorios/resumo-chamados | Autenticação; apenas atendente.                        |
    | GET /api/chamados e /{id}           | Autenticação; usuario vê os próprios; atendente vê todos. |
    | Comentários                         | Autenticação; autor vem do token.                      |
    | GET /api/usuarios                   | Autenticação; restringir a atendente se houver dados pessoais. |
    | GET /api/categorias                 | Autenticação; leitura para usuários autenticados.      |
    | GET /api/saude                      | Público.                                               |

    A autenticação sozinha não resolve tudo. Também é necessário verificar o tipo do usuário e se ele é o dono do chamado.

9. Decisão inicial sobre o Sanctum (Semana 6)

    - A pesquisa é obrigatória; a implementação é opcional.
    - Recomendação: não implementar agora. Priorizar os testes automatizados e a padronização dos erros.
    - Motivo: a API atual funciona sem autenticação, e a implementação exige mudanças no model, no provider, no cadastro, nas rotas e nos testes. Se for feita depois, deve ser documentada e testada como extensão.

10. Fontes consultadas

    - Laravel 12 — Sanctum: https://laravel.com/docs/12.x/sanctum
    - Laravel 12 — Hashing: https://laravel.com/docs/12.x/hashing
    - Laravel 12 — Authentication: https://laravel.com/docs/12.x/authentication
    - Laravel 12 — Authorization: https://laravel.com/docs/12.x/authorization
    - OWASP — Password Storage Cheat Sheet: https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html
    - OWASP — API2:2023 Broken Authentication: https://owasp.org/API-Security/editions/2023/en/0xa2-broken-authentication/
    - OWASP — API3:2019 Excessive Data Exposure: https://owasp.org/API-Security/editions/2019/en/0xa3-excessive-data-exposure/
    - OWASP — API5:2023 Broken Function Level Authorization: https://owasp.org/API-Security/editions/2023/en/0xa5-broken-function-level-authorization/

    Fontes acessadas em 09/11/2026.

11. Situação final da implementação

    - O Laravel Sanctum foi instalado como extensão opcional da Semana 6.
    - O model Usuario passou a estender Authenticatable e a usar HasApiTokens.
    - O provider de autenticação foi ajustado para App\Models\Usuario.
    - O cadastro passou a exigir senha com no mínimo 8 caracteres e confirmação.
    - A senha é armazenada em senha_hash e não aparece nas respostas.
    - Foram criadas as rotas POST /api/login e POST /api/logout.
    - Permanecem públicas GET /api/saude, POST /api/login e POST /api/usuarios.
    - As demais rotas usam o middleware auth:sanctum.
    - O login aceita até 5 tentativas por minuto por origem.
    - O token é enviado no header Authorization: Bearer <token>.
    - O logout revoga o token atual.
    - Não foi implementada autorização por tipo de usuário nem vínculo automático
      entre o token e o usuario_id enviado no corpo das requisições.
    - A implementação possui testes de login, logout, senha incorreta e acesso sem token.
