CASOS DE USO do ChamadoJá

- UC01 - Cadastrar usuário
    - Ator: Usuário/Atendente
    - Objetivo: Cadastrar um novo usuário.
    - Resultado esperado: O usuário é cadastrado e fica disponível para utilização.

    Critérios de aceite:
    - dados obrigatórios devem ser informados;
    - dados inválidos devem ser rejeitados;
    - usuário cadastrado deve possuir um identificador;
    - o sistema deve informar o resultado do cadastro.

- UC02 - Cadastrar categoria
    - Ator: Atendente
    - Objetivo: Cadastrar uma categoria para organizar os chamados.
    - Resultado esperado: A categoria é cadastrada e pode ser associada aos chamados.

    Critérios de aceite:
    - categoria deve possuir os dados obrigatórios;
    - dados inválidos devem ser rejeitados;
    - a categoria cadastrada deve possuir um identificador.

- UC03 - Abrir chamado
    - Ator: Usuário
    - Objetivo: Registrar uma solicitação de suporte técnico.
    - Resultado esperado: Um novo chamado é criado com solicitante, categoria, título, descrição e prioridade.
    
    Critérios de aceite:
    - o solicitante deve existir;
    - a categoria deve existir;
    - título e descrição devem ser informados;
    - a prioridade deve aceitar somente valores definidos;
    - o chamado deve receber um status inicial;
    - a API deve retornar os dados do chamado criado.

- UC04 - Consultar chamado
    - Ator: Usuário/Atendente
    - Objetivo: Consultar as informações de um chamado específico.
    - Resultado esperado: A API retorna os dados do chamado solicitado.

    Critérios de aceite:
    - o identificador do chamado deve ser informado;
    - caso o chamado não exista, a API deve retornar um erro adequado;
    - a resposta deve apresentar as principais informações do chamado.

- UC05 - Listar e filtrar chamados
    - Ator: Atendente
    - Objetivo: Consultar os chamados cadastrados e localizar atendimentos conforme seus critérios.
    - Resultado esperado: A API retorna uma lista de chamados que corresponde aos filtros informados.

    Critérios de aceite:
    - a listagem deve permitir paginação;
    - o filtro de status deve aceitar somente valores definidos;
    - o filtro de prioridade deve aceitar somente valores definidos;
    - a resposta deve informar os resultados encontrados;
    - a ausência de filtros deve permitir consultar a listagem geral.

- UC06 - Atualizar chamado
    - Ator: Atendente
    - Objetivo: Atualizar informações de um chamado existente.
    - Resultado esperado: Os dados permitidos do chamado são atualizados.

    Critérios de aceite:
    - o chamado deve existir;
    - os dados enviados devem ser validados;
    - dados inválidos devem ser rejeitados;
    - a API deve informar o resultado da atualização.

- UC07 - Adicionar comentário
    - Ator: Atendente
    - Objetivo: Registrar uma informação ou atualização relacionada ao atendimento de um chamado.
    - Resultado esperado: Um novo comentário é associado ao chamado.

    Critérios de aceite:
    - o chamado deve existir;
    - o comentário deve possuir conteúdo válido;
    - o comentário deve ser associado ao chamado correto;
    - a API deve informar o resultado da operação.

- UC08 - Alterar status do chamado
    - Ator: Atendente
    - Objetivo: Atualizar a situação de um chamado durante o atendimento.
    - Resultado esperado: O chamado passa para o novo status informado e a alteração é registrada no histórico.

    Critérios de aceite:
    - o chamado deve existir;
    - o novo status deve ser um valor definido pelo sistema;
    - o status atual deve ser atualizado;
    - a alteração deve gerar um registro no histórico.

- UC09 - Consultar histórico do chamado
    - Ator: Atendente
    - Objetivo: Consultar as alterações de status realizadas em um chamado.
    - Resultado esperado: A API apresenta o histórico de alterações do chamado.

    Critérios de aceite:
    - o chamado deve existir;
    - o histórico deve apresentar as alterações registradas;
    - as informações devem estar associadas ao chamado correto.

- UC10 - Consultar resumo dos chamados
    - Ator: Atendente
    - Objetivo: Obter informações consolidadas sobre os chamados cadastrados.
    - Resultado esperado: A API apresenta quantidades de chamados agrupadas por critérios como status, prioridade ou categoria.

    Critérios de aceite:
    - os dados apresentados devem corresponder aos chamados cadastrados;
    - o resumo deve permitir identificar a quantidade de chamados;
    - os agrupamentos devem considerar os critérios definidos pela API.