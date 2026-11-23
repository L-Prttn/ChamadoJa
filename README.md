ChamadoJá

API de gerenciamento de chamados desenvolvido como projeto acadêmico.

1. Sobre o projeto
    O ChamadoJá tem como objetivo permitir o cadastro, acompanhamento e
    gerenciamento de chamados, organizando as solicitações e seus respectivos
    atendimentos.

2. Funcionalidades
    - Cadastro e gerenciamento de usuários
    - Cadastro e consulta de categorias
    - Autenticação com token de acesso (Laravel Sanctum)
    - Criação e gerenciamento de chamados
    - Alteração de status dos chamados
    - Comentários nos chamados
    - Histórico de alterações
    - Consulta de resumo dos chamados
    - Paginação nas listagens

3. Tecnologias
    - Backend: PHP com Laravel
    - Banco de dados: PostgreSQL
    - API REST
    - Autenticação: Laravel Sanctum
    - Git/GitHub

4. Documentação
    - Requisitos (docs/requisitos.md)
    - Casos de uso (docs/casos_de_uso.md)
    - Contrato da API (docs/contrato-api.md)
    - Riscos do projeto (docs/riscos.md)
    - Organização de desenvolvimento do projeto (docs/organizacao_projeto.md)
    - Diario de desenvolvimento (docs/diario.md)
    - Modelo Entidade-Relacionamento (docs/modelo-er/modelo-er.md)
    - Diagrama do modelo ER (docs/modelo-er/modelo-er.png)
    - Decisões do banco de dados (database/decisoes-banco.md)
    - Estrutura do banco (database/schema.sql)
    - Consultas SQL (database/consultas.sql)
    - Pesquisa sobre autenticação e segurança (docs/pesquisa-autenticacao.md)

5. Status
    - Projeto concluído até a Semana 7.
        Funcionalidades principais implementadas: usuários, categorias,
        chamados, comentários, histórico, filtros, paginação, resumo e
        autenticação com Laravel Sanctum.
        A suíte possui 23 testes automatizados e 116 asserções.
        A instalação limpa foi validada em uma pasta e um banco separados.
        A versão final está preparada para a entrega da Semana 7.

6. Instalação
    - Requisitos
        - PHP 8.2 ou superior com as extensões pdo_pgsql, pgsql, mbstring, openssl, fileinfo e curl
        - Composer
        - PostgreSQL
        - Git
    - Configuração detalhada
        - O arquivo .env.example já vem configurado para PostgreSQL em
          127.0.0.1:5432, banco chamadoja e usuário postgres. Preencha
          DB_PASSWORD com a senha local.
        - O arquivo .env não deve ser versionado; ele é criado a partir do .env.example.
        - O banco chamadoja é usado pela aplicação. O banco chamadoja_test é usado pelo PHPUnit.
        - O phpunit.xml fixa chamadoja_test e reaproveita as credenciais do .env.
        - Os testes apagam e recriam as tabelas do banco de teste. Nunca
          aponte chamadoja_test para o banco de desenvolvimento.
        - As migrations usam restrições específicas do PostgreSQL; por isso
          os testes também usam PostgreSQL, não SQLite em memória.
        - Os seeders criam usuários, categorias e chamados de demonstração para uso manual e apresentação.

    - Roteiro rápido no PowerShell
        Execute os comandos na ordem. Escolha uma pasta onde a pasta ChamadoJa ainda não exista.
        O passo 6 abre o .env no Notepad; preencha DB_PASSWORD antes de continuar.

        1. Conferir os pré-requisitos:
            php -v
            composer --version
            php -m | Select-String "pdo_pgsql|pgsql|mbstring|openssl|fileinfo|curl"

        2. Clonar o repositório:
            git clone https://github.com/L-Prttn/ChamadoJa.git
            cd ChamadoJa

        3. Instalar as dependências:
            composer install

        4. Criar o arquivo de ambiente:
            Copy-Item .env.example .env

        5. Gerar a chave da aplicação:
            php artisan key:generate

        6. Configurar o banco no .env:
            notepad .env
                Confira DB_CONNECTION=pgsql, DB_HOST=127.0.0.1, DB_PORT=5432,
                DB_DATABASE=chamadoja e DB_USERNAME=postgres. Preencha DB_PASSWORD
                com a senha do PostgreSQL, salve o arquivo e feche o Notepad.

        7. Criar os bancos no PostgreSQL:
            $psql = "C:\Program Files\PostgreSQL\18\bin\psql.exe"
            & $psql -U postgres -h 127.0.0.1 -p 5432 -d postgres -c "CREATE DATABASE chamadoja;"
            & $psql -U postgres -h 127.0.0.1 -p 5432 -d postgres -c "CREATE DATABASE chamadoja_test;"
                Se o banco já existir, o PostgreSQL informa um erro e o próximo comando pode seguir.
                Ajuste a versão 18 do caminho se a instalação local for diferente.

        8. Criar as tabelas e carregar os dados:
            php artisan migrate:fresh --seed

        9. Executar os testes automatizados:
            php artisan test
                Resultado esperado: 23 testes e 116 asserções aprovados.

        10. Iniciar a API:
            php artisan serve

        11. Em outro PowerShell, testar a rota de saúde:
            Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/saude" | ConvertTo-Json -Depth 5

        Para encerrar o servidor, volte ao terminal do php artisan serve e pressione Ctrl+C.

7. Endpoints da API
    - As rotas marcadas como públicas não exigem token.
    - As demais exigem o header Authorization: Bearer <token>.
    | Método | Rota                            | Objetivo                  | Autenticação | Sucesso |
    |        |                                 |                           |              |         |
    | GET    | /api/saude                      | Verificar a API           | Pública      | 200     |
    | POST   | /api/login                      | Autenticar usuário        | Pública      | 200     |
    | POST   | /api/usuarios                   | Cadastrar usuário         | Pública      | 201     |
    | POST   | /api/logout                     | Revogar o token atual     | Token        | 200     |
    | GET    | /api/usuarios                   | Listar usuários           | Token        | 200     |
    | GET    | /api/categorias                 | Listar categorias         | Token        | 200     |
    | POST   | /api/categorias                 | Cadastrar categoria       | Token        | 201     |
    | GET    | /api/chamados                   | Listar chamados           | Token        | 200     |
    | POST   | /api/chamados                   | Abrir chamado             | Token        | 201     |
    | GET    | /api/chamados/{id}              | Consultar chamado         | Token        | 200     |
    | PATCH  | /api/chamados/{id}              | Atualizar chamado         | Token        | 200     |
    | GET    | /api/chamados/{id}/comentarios  | Listar comentários        | Token        | 200     |
    | POST   | /api/chamados/{id}/comentarios  | Adicionar comentário      | Token        | 201     |
    | PATCH  | /api/chamados/{id}/status       | Alterar status            | Token        | 200     |
    | GET    | /api/chamados/{id}/historico    | Consultar histórico       | Token        | 200     |
    | GET    | /api/relatorios/resumo-chamados | Consultar resumo          | Token        | 200     |
        As respostas de sucesso utilizam o envelope 'dados'.

8. Exemplos de requisição e resposta
    - As rotas de chamados, comentários, status, histórico e resumo exigem token.
    - O login e o uso do token estão detalhados no item 9.
    - Exemplo de cadastro de usuário:
        POST /api/usuarios
        {
            "nome": "Usuario Exemplo",
            "email": "usuario@example.test",
            "senha": "senha-teste",
            "senha_confirmation": "senha-teste",
            "tipo": "usuario"
        }
        Resposta 201:
        {
            "dados": {
                "id": 6,
                "nome": "Usuario Exemplo",
                "email": "usuario@example.test",
                "tipo": "usuario",
                "criado_em": "...",
                "atualizado_em": "..."
            }
        }

    - Exemplo de abertura de chamado:
        POST /api/chamados
        {
            "solicitante_id": 1,
            "categoria_id": 1,
            "titulo": "Computador nao liga",
            "descricao": "O computador nao apresenta sinais de energia.",
            "prioridade": "alta"
        }
        Resposta 201:
        {
            "dados": {
                "id": 6,
                "titulo": "Computador nao liga",
                "descricao": "O computador nao apresenta sinais de energia.",
                "prioridade": "alta",
                "status": "aberto",
                "solicitante": {
                    "id": 1,
                    "nome": "Ana Souza"
                },
                "categoria": {
                    "id": 1,
                    "nome": "Hardware"
                }
            }
        }
    - Dados inválidos retornam 422 e registros inexistentes retornam 404.

    - Filtros, paginação e ordenação em GET /api/chamados:
        Exemplos:
            /api/chamados?status=aberto
            /api/chamados?prioridade=alta&categoria_id=1
            /api/chamados?solicitante_id=2&ordenar_por=prioridade&ordem=asc
            /api/chamados?por_pagina=5&page=2
        A resposta inclui os blocos dados, links e meta.
    - Exemplo de comentário:
        POST /api/chamados/1/comentarios
        {
            "usuario_id": 1,
            "conteudo": "Problema identificado e em analise."
        }
        Resposta 201:
        {
            "dados": {
                "id": 4,
                "conteudo": "Problema identificado e em analise.",
                "autor": {
                    "id": 1,
                    "nome": "Ana Souza"
                },
                "criado_em": "..."
            }
        }
    - Exemplo de alteração de status:
        PATCH /api/chamados/1/status
        {
            "status": "em_andamento",
            "usuario_id": 3
        }
        Resposta 200: dados do chamado com o novo status.
        Transição não permitida, resposta 422:
        {
            "mensagem": "Transição de status não permitida.",
            "erros": {
                "status": ["Transição de status não permitida."]
            }
        }
    - Exemplo de resumo:
        GET /api/relatorios/resumo-chamados
        Resposta 200:
        {
            "dados": {
                "total": 4,
                "por_status": {
                    "aberto": 1,
                    "em_andamento": 2,
                    "resolvido": 1,
                    "fechado": 0
                },
                "por_prioridade": {
                    "normal": 2,
                    "alta": 1,
                    "urgente": 1
                },
                "por_categoria": [
                    {
                        "categoria": {
                            "id": 3,
                            "nome": "Acesso"
                        },
                        "total": 1
                    },
                    {
                        "categoria": {
                            "id": 1,
                            "nome": "Hardware"
                        },
                        "total": 1
                    },
                    {
                        "categoria": {
                            "id": 2,
                            "nome": "Software"
                        },
                        "total": 2
                    }
                ]
            }
        }

9. Autenticação
    - Cadastro de usuário (público):
        POST /api/usuarios
        {
            "nome": "Usuario Exemplo",
            "email": "usuario@example.test",
            "senha": "senha-teste",
            "senha_confirmation": "senha-teste",
            "tipo": "usuario"
        }
    - Login (público):
        POST /api/login
        {
            "email": "usuario@example.test",
            "senha": "senha-teste"
        }
        Resposta 200:
        {
            "dados": {
                "token": "1|token-gerado",
                "usuario": {
                    "id": 6,
                    "nome": "Usuario Exemplo",
                    "email": "usuario@example.test",
                    "tipo": "usuario"
                }
            }
        }
    - Uso do token:
        Enviar o header Authorization: Bearer <token> nas rotas protegidas.
    - Logout:
        POST /api/logout
        Revoga o token atual.
    - Rotas públicas:
        GET /api/saude
        POST /api/login
        POST /api/usuarios
    - As demais rotas exigem autenticação.
    - A implementação utiliza Laravel Sanctum e o model Usuario.
    - A senha é armazenada em senha_hash e nunca é retornada pela API.
    - O login aceita até 5 tentativas por minuto por origem.
    - Usuários cadastrados antes desta etapa, sem senha, não conseguem autenticar.
    - A pesquisa e a implementação estão registradas em docs/pesquisa-autenticacao.md.
    - Usuários de demonstração criados pelo seeder:
        ana.souza@example.test / senha-demo-123
        carlos.oliveira@example.test / senha-demo-123
        marina.atendimento@example.test / senha-demo-123
        Essas credenciais são fictícias e servem somente para demonstração local.

10. Regras principais
    - Prioridades aceitas: normal, alta e urgente.
    - Status aceitos: aberto, em_andamento, resolvido e fechado.
    - Transições permitidas:
        aberto -> em_andamento
        em_andamento -> resolvido
        resolvido -> fechado ou em_andamento
        fechado -> nenhuma
    - Todo chamado nasce com status aberto.
    - A abertura do chamado grava o primeiro registro do histórico.
    - A alteração de status e o histórico são gravados na mesma transação.
    - A atualização do chamado aceita categoria_id, titulo, descricao e prioridade.
    - O comentário possui chamado, autor, conteudo e data de criação.
    - A listagem de chamados aceita filtros de status, prioridade, categoria_id e solicitante_id.
    - A paginação usa 15 registros por página por padrão e aceita por_pagina entre 1 e 100.
    - A ordenação aceita criado_em, prioridade e status, com ordem asc ou desc.
    - O resumo retorna total, por_status, por_prioridade e por_categoria.
    - Respostas de sucesso usam o envelope dados.
    - Erros de validação retornam 422 com as chaves mensagem e erros.
    - Registro inexistente retorna 404 com a mensagem "Recurso não encontrado.".
    - Requisição sem autenticação retorna 401 com a mensagem "Não autenticado.".

11. Limitações conhecidas
    - A primeira versão possui somente API, sem interface web ou aplicativo móvel.
    - Não há autorização por tipo de usuário. Usuários autenticados acessam as rotas protegidas e informam o usuario_id nas operações de comentário e status.
    - A alteração de status não utiliza lockForUpdate; requisições simultâneas podem validar a partir do mesmo status.
    - O filtro por período de criação não foi implementado.
    - Usuários cadastrados antes da implementação da autenticação, sem senha, não conseguem entrar no sistema.
    - Os testes automatizados exigem um banco PostgreSQL separado, pois as migrations utilizam recursos específicos do PostgreSQL.
    - Não existem endpoints para excluir chamados, comentários ou históricos.
    - Não há atualização ou exclusão de usuários e categorias nesta versão.
    - Não há upload de anexos, notificações por e-mail ou integrações externas.
