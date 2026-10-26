DIÁRIO DO PROJETO

01. Semana 01 — Planejamento do projeto
    - Encontro 1
        Data: 28/09/2026

        - O que foi feito:
            - Leitura e análise do briefing do projeto.
            - Definição do objetivo do sistema.
            - Identificação do problema.
            - Identificação dos principais usuários.
            - Definição inicial dos requisitos funcionais.
            - Definição inicial dos requisitos não funcionais.
            - Definição das regras iniciais de prioridade e status.
            - Definição dos limites do escopo inicial.
            - Identificação de dúvidas e hipóteses do projeto.
            - Elaboração dos primeiros casos de uso.

        - Decisões tomadas:
            - A primeira versão será desenvolvida como uma API, sem interface visual.
            - A autenticação será feita posteriormente.
            - As regras ainda não definidas serão tratadas como hipóteses e poderão ser refinadas conforme as próximas etapas forem liberadas.

        - Testes realizados:
            - Ainda não foram realizados.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta ChatGPT como apoio ao planejamento e à organização da documentação inicial do projeto. Todo o conteúdo gerado foi revisado e compreendido pelo desenvolvedor antes de ser utilizado.

    - Encontro 2
        Data: 30/09/2026

        - O que foi feito:
            - Revisão e refinamento da documentação inicial.
            - Definição e documentação do contrato inicial da API.
            - Definição das principais rotas e operações da API.
            - Identificação e documentação dos principais riscos.
            - Documentação da organização do projeto.
            - Criação da primeira versão do README.

        - Decisões tomadas:
            - O README inicial será mantido resumido e será atualizado conforme o desenvolvimento avançar.
            - Os riscos do projeto serão acompanhados durante as próximas etapas e poderão ser atualizados conforme novos problemas forem identificados.

        - Testes realizados:
            - Ainda não foram realizados.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta ChatGPT como apoio à revisão, definição e organização. Todo o conteúdo gerado foi revisado e compreendido pelo desenvolvedor antes de ser utilizado.

02. Semana 02 — Modelo relacional e consultas PostgreSQL
    - Encontro 1
        Data: 05/10/2026

        - O que foi feito:
            - Elaboração da documentação do modelo entidade-relacionamento.
            - Definição das entidades, atributos, chaves primárias e chaves estrangeiras.
            - Definição dos relacionamentos e das cardinalidades entre as entidades.
            - Criação do diagrama visual do modelo e-r.
            - Documentação das decisões relacionadas ao banco de dados.
            - Criação do script SQL para estruturar as tabelas no PostgreSQL.
            - Definição das restrições de integridade e dos valores permitidos para tipo de usuário, prioridade e status.
            - Criação dos índices para apoiar as consultas previstas.

        - Decisões tomadas:
            - O PostgreSQL será utilizado como sistema gerenciador de banco de dados.
            - O modelo será composto por 5 tabelas.
            - Os comentários e o histórico de status serão armazenados em tabelas separadas.
            - A abertura de chamados e as alterações de status deverão registrar o histórico na mesma transação da operação correspondente.
            - Os valores de prioridade e status seguirão as definições dos requisitos do projeto.
            - As exclusões de registros relacionados serão restringidas para preservar a integridade dos dados.

        - Testes realizados:
            - Execução e validação do script de criação das tabelas no PostgreSQL.
            - Execução e validação das restrições e dos relacionamentos definidos no esquema.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta ChatGPT como apoio à revisão do modelo entidade-relacionamento, à documentação das decisões do banco de dados e à criação do script SQL. Todo o conteúdo gerado foi revisado e compreendido pelo desenvolvedor antes de ser utilizado.

    - Encontro 2
        Data: 07/10/2026

        - O que foi feito:
            - Criação do script seed.sql com dados fictícios para testes.
            - Criação do arquivo consultas.sql.
            - Elaboração de consultas de testes do bando de dados.
            - Validação dos scripts de inserção de dados e das consultas SQL.

        - Decisões tomadas:
            - Os dados utilizados nos testes serão fictícios, gerados por IA.
            - Os dados de teste contemplarão diferentes prioridades e status para permitir validar as consultas.
            - As consultas SQL serão mantidas em arquivo separado para facilitar sua organização e execução.
            - A estrutura do banco e as consultas deverão permanecer coerentes com os requisitos, os casos de uso e o contrato da API.

        - Testes realizados:
            - Execução e validação do script seed.sql.
            - Execução e validação das consultas documentadas em consultas.sql.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta ChatGPT como apoio à revisão e organização dos scripts SQL. Todo o conteúdo gerado foi revisado e compreendido pelo desenvolvedor antes de ser utilizado.

03. Semana 03 — Base Laravel e persistência
    - Encontro 1
        Data: 18/10/2026

        - O que foi feito:
            - Inicialização da aplicação Laravel.
            - Configuração do Composer e das dependências.
            - Criação do arquivo '.env.example'.
            - Configuração da conexão com PostgreSQL.
            - Criação das migrations para usuários, categorias, chamados, comentários e histórico de status.
            - Definição das chaves estrangeiras, restrições e índices.
            - Criação da rota 'GET /api/saude'.

        - Testes realizados:
            - Execução de 'php artisan migrate'.
            - Execução de 'php artisan migrate:fresh --seed'.
            - Verificação da rota 'GET /api/saude'.
            - Resposta obtida:
              '{"dados":{"aplicacao":"ChamadoJá","status":"funcionando"}}'

    - Encontro 2
        Data: 18/10/2026

        - O que foi feito:
            - Criação dos models Eloquent.
            - Configuração dos relacionamentos entre usuários, categorias, chamados, comentários e histórico.
            - Criação dos seeders.
            - Inserção de dados fictícios relacionados.
            - Atualização das instruções de instalação no README.

        - Testes realizados:
            - Execução de 'php artisan migrate:fresh --seed'.
            - Verificação da criação dos usuários, categorias, chamados, comentários e históricos.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta ChatGPT como apoio à revisão da base Laravel, das migrations, dos models, dos relacionamentos e dos seeders. Todo o conteúdo foi revisado e compreendido pelo desenvolvedor.

04. Semana 04 — API principal de usuários, categorias e chamados
    - Encontro 1
        Data: 25/10/2026

        - O que foi feito:
            - Criação dos controllers, Form Requests e rotas de usuários, categorias e chamados.
            - Implementação das validações de campos obrigatórios, unicidade, existência de registros, tamanhos e prioridades.
            - Definição do status inicial 'aberto' no servidor.
            - Organização dos controllers para utilizar Form Requests e models Eloquent.

        - Decisões tomadas:
            - As prioridades continuam sendo 'normal', 'alta' e 'urgente'.
            - O status inicial do chamado será sempre 'aberto'.
            - A atualização permitirá apenas categoria_id, titulo, descricao e prioridade.
            - solicitante_id e status não poderão ser alterados pela rota PATCH.
            - O cadastro de usuário não receberá senha nesta etapa.
            - Filtros e paginação ficam para a próxima etapa.

        - Testes realizados:
            - Ainda não foram realizados neste encontro.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta Codex como apoio à definição das rotas, controllers, validações e organização do código. Todo o conteúdo foi revisado, aplicado e compreendido pelo desenvolvedor.

    - Encontro 2
        Data: 25/10/2026

        - O que foi feito:
            - Criação dos Resources de usuários, categorias e chamados.
            - Padronização das respostas com o envelope 'dados'.
            - Inclusão dos relacionamentos solicitante e categoria no Resource de chamados.
            - Implementação de resposta JSON para recursos inexistentes.
            - Correção do fuso horário da conexão PostgreSQL para UTC.
            - Execução dos testes manuais dos endpoints.
            - Atualização do contrato da API, README e diário.

        - Decisões tomadas:
            - Criações retornarão HTTP 201.
            - Consultas e atualizações retornarão HTTP 200.
            - Dados inválidos retornarão HTTP 422.
            - Recursos inexistentes retornarão HTTP 404 com mensagem JSON.
            - Comentários, alteração de status, histórico, filtros, paginação e resumo ficam para as próximas etapas.

        - Testes realizados:
            - Testes manuais dos endpoints com PowerShell.
            - Cadastro válido de usuário e categoria: resposta 201.
            - Email e nome de categoria repetidos: resposta 422.
            - Abertura de chamado válida: resposta 201 com status 'aberto'.
            - Consulta e atualização de chamado: resposta 200.
            - Dados inválidos, solicitante inexistente e categoria inexistente: resposta 422.
            - Chamado inexistente: resposta 404.
            - Verificação da coerência dos timestamps após a correção do fuso horário.

        - Uso de inteligência artificial:
            Foi utilizada a ferramenta Codex como apoio à implementação, revisão, correção do fuso horário e organização da documentação. Todo o conteúdo foi revisado, aplicado e testado pelo desenvolvedor.