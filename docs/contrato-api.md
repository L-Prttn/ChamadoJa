CONTRATO DA API do ChamadoJá

Objetivo de definir as principais rotas da API do ChamadoJá, indicando os métodos HTTP, objetivos, dados de entrada e respostas esperadas.
A API será utilizada para abrir, consultar, atualizar e acompanhar chamados de suporte técnico.

Situação atual:
- Rotas de usuários, categorias e chamados implementadas na Semana 4.
- Comentários, alteração de status, histórico, filtros, paginação e resumo estão previstos para as próximas etapas.
- A autenticação não é obrigatória nesta primeira versão.

1. Usuários

    - GET       /api/usuarios
        Objetivo:
            Listar os usuários cadastrados.

        Entrada:
            Nenhum parâmetro obrigatório.

        Resposta esperada:
            Lista de usuários.
            Cada usuário deve apresentar id, nome, email, tipo, criado_em e atualizado_em.
            O campo senha_hash não deve ser retornado.

        Exemplo de resposta:
            {
                "dados": [
                    {
                        "id": 1,
                        "nome": "Ana Souza",
                        "email": "ana.souza@example.test",
                        "tipo": "usuario",
                        "criado_em": "2026-10-19T05:05:34.000000Z",
                        "atualizado_em": "2026-10-19T05:05:34.000000Z"
                    }
                ]
            }

    - POST      /api/usuarios
        Objetivo:
            Cadastrar um novo usuário.

        Entrada:
            {
                "nome": "Usuario Exemplo",
                "email": "usuario@example.test",
                "tipo": "usuario"
            }

        Validações:
            nome: obrigatório, texto, máximo de 150 caracteres;
            email: obrigatório, email válido, máximo de 255 caracteres e único;
            tipo: obrigatório; valores permitidos: usuario ou atendente.

        Resposta esperada:
            Usuário criado com sucesso.
            Retorno dos dados do usuário cadastrado.
            Código HTTP 201.

        Exemplo de resposta:
            {
                "dados": {
                    "id": 2,
                    "nome": "Usuario Exemplo",
                    "email": "usuario@example.test",
                    "tipo": "usuario",
                    "criado_em": "2026-10-26T03:05:05.000000Z",
                    "atualizado_em": "2026-10-26T03:05:05.000000Z"
                }
            }

        Em caso de email já cadastrado:
            Retornar código HTTP 422 com mensagem e erros de validação.

2. Categorias

    - GET       /api/categorias
        Objetivo:
            Listar as categorias cadastradas.

        Entrada:
            Nenhum parâmetro obrigatório.

        Resposta esperada:
            Lista de categorias.
            Cada categoria deve apresentar id, nome, descricao, criado_em e atualizado_em.

        Exemplo de resposta:
            {
                "dados": [
                    {
                        "id": 1,
                        "nome": "Hardware",
                        "descricao": "Problemas relacionados a computadores e periféricos.",
                        "criado_em": "2026-10-19T05:05:34.000000Z",
                        "atualizado_em": "2026-10-19T05:05:34.000000Z"
                    }
                ]
            }

    - POST      /api/categorias
        Objetivo:
            Cadastrar uma nova categoria.

        Entrada:
            {
                "nome": "Impressoras",
                "descricao": "Problemas relacionados a impressoras e scanners."
            }

        Validações:
            nome: obrigatório, texto, máximo de 100 caracteres e único;
            descricao: opcional, texto.

        Resposta esperada:
            Categoria criada com sucesso.
            Retorno dos dados da categoria cadastrada.
            Código HTTP 201.

        Exemplo de resposta:
            {
                "dados": {
                    "id": 4,
                    "nome": "Impressoras",
                    "descricao": "Problemas relacionados a impressoras e scanners.",
                    "criado_em": "2026-10-26T03:05:05.000000Z",
                    "atualizado_em": "2026-10-26T03:05:05.000000Z"
                }
            }

        Em caso de nome já cadastrado:
            Retornar código HTTP 422 com mensagem e erros de validação.

3. Chamados

    - GET       /api/chamados
        Objetivo:
            Listar os chamados cadastrados.

        Entrada:
            Nenhum parâmetro obrigatório nesta etapa.

        Parâmetros previstos para a próxima etapa:
            status
            prioridade
            pagina

        Resposta esperada:
            Lista de chamados.
            Cada chamado deve apresentar id, titulo, descricao, prioridade, status, solicitante, categoria, criado_em e atualizado_em.

        Exemplo de resposta:
            {
                "dados": [
                    {
                        "id": 1,
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
                        },
                        "criado_em": "2026-10-19T05:05:34.000000Z",
                        "atualizado_em": "2026-10-19T05:05:34.000000Z"
                    }
                ]
            }

    - POST      /api/chamados
        Objetivo:
            Abrir um novo chamado.

        Entrada:
            {
                "solicitante_id": 1,
                "categoria_id": 2,
                "titulo": "Nao consigo acessar o sistema",
                "descricao": "A mensagem de erro aparece depois do login.",
                "prioridade": "alta"
            }

        Validações:
            solicitante_id: obrigatório, inteiro e deve existir em usuarios;
            categoria_id: obrigatório, inteiro e deve existir em categorias;
            titulo: obrigatório, texto, máximo de 120 caracteres;
            descricao: obrigatório, texto, mínimo de 10 caracteres;
            prioridade: obrigatório; valores permitidos: normal, alta ou urgente.

        Regra de status:
            O chamado deve ser criado com status aberto.
            O status não deve ser aceito como dado enviado pelo cliente.

        Resposta esperada:
            Chamado criado com sucesso.
            Retorno dos dados do chamado cadastrado.
            Código HTTP 201.

        Exemplo de resposta:
            {
                "dados": {
                    "id": 5,
                    "titulo": "Nao consigo acessar o sistema",
                    "descricao": "A mensagem de erro aparece depois do login.",
                    "prioridade": "alta",
                    "status": "aberto",
                    "solicitante": {
                        "id": 1,
                        "nome": "Ana Souza"
                    },
                    "categoria": {
                        "id": 2,
                        "nome": "Software"
                    },
                    "criado_em": "2026-10-26T03:05:05.000000Z",
                    "atualizado_em": "2026-10-26T03:05:05.000000Z"
                }
            }

        Em caso de dados inválidos:
            Retornar código HTTP 422 com mensagem e erros de validação.

    - GET       /api/chamados/{id}
        Objetivo:
            Consultar um chamado específico.

        Entrada:
            id do chamado na URL.

        Resposta esperada:
            Dados do chamado solicitado.
            Solicitante.
            Categoria.
            Titulo.
            Descricao.
            Prioridade.
            Status.
            Datas de criacao e atualizacao.

        Em caso de chamado inexistente:
            Retornar código HTTP 404 com a mensagem:
            {
                "message": "Recurso nao encontrado."
            }

    - PATCH     /api/chamados/{id}
        Objetivo:
            Atualizar dados permitidos de um chamado existente.

        Entrada:
            id do chamado na URL.
            Dados que deverão ser atualizados.

        Campos permitidos:
            categoria_id
            titulo
            descricao
            prioridade

        Campos não permitidos nesta rota:
            solicitante_id
            status

        Validações:
            O chamado deve existir;
            categoria_id, quando enviado, deve existir em categorias;
            titulo, quando enviado, deve ser texto com no máximo 120 caracteres;
            descricao, quando enviada, deve ser texto com no mínimo 10 caracteres;
            prioridade, quando enviada, deve ser normal, alta ou urgente.

        Resposta esperada:
            Chamado atualizado.
            Retorno dos dados atuais do chamado.
            Código HTTP 200.

        Em caso de dados inválidos:
            Retornar código HTTP 422 com mensagem e erros de validação.

        Em caso de chamado inexistente:
            Retornar código HTTP 404 com a mensagem de recurso não encontrado.

    - POST      /api/chamados/{id}/comentarios
        Situação:
            Previsto para a próxima etapa.

        Objetivo:
            Adicionar um comentário a um chamado.

        Entrada:
            id do chamado na URL.
            usuario_id e conteudo do comentário.

        Exemplo:
            {
                "usuario_id": 1,
                "conteudo": "Problema identificado e em analise."
            }

        Resposta esperada:
            Comentário cadastrado.
            Comentário associado ao chamado correto.

    - PATCH     /api/chamados/{id}/status
        Situação:
            Previsto para a próxima etapa.

        Objetivo:
            Alterar o status de um chamado.

        Entrada:
            id do chamado na URL.
            Novo status.

        Exemplo:
            {
                "status": "em_andamento"
            }

        Status permitidos:
            aberto
            em_andamento
            resolvido
            fechado

        Resposta esperada:
            Chamado com o novo status.
            Registro da alteração no histórico.

    - GET       /api/chamados/{id}/historico
        Situação:
            Previsto para a próxima etapa.

        Objetivo:
            Consultar o histórico de alterações de status de um chamado.

        Entrada:
            id do chamado na URL.

        Resposta esperada:
            Lista das alterações registradas.
            Status anterior.
            Novo status.
            Data da alteração.
            Usuário responsável pela alteração.

4. Resumo dos chamados

    - GET       /api/resumo
        Situação:
            Previsto para uma etapa futura.

        Objetivo:
            Consultar um resumo dos chamados cadastrados.

        Resposta esperada:
            Quantidade de chamados por status.
            Quantidade por prioridade.
            Quantidade por categoria.

        *A estrutura definitiva do resumo poderá ser refinada durante o desenvolvimento.

5. Regras gerais

    - As respostas de sucesso das rotas de recursos utilizam o envelope dados.
    - Os identificadores utilizados pela API devem seguir o padrão definido para o projeto, sem acentos.
    - Dados obrigatórios devem ser validados.
    - Valores de prioridade devem respeitar os valores definidos no projeto.
    - Valores de status devem respeitar os valores definidos no projeto.
    - Chamados inexistentes devem retornar código HTTP 404.
    - Dados inválidos devem retornar código HTTP 422.
    - Criações devem retornar código HTTP 201.
    - Consultas e atualizações devem retornar código HTTP 200.
    - A API deve utilizar mensagens de erro claras.
    - A autenticação não é obrigatória nesta primeira versão.
    - O campo senha_hash nunca deve ser retornado nas respostas.
    - Prioridades:
        normal
        alta
        urgente
    - Status:
        aberto
        em_andamento
        resolvido
        fechado