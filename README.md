ChamadoJá

API de gerenciamento de chamados desenvolvido como projeto acadêmico.

1. Sobre o projeto
    O ChamadoJá tem como objetivo permitir o cadastro, acompanhamento e
    gerenciamento de chamados, organizando as solicitações e seus respectivos
    atendimentos.

2. Funcionalidades
    - Cadastro e gerenciamento de usuários
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
    - Git/GitHub

4. Documentação
    - Requisitos (docs/requisitos.md)
    - Casos de uso (docs/casos_de_uso.md)
    - Contrato da API (docs/contrato-api.md)
    - Riscos do projeto (docs/riscos.md)
    - Organização de desenvolvimento do projeto (docs/organizacao_projeto.md)
    - Diario de desenvolvimento (docs/diario.md)
    - Modelo Entidade-Relacionamento (docs/modelo-er)
    - Banco de dados (docs/banco-de-dados)

5. Status
    - Em desenvolvimento: etapa de planejamento.

6. Instalação
    - Requisitos
        - PHP 8.2 ou superior
        - Composer
        - PostgreSQL
        - Git
    - Configuração
        - Clone o repositório e entre na pasta do projeto:
            git clone https://github.com/L-Prttn/ChamadoJa.git
            cd ChamadoJa
        - Instale as dependências:
            composer install
        - Crie o arquivo de ambiente:
            cp .env.example .env
        - No Windows PowerShell, utilize:
            Copy-Item .env.example .env
        - Gere a chave da aplicação:
            php artisan key:generate
        - Configure no .env os dados do banco PostgreSQL:
            DB_CONNECTION=pgsql
            DB_HOST=127.0.0.1
            DB_PORT=5432
            DB_DATABASE=chamadoja
            DB_USERNAME=postgres
            DB_PASSWORD=
        - Crie o banco 'chamadoja' no PostgreSQL e execute:
            php artisan migrate:fresh --seed
        - Executar a aplicação
            php artisan serve
        - A rota de saúde pode ser testada em:
            http://127.0.0.1:8000/api/saude


https://github.com/L-Prttn/ChamadoJa.git