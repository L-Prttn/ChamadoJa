DECISÕES DO BANCO DE DADOS

1. Banco de dados escolhido
    Utilizará o PostgreSQL como sistema gerenciador de banco de dados. A escolha permite utilizar chaves estrangeiras, restrições de integridade, transações e índices para manter os dados consistentes e facilitar as consultas.

2. Organização das tabelas
    O modelo de negócio será dividido em cinco tabelas: `usuarios`, `categorias`,
    `chamados`, `comentarios` e `historico_status`.
    Essa separação evita a duplicação de informações e facilita a manutenção dos dados. Cada tabela terá uma responsabilidade específica, conforme descrito em `docs/modelo-er/modelo-er.md`.
    Além dessas tabelas, o Laravel Sanctum cria `personal_access_tokens` para
    armazenar os tokens de acesso usados na autenticação.

3. Chaves primárias e estrangeiras
    Todas as tabelas de negócio terão uma chave primária `id`, gerada automaticamente pelo banco de dados.
    As chaves estrangeiras serão utilizadas para representar os relacionamentos entre as tabelas:
        - `chamados.solicitante_id` referencia `usuarios.id`.
        - `chamados.categoria_id` referencia `categorias.id`.
        - `comentarios.chamado_id` referencia `chamados.id`.
        - `comentarios.usuario_id` referencia `usuarios.id`.
        - `historico_status.chamado_id` referencia `chamados.id`.
        - `historico_status.usuario_id` referencia `usuarios.id`.
    Essas referências impedem que sejam associados chamados, comentários ou registros de histórico a usuários, categorias ou chamados inexistentes.

4. Campos obrigatórios e valores únicos
    Campos essenciais serão definidos como obrigatórios (`NOT NULL`). Campos com informações que não podem se repetir terão restrições `UNIQUE`.
    O e-mail será único na tabela `usuarios`. O nome será único na tabela `categorias`, considerando que cada nome representa uma categoria distinta nesta versão do projeto.
    Campos opcionais, como a descrição de uma categoria, poderão aceitar `NULL`.
    O campo `senha_hash` permanece opcional no banco para compatibilidade com
    registros antigos, mas o cadastro realizado pela API exige senha.

5. Valores permitidos para tipo, prioridade e status
    Os valores permitidos serão definidos por restrições `CHECK` no PostgreSQL, além das validações feitas pela aplicação.
    - Tipo de usuário: `usuario` ou `atendente`.
    - Prioridade do chamado: `normal`, `alta` ou `urgente`.
    - Status do chamado: `aberto`, `em_andamento`, `resolvido` ou `fechado`.
    Valores padronizados facilitam os filtros, as contagens e os relatórios, além de evitar variações na escrita dos dados.

6. Separação dos comentários e do histórico
    Comentários serão armazenados em `comentarios`, pois cada chamado pode receber várias mensagens, registradas por usuários diferentes.
    As mudanças de status serão armazenadas em `historico_status`, preservando o registro de cada alteração. A tabela `chamados` manterá apenas o status atual, enquanto o histórico permitirá consultar a evolução do atendimento.
    Essa separação evita acumular várias mensagens ou alterações em um único campo e facilita consultas específicas.

7. Registro inicial e autoria do histórico
    Quando um chamado for aberto, a aplicação deverá criar o chamado e seu registro inicial de histórico na mesma transação. O registro inicial terá `status_anterior` igual a `NULL`, `status_novo` igual a `aberto` e `usuario_id` correspondente ao solicitante.
    Nas mudanças seguintes, o histórico registrará o status anterior, o novo status, o usuário responsável e a data e hora da alteração.
    Os comentários também deverão estar associados ao usuário que os registrou.
    As rotas são protegidas por autenticação, mas a API ainda recebe `usuario_id`
    no corpo das requisições de comentário e de alteração de status. O vínculo
    automático com o usuário autenticado é uma melhoria futura.

8. Datas e horários
    As tabelas utilizarão campos de data e hora para registrar a criação e, quando aplicável, a última atualização dos registros.
    No PostgreSQL, será considerada a utilização de `TIMESTAMPTZ` para armazenar instantes de tempo com referência de fuso horário. Os campos de criação terão valores padrão definidos pelo banco, enquanto as atualizações deverão ser mantidas pela aplicação.

9. Integridade e exclusão de registros
    Os relacionamentos deverão preservar a integridade dos dados. A exclusão de um usuário, categoria ou chamado não deverá apagar silenciosamente informações relevantes de comentários ou histórico.
    Por isso, a implementação utilizará restrições de chave estrangeira com comportamento restritivo para exclusões de registros referenciados, salvo se uma regra específica justificar outra abordagem. A exclusão de registros relacionados deverá ser avaliada explicitamente pela aplicação.

10. Índices
    Além dos índices criados pelas chaves primárias e restrições únicas, serão avaliados índices para consultas frequentes, especialmente:
        - Chamados por status e prioridade.
        - Chamados por data de criação.
        - Chamados por solicitante e categoria.
        - Comentários de um chamado.
        - Histórico de um chamado.
    Os índices serão definidos no `database/schema.sql`, considerando os filtros, relacionamentos e consultas descritos em `database/consultas.sql`. A criação de índices adicionais deverá considerar sua utilidade para as consultas reais do projeto.

11. Transações e consistência
    Operações que dependem da gravação de vários registros deverão utilizar transações quando necessário. Na abertura de um chamado, por exemplo, a criação do chamado e do histórico inicial deverá ser confirmada integralmente ou desfeita em caso de erro.
    Da mesma forma, a alteração do status e a inclusão do respectivo histórico deverão ocorrer na mesma transação, evitando que o status atual fique diferente do histórico registrado.

12. Segurança das credenciais
    As senhas são armazenadas em `senha_hash` utilizando o hash do Laravel, nunca
    em texto puro, e não são retornadas pela API. O login gera um token pelo
    Laravel Sanctum; o banco armazena o hash do token em `personal_access_tokens`,
    e o valor completo é retornado ao cliente somente no login. O logout revoga o
    token atual. O arquivo `.env` não é versionado e as credenciais do PostgreSQL
    permanecem fora do repositório.

13. Documentos relacionados
    Estas decisões complementam os seguintes documentos do projeto:
    - `docs/requisitos.md`: requisitos funcionais e não funcionais.
    - `docs/casos_de_uso.md`: ações realizadas pelos usuários e atendentes.
    - `docs/contrato-api.md`: endpoints e formato das requisições e respostas.
    - `docs/modelo-er/modelo-er.md`: entidades, atributos e relacionamentos.
    - `database/consultas.sql`: consultas previstas para validar e utilizar o modelo.
    O arquivo `database/schema.sql` implementará a estrutura definida nesses documentos, respeitando as decisões registradas aqui.
