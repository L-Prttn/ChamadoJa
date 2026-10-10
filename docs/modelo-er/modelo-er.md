MODELO ENTIDADE-RELACIONAMENTO (ER)

1. Objetivo
    API REST para gerenciamento de chamados de suporte. O modelo foi definido com base nos requisitos, casos de uso e contrato da API elaborados na Semana 1.
    O banco de dados será o PostgreSQL. Contempla usuários, categorias, chamados, comentários e histórico de alterações de status.

2. Entidades
    2. 1. Usuários (`usuarios`)
        Usuários que interagem com o sistema, incluindo solicitantes e atendentes.

        | Atributo          |   Tipo conceitual |   Restrições
        
        | `id`              |   Inteiro         |   Chave primária, gerada automaticamente
        | `nome`            |   Texto           |   Obrigatório
        | `email`           |   Texto           |   Obrigatório e único
        | `senha_hash`      |   Texto           |   Opcional (na versao inicial); deve armazenar somente o hash
        | `tipo`            |   Texto           |   Obrigatório; valores: `usuario` ou `atendente`
        | `criado_em`       |   Data e hora     |   Obrigatório, preenchido automaticamente
        | `atualizado_em`   |   Data e hora     |   Obrigatório, atualizado nas alterações

    2. 2. Categorias (`categorias`)
        Categorias utilizadas para classificar os chamados.

        | Atributo          |   Tipo conceitual |   Restrições
        | `id`              |   Inteiro         |   Chave primária, gerada automaticamente
        | `nome`            |   Texto           |   Obrigatório e único
        | `descricao`       |   Texto           |   Opcional
        | `criado_em`       |   Data e hora     |   Obrigatório, preenchido automaticamente
        | `atualizado_em`   |   Data e hora     |   Obrigatório, atualizado nas alterações

    2. 3. Chamados (`chamados`)
        Chamados abertos pelos usuários e suas informações atuais.

        | Atributo          |   Tipo conceitual |   Restrições

        | `id`              |   Inteiro         |   Chave primária, gerada automaticamente
        | `solicitante_id`  |   Inteiro         |   Obrigatório; chave estrangeira para `usuarios.id`
        | `categoria_id`    |   Inteiro         |   Obrigatório; chave estrangeira para `categorias.id`
        | `titulo`          |   Texto           |   Obrigatório
        | `descricao`       |   Texto           |   Obrigatória
        | `prioridade`      |   Texto           |   Obrigatória; `normal`, `alta` ou `urgente`
        | `status`          |   Texto           |   Obrigatório; `aberto`, `em_andamento`, `resolvido` ou `fechado`
        | `criado_em`       |   Data e hora     |   Obrigatório, preenchido automaticamente
        | `atualizado_em`   |   Data e hora     |   Obrigatório, atualizado nas alterações

        Todo chamado deve possuir um solicitante e uma categoria existentes. O status inicial será `aberto`.

    2. 4. Comentários (`comentarios`)
        Comentários associados aos chamados, permitindo registrar mensagens ao longo do atendimento.

        | Atributo          |   Tipo conceitual |   Restrições

        | `id`              |   Inteiro         |   Chave primária, gerada automaticamente
        | `chamado_id`      |   Inteiro         |   Obrigatório; chave estrangeira para `chamados.id`
        | `usuario_id`      |   Inteiro         |   Obrigatório; chave estrangeira para `usuarios.id`
        | `conteudo`        |   Texto           |   Obrigatório e não vazio
        | `criado_em`       |   Data e hora     |   Obrigatório, preenchido automaticamente

        Cada comentário deve estar associado a um chamado e ao usuário que o registrou.

    2. 5. Histórico de status (`historico_status`)
        Registra as mudanças de status dos chamados, permitindo consultar como o atendimento evoluiu.

        | Atributo          |   Tipo conceitual |   Restrições

        | `id`              |   Inteiro         |   Chave primária, gerada automaticamente
        | `chamado_id`      |   Inteiro         |   Obrigatório; chave estrangeira para `chamados.id`
        | `status_anterior` |   Texto           |   Aceita `NULL` somente no registro inicial; caso contrário, deve ser um status válido
        | `status_novo`     |   Texto           |   Obrigatório; deve ser um status válido
        | `usuario_id`      |   Inteiro         |   Obrigatório; chave estrangeira para `usuarios.id`
        | `criado_em`       |   Data e hora     |   Obrigatório, preenchido automaticamente

        Ao abrir um chamado, será criado um registro inicial no histórico, com `status_anterior` igual a `NULL` e `status_novo` igual a `aberto`. Nesse registro, `usuario_id` corresponderá ao solicitante que abriu o chamado.
        Nas mudanças seguintes, serão registrados o status anterior, o novo status, o usuário responsável e a data e hora da alteração.

3. Relacionamentos e cardinalidades
    - Usuário — Chamados: um usuário pode abrir vários chamados, mas cada chamado possui exatamente um solicitante. Cardinalidade: `usuarios (1) — (N) chamados`.
    - Categoria — Chamados: uma categoria pode estar associada a vários chamados, mas cada chamado pertence a exatamente uma categoria. Cardinalidade: `categorias (1) — (N) chamados`.
    - Chamado — Comentários: um chamado pode possuir vários comentários, mas cada comentário pertence a exatamente um chamado. Cardinalidade: `chamados (1) — (N) comentarios`.
    - Usuário — Comentários: um usuário pode registrar vários comentários, mas cada comentário possui exatamente um autor. Cardinalidade: `usuarios (1) — (N) comentarios`.
    - Chamado — Histórico de status: um chamado pode possuir vários registros de histórico, mas cada registro pertence a exatamente um chamado. Cardinalidade: `chamados (1) — (N) historico_status`.
    - Usuário — Histórico de status: um usuário pode ser responsável por várias alterações, mas cada registro de histórico possui exatamente um usuário responsável. Cardinalidade: `usuarios (1) — (N) historico_status`.

4. Regras de integridade
    - As chaves primárias identificam cada registro de forma única.
    - As chaves estrangeiras garantem que chamados, comentários e registros de histórico estejam associados a registros existentes.
    - O e-mail dos usuários deve ser único.
    - O nome das categorias deve ser único.
    - O tipo de usuário deve ser `usuario` ou `atendente`.
    - A prioridade de um chamado deve ser `normal`, `alta` ou `urgente`.
    - O status de um chamado deve ser `aberto`, `em_andamento`, `resolvido` ou `fechado`.
    - Os comentários não podem ter conteúdo vazio.
    - Toda mudança de status deve gerar um registro no histórico, sem substituir os registros anteriores.
    - O registro inicial do histórico é a única situação em que `status_anterior` pode ser `NULL`.
    - A senha, caso armazenada, nunca deve ser salva em texto puro.

    As restrições de valores permitidos deverão ser implementadas no PostgreSQL, além das validações realizadas pela aplicação.

5. Decisões de modelagem

    - Separação dos comentários
        Os comentários ficam em uma tabela própria porque um chamado pode ter várias mensagens. Armazená-los diretamente na tabela `chamados` dificultaria a inclusão, a consulta e a organização de múltiplos comentários, além de misturar informações do chamado com informações do atendimento.

    - Separação do histórico de status
        O histórico fica em uma tabela própria para preservar cada alteração de status ao longo do tempo. A coluna `status` da tabela `chamados` representa somente o estado atual. Já a tabela `historico_status` registra os estados anteriores e as mudanças realizadas.

    - Identificação dos responsáveis
        Os comentários e as mudanças de status terão um usuário responsável associado. Como a autenticação não é obrigatória na primeira versão, a API deverá receber ou identificar esse usuário de alguma forma. O contrato da API deverá ser ajustado para contemplar essa informação nos endpoints correspondentes.

    - Chamados sem atendente responsável
        Nesta versão, não será incluída uma relação direta entre chamados e um atendente designado. O requisito atual não define essa atribuição. A inclusão poderá ser avaliada futuramente, caso o projeto passe a exigir distribuição de chamados entre atendentes.

    - Exclusão de registros relacionados
        A exclusão de usuários, categorias ou chamados não deverá apagar silenciosamente comentários e históricos importantes. As regras de exclusão e as ações de integridade referencial serão definidas no script SQL, priorizando a preservação dos registros relacionados.

6. Índices previstos
    Além das chaves primárias e das restrições únicas, serão avaliados índices para as consultas mais frequentes:
        - `chamados.status`, para filtrar chamados por status.
        - `chamados.prioridade`, para filtrar e organizar chamados por prioridade.
        - `chamados.criado_em`, para consultas por período e ordenação cronológica.
        - `chamados.solicitante_id` e `chamados.categoria_id`, para relacionamentos e consultas com JOIN.
        - `comentarios.chamado_id`, para buscar comentários de um chamado.
        - `historico_status.chamado_id`, para consultar o histórico de um chamado.

    Os índices definitivos serão implementados no `database/schema.sql`, considerando também as consultas documentadas em `docs/consultas.sql`.

7. Escopo e observações
    Este modelo representa a estrutura inicial do banco de dados do ChamadoJá e poderá ser ajustado conforme a implementação e os testes. As decisões devem permanecer coerentes com `requisitos.md`, `casos-de-uso.md` e o contrato da API.

    O diagrama visual correspondente será documentado em `docs/modelo-er/modelo-er.png`.