REQUISITOS do ChamadoJá

1. Objetivo do sistema:
    
    - API para gerenciamento de chamados de suporte técnico.
    - Organizar as solicitações de suporte realizadas por funcionários e clientes, permitindo registrar quem abriu cada chamado, qual é o problema relatado, sua categoria, prioridade e situação.
    - Permitir acompanhar o atendimento por meio de comentários, alterações de status e histórico das mudanças realizadas.

2. Descrição do problema:

    Atualmente, as solicitações de suporte técnico podem chegar por diferentes meios, como mensagens, ligações e planilhas. Esse processo dificulta a organização e o acompanhamento dos atendimentos.

    Dificuldades:
    - identificar quem abriu cada solicitação;
    - consultar o problema relatado;
    - identificar os chamados mais urgentes;
    - organizar os chamados por categoria;
    - saber quem está acompanhando cada atendimento;
    - identificar chamados pendentes;
    - acompanhar as alterações realizadas nos chamados;
    - obter informações sobre a quantidade de chamados por situação ou categoria.

3. Público usual da aplicação:

    - usuários que abrem solicitações de suporte;
    - atendentes responsáveis pelo acompanhamento dos chamados.

    A aplicação será disponibilizada como uma API e o foco de seu desenvolvimento será no Back-end, não terá uma interface gráfica própria nesta primeira versão. As funcionalidades poderão ser demonstradas utilizando ferramentas para realizar requisições HTTP, como Postman, Insomnia, Bruno ou curl.

4. Requisitos funcionais:

    RF01 - Cadastrar usuários
    RF02 - Consultar usuários
    RF03 - Cadastrar categorias
    RF04 - Consultar categorias
    RF05 - Abrir chamado
        Abertura de um chamado informando, no mínimo:
            - solicitante;
            - categoria;
            - título;
            - descrição;
            - prioridade.
    RF06 - Consultar chamado
    RF07 - Listar chamados
    RF08 - Filtrar chamados
        Filtrar chamados conforme critérios definidos pelo sistema, incluindo status e prioridade.
    RF09 - Paginar chamados
    RF10 - Atualizar chamado
    RF11 - Adicionar comentários
    RF12 - Alterar status
    RF13 - Registrar histórico
        Registrar as alterações de status realizadas nos chamados.
    RF14 - Consultar histórico
        Consultar o histórico de alterações de status de um chamado.
    RF15 - Consultar resumo dos chamados
        Fornecer informações resumidas sobre os chamados, incluindo quantidade por status, prioridade ou categoria.
    RF16 - Validar dados
        O sistema deverá validar os dados recebidos nas requisições e rejeitar dados inválidos.

5. Requisitos não funcionais:

    RNF01 - Tecnologia
        Desenvolvida utilizando PHP e Laravel.
    RNF02 - Banco de dados
        Utilizar PostgreSQL como banco de dados relacional.
    RNF03 - Orientação a objetos
        Seguir uma organização orientada a objetos.
    RNF04 - API REST
        A comunicação com a aplicação deverá ocorrer por meio de uma API HTTP.
    RNF05 - Controle de versão
        Utilizar Git para controle de versão.
    RNF06 - Documentação
        Possuir documentação suficiente para que outra pessoa consiga compreender e executar a aplicação.
    RNF07 - Testes
        Os principais fluxos da aplicação deverão possuir testes.
    RNF08 - Segurança das credenciais
        Senhas, tokens e outras credenciais não deverão ser armazenados no repositório.
    RNF09 - Mensagens de erro
        Deverá retornar mensagens de erro claras quando os dados enviados forem inválidos.
    RNF10 - Códigos HTTP
        Utilizar códigos HTTP adequados para representar o resultado das requisições.

6. Regras iniciais de prioridade e status:

    - Prioridade

    O chamado deverá possuir uma destas prioridades:
    - normal;
    - alta;
    - urgente.

    A prioridade será utilizada para identificar a urgência relativa do atendimento e também poderá ser utilizada como critério de filtro.


    - Status

    O chamado deverá possuir um destes status para representar sua situação no atendimento:
    - aberto;
    - em_andamento;
    - resolvido;
    - fechado.

    As alterações de status deverão ser registradas no histórico do chamado.

7. Limites do escopo

    A primeira versão do ChamadoJá terá como foco o gerenciamento de chamados de suporte técnico.

    Fazem parte do escopo inicial:
    - cadastro e consulta de usuários;
    - cadastro e consulta de categorias;
    - abertura de chamados;
    - consulta de chamados;
    - atualização de chamados;
    - listagem, filtro e paginação;
    - comentários;
    - alteração de status;
    - histórico de alterações;
    - resumo dos chamados;
    - validação dos dados;
    - testes dos principais fluxos;
    - documentação da aplicação.

    Não fazem parte do escopo inicial:
    - desenvolvimento de uma interface web;
    - desenvolvimento de aplicativo mobile;
    - integração com sistemas externos de atendimento;
    - envio de notificações por e-mail ou SMS;
    - sistema comercial ou de cobrança;
    - funcionalidades avançadas de inteligência artificial;
    - implementação obrigatória de autenticação.

    A autenticação será tratada inicialmente como tema de pesquisa. Uma implementação utilizando Laravel Sanctum poderá ser realizada posteriormente como extensão do projeto.

8. Dúvidas e hipóteses da equipe

    Como o projeto está em sua etapa inicial, algumas definições ainda poderão ser refinadas durante o desenvovimento do mesmo.

    Dúvidas:
    - Os valores de prioridade e status definidos inicialmente poderão ser alterados posteriormente?
    - O acompanhamento de um chamado deverá possuir um usuário responsável específico?
    - Quais informações deverão ser apresentadas no resumo dos chamados?
    - Quais regras deverão ser aplicadas ao alterar um chamado que já esteja resolvido ou fechado?

    Hipóteses:
    Enquanto essas questões não forem definidas, será considerado que:

    - um usuário pode abrir vários chamados;
    - um chamado possui somente um solicitante;
    - um chamado pertence a uma categoria;
    - uma categoria pode estar relacionada a vários chamados;
    - um chamado pode possuir vários comentários;
    - um chamado pode possuir vários registros de histórico;
    - alterações de status deverão ser registradas;
    - dados inválidos deverão ser rejeitados pela API;
    - as regras poderão ser refinadas durante o desenvolvimento e as alterações importantes serão registradas na documentação.