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
    - Em desenvolvimento:
        Semana 5 concluída: comentários, histórico de status, regras de
        transição, filtros, paginação e resumo implementados.

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

7. API — Semana 4
    - Rotas implementadas:
    | Método| Rota              | Objetivo              | Sucesso|
    |       |                   |                       |       |
    | GET   | /api/usuarios     | Listar usuários       | 200   |
    | POST  | /api/usuarios     | Cadastrar usuário     | 201   |
    | GET   | /api/categorias   | Listar categorias     | 200   |
    | POST  | /api/categorias   | Cadastrar categoria   | 201   |
    | GET   | /api/chamados     | Listar chamados       | 200   |
    | POST  | /api/chamados     | Abrir chamado         | 201   |
    | GET   | /api/chamados/{id}| Consultar chamado     | 200   |
    | PATCH | /api/chamados/{id}| Atualizar chamado     | 200   |
        As respostas de sucesso utilizam o envelope 'dados'.
    - Exemplo de cadastro de usuário:
        POST /api/usuarios
        {
            "nome": "Usuario Exemplo",
            "email": "usuario@example.test",
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

8. API — Semana 5
    - Novas rotas:
    | Método| Rota                            | Objetivo             | Sucesso|
    |       |                                 |                      |        |
    | GET   | /api/chamados/{id}/comentarios  | Listar comentários   | 200    |
    | POST  | /api/chamados/{id}/comentarios  | Adicionar comentário | 201    |
    | PATCH | /api/chamados/{id}/status       | Alterar status       | 200    |
    | GET   | /api/chamados/{id}/historico    | Consultar histórico  | 200    |
    | GET   | /api/relatorios/resumo-chamados | Consultar resumo     | 200    |
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
            "message": "Transição de status não permitida.",
            "errors": {
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
