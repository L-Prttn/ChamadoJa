CONTRATO DA API do ChamadoJá

Objetivo de definir as principais rotas da API do ChamadoJá, indicando os métodos HTTP, objetivos, dados de entrada e respostas esperadas.
A API será utilizada para abrir, consultar, atualizar e acompanhar chamados de suporte técnico.

1. Chamados
    - GET       /api/chamados
        Objetivo:
            Listar os chamados cadastrados.
            Permitir consulta dos chamados utilizando filtros.

        Entrada:
            Parâmetros opcionais:
                status
                prioridade
                pagina

        Resposta esperada:
            Lista de chamados.
            Informações principais de cada chamado.
            Informações de paginação.

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

        Resposta esperada:
            Chamado criado com sucesso.
            Retorno dos dados do chamado cadastrado.
            O chamado deve receber inicialmente o status aberto.

        Exemplo de resposta:
            {
                "id": 1,
                "solicitante_id": 1,
                "categoria_id": 2,
                "titulo": "Nao consigo acessar o sistema",
                "descricao": "A mensagem de erro aparece depois do login.",
                "prioridade": "alta",
                "status": "aberto"
            }

    - GET       /api/chamados/{id}
        Objetivo:
            Consultar um chamado específico.

        Entrada:
            id do chamado na URL.

        Resposta esperada:
            Dados do chamado solicitado.
            Solicitante.
            Categoria.
            Título.
            Descrição.
            Prioridade.
            Status.

        Em caso de chamado inexistente:
            Retornar erro informando que o chamado não foi encontrado.
    
    - PATCH     /api/chamados/{id}
        Objetivo:
            Atualizar dados de um chamado existente.

        Entrada:
            id do chamado na URL.
            Dados que deverão ser atualizados.

        Resposta esperada:
            Chamado atualizado.
            Retorno dos dados atuais do chamado.

        Validações:
            Chamado deve existir.
            Dados enviados devem ser válidos.
            Valores inválidos devem ser rejeitados.

    - POST      /api/chamados/{id}/comentarios
        Objetivo:
            Adicionar um comentário a um chamado.

        Entrada:
            id do chamado na URL.
            Conteúdo do comentário.

        Exemplo:
            {
                "usuario_id": 1,
                "conteudo": "Problema identificado e em analise."
            }

        Resposta esperada:
            Comentário cadastrado.
            Comentário associado ao chamado correto.

    - PATCH     /api/chamados/{id}/status
        Objetivo:
            Alterar o status de um chamado.

        Entrada:
            id do chamado na URL.
            Novo status.

        Exemplo:
            {
                "status": "em_andamento"
            }

        Status permitidos inicialmente:
            aberto
            em_andamento
            resolvido
            fechado

        Resposta esperada:
            Chamado com o novo status.
            Registro da alteração no histórico.
    
    - GET       /api/chamados/{id}/historico
        Objetivo:
            Consultar o histórico de alterações de status de um chamado.

        Entrada:
            id do chamado na URL.

        Resposta esperada:
            Lista das alterações registradas.
            Status anterior.
            Novo status.
            Data da alteração.
            Usuário responsável pela alteração, caso essa informação esteja definida na implementação.


2. Resumo dos chamados
    - GET       /api/resumo
        Objetivo:
            Consultar um resumo dos chamados cadastrados.

        Resposta esperada:
            Quantidade de chamados por status.
            Quantidade por prioridade.
            Quantidade por categoria.

        *A estrutura definitiva do resumo poderá ser refinada durante o desenvolvimento, conforme as regras definidas nas próximas etapas.


4. Regras gerais
    - Os identificadores utilizados pela API devem seguir o padrão definido para o projeto, sem acentos.
    - Dados obrigatórios devem ser validados.
    - Valores de prioridade devem respeitar os valores definidos no projeto.
    - Valores de status devem respeitar os valores definidos no projeto.
    - Chamados inexistentes devem retornar erro.
    - Alterações de status devem gerar registro no histórico.
    - A API deve utilizar códigos HTTP adequados para cada situação.
    - Mensagens de erro devem ser claras.
    - Prioridades:
        normal
        alta
        urgente
    - Status:
        aberto
        em_andamento
        resolvido
        fechado