DIÁRIO DO PROJETO

01. Semana 01 — Planejamento do projeto
    Encontros: 1 (28/09/2026) e 2 (30/09/2026)

    - O que foi feito:
        - Definição do objetivo, problema, público, requisitos iniciais, prioridades, status, escopo e casos de uso.
        - Criação do contrato inicial da API, riscos, organização do projeto e primeira versão do README.

    - Decisões:
        - A primeira versão será uma API, sem interface web ou aplicativo.
        - A autenticação será tratada posteriormente.
        - Regras ainda não definidas serão mantidas como hipóteses até nova decisão.

    - Testes:
        - Ainda não realizados nesta etapa.

    - Uso de IA:
        ChatGPT como apoio ao planejamento, contrato da API e organização da documentação. Conteúdo revisado pelo desenvolvedor.

02. Semana 02 — Modelo relacional e consultas PostgreSQL
    Encontros: 1 (05/10/2026) e 2 (07/10/2026)

    - O que foi feito:
        - Modelo ER com as entidades usuarios, categorias, chamados, comentarios e historico_status.
        - Definição de relacionamentos, cardinalidades, chaves, restrições, índices e regras de exclusão.
        - Criação de schema.sql, seed.sql e consultas.sql, com dados fictícios para validação.

    - Decisões:
        - PostgreSQL como banco de dados.
        - Comentários e histórico em tabelas separadas.
        - Abertura de chamado e alteração de status registram histórico na mesma transação.
        - Exclusões de registros relacionados serão restritivas.

    - Testes:
        - Execução do schema, das restrições, do seed e das consultas SQL no PostgreSQL.

    - Uso de IA:
        ChatGPT como apoio ao modelo ER, às decisões do banco e aos scripts SQL. Conteúdo revisado pelo desenvolvedor.

03. Semana 03 — Base Laravel e persistência
    Encontros: 1 e 2 (18/10/2026)

    - O que foi feito:
        - Inicialização do Laravel, configuração do Composer, .env.example e conexão com PostgreSQL.
        - Criação das migrations, models, relacionamentos e seeders.
        - Criação da rota GET /api/saude.

    - Decisões:
        - Manter PostgreSQL e a estrutura de cinco tabelas de negócio.
        - Persistir os relacionamentos e dados fictícios pelos seeders.

    - Testes:
        - php artisan migrate e php artisan migrate:fresh --seed executados.
        - Verificação da rota de saúde e dos registros criados.

    - Uso de IA:
        Codex como apoio à base Laravel, migrations, models, relacionamentos e seeders. Conteúdo revisado pelo desenvolvedor.

04. Semana 04 — API principal de usuários, categorias e chamados
    Encontros: 1 e 2 (25/10/2026)

    - O que foi feito:
        - Controllers, Form Requests, Resources e rotas de usuários, categorias e chamados.
        - Validações de campos obrigatórios, unicidade, existência, tamanhos e prioridades.
        - Respostas com envelope dados, relacionamentos resumidos e erro JSON para recurso inexistente.
        - Correção do fuso horário da conexão PostgreSQL para UTC.

    - Decisões:
        - Todo chamado nasce com status aberto.
        - A atualização aceita apenas categoria_id, titulo, descricao e prioridade.
        - Criações retornam 201; consultas e atualizações, 200; dados inválidos, 422; recurso inexistente, 404.
        - O cadastro ainda não recebia senha nesta etapa.

    - Testes:
        - Testes manuais dos endpoints com PowerShell, incluindo cadastros, consultas, atualizações e erros.

    - Uso de IA:
        Codex como apoio às rotas, controllers, validações, Resources e correção de fuso. Conteúdo revisado e testado pelo desenvolvedor.

05. Semana 05 — Regras de negócio e consultas integradas
    Encontros: 1 e 2 (02/11/2026)

    - O que foi feito:
        - Comentários, alteração de status, histórico e consulta de histórico.
        - Registro da abertura do chamado e das mudanças de status na mesma transação.
        - Filtros por status, prioridade, categoria e solicitante.
        - Paginação, ordenação e resumo por status, prioridade e categoria.

    - Decisões:
        - Status: aberto, em_andamento, resolvido e fechado.
        - Transições: aberto -> em_andamento; em_andamento -> resolvido; resolvido -> fechado ou em_andamento; fechado -> nenhuma.
        - Prioridades: normal, alta e urgente, com peso urgente, alta e normal na ordenação.
        - Paginação padrão de 15, com por_pagina entre 1 e 100.
        - O resumo sempre retorna todas as chaves de status e prioridade, inclusive com zero.

    - Testes:
        - Testes manuais de comentários, transições válidas e inválidas, histórico, filtros, ordenação, paginação e resumo.

    - Uso de IA:
        Codex como apoio às regras de transição, comentários, filtros, paginação e resumo. Conteúdo revisado e testado pelo desenvolvedor.

06. Semana 06 — Autenticação, segurança e qualidade da API
    Encontros: 1 (09/11/2026), 2 (11/11/2026) e 3 extra (22/11/2026)

    - O que foi feito:
        - Pesquisa sobre autenticação, autorização, hash, tokens e Laravel Sanctum.
        - Configuração do PHPUnit com PostgreSQL e banco chamadoja_test.
        - Criação de factories e testes de feature para usuários, categorias, chamados e comentários.
        - Padronização dos erros 401, 403, 404, 422 e 429 e tradução das validações para português.
        - Instalação do Sanctum, criação de personal_access_tokens, login, logout e proteção das rotas.
        - Cadastro com senha e confirmação, armazenando apenas o hash em senha_hash.

    - Decisões:
        - O banco de testes permanece separado do banco de desenvolvimento.
        - As respostas de erro usam as chaves mensagem e erros.
        - A autenticação foi implementada como extensão opcional da Semana 6.
        - Permanecem públicos GET /api/saude, POST /api/login e POST /api/usuarios.
        - Não há autorização por tipo de usuário; o usuario_id ainda é informado no corpo.
        - Usuários antigos sem senha não conseguem autenticar.

    - Testes:
        - php -l sem erros de sintaxe.
        - php artisan test: 17 testes e 79 asserções após a configuração inicial.
        - php artisan test: 22 testes e 100 asserções após o Sanctum.
        - Login, senha incorreta, logout e acesso sem token cobertos por testes.

    - Uso de IA:
        Codex como apoio à pesquisa, testes, padronização de erros, tradução e implementação do Sanctum. Conteúdo revisado e testado pelo desenvolvedor.

07. Semana 07 — Testes finais, documentação e entrega
    Encontros: 1 e 2 (22/11/2026)

    - O que foi feito:
        - Teste automatizado do resumo de chamados e ampliação da suíte para 23 testes e 116 asserções.
        - Instalação limpa em pasta e banco separados, com migrations, seeders, testes e API em funcionamento.
        - README final com instalação sequencial, 16 endpoints, exemplos, regras e limitações.
        - Revisão de requisitos, casos de uso, modelo ER, decisões do banco e pesquisa de autenticação.
        - Auditoria de segurança do repositório e das dependências.
        - Atualização de Laravel e componentes Symfony para corrigir avisos de segurança.

    - Decisões:
        - PostgreSQL permanece como banco de desenvolvimento e de testes.
        - A estrutura e os nomes atuais dos arquivos foram mantidos.
        - A autenticação foi registrada como extensão implementada.
        - personal_access_tokens foi documentada como tabela de apoio do Sanctum.
        - As credenciais dos seeders são fictícias e foram documentadas no README.

    - Testes:
        - php artisan test: 23 testes e 116 asserções, todos aprovados.
        - composer audit antes da atualização: 9 avisos em 6 pacotes.
        - composer audit após a atualização: nenhum aviso de segurança.
        - .env ignorado, .env.example sem chave ou senha e nenhum token real no histórico.
        - Instalação limpa validada com rota de saúde, login e consulta autenticada de chamados.

    - Pendências:
        - Revisão entre equipes, que será realizada em aula.
        - Commit final release: semana 07 - projeto final.
        - Criação e envio da tag v1.0.0.
        - Reinstalação opcional com a versão final.

    - Uso de IA:
        Codex como apoio aos testes finais, README, revisão documental, auditoria de segurança e atualização de dependências. Conteúdo revisado e validado pelo desenvolvedor.

ESTADO FINAL
    - API com 16 rotas, PostgreSQL e autenticação com Sanctum.
    - 23 testes e 116 asserções aprovados.
    - Nenhum aviso de segurança no composer audit.
    - Documentação revisada e instalação limpa validada.
    - Pendentes: revisão entre equipes, commit final, tag v1.0.0 e push.
