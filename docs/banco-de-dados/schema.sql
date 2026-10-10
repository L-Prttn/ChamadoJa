
BEGIN;

-- =====================================================
-- Tabela: usuarios
-- Armazena solicitantes e atendentes.
-- A senha é opcional nesta versão, pois a autenticação
-- não faz parte do escopo obrigatório inicial.
-- Quando utilizada, deve conter somente o hash.
-- =====================================================

CREATE TABLE usuarios (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha_hash TEXT,
    tipo VARCHAR(20) NOT NULL,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_usuarios_tipo
        CHECK (tipo IN ('usuario', 'atendente'))
);

-- =====================================================
-- Tabela: categorias
-- Classifica os chamados de suporte.
-- =====================================================

CREATE TABLE categorias (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- Tabela: chamados
-- Mantém os dados e o status atual de cada chamado.
-- =====================================================

CREATE TABLE chamados (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    solicitante_id INTEGER NOT NULL,
    categoria_id INTEGER NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade VARCHAR(20) NOT NULL DEFAULT 'normal',
    status VARCHAR(20) NOT NULL DEFAULT 'aberto',
    criado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_chamados_solicitante
        FOREIGN KEY (solicitante_id)
        REFERENCES usuarios (id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_chamados_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categorias (id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_chamados_prioridade
        CHECK (prioridade IN ('normal', 'alta', 'urgente')),

    CONSTRAINT chk_chamados_status
        CHECK (
            status IN (
                'aberto',
                'em_andamento',
                'resolvido',
                'fechado'
            )
        )
);

-- =====================================================
-- Tabela: comentarios
-- Registra mensagens associadas aos chamados.
-- =====================================================

CREATE TABLE comentarios (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    chamado_id INTEGER NOT NULL,
    usuario_id INTEGER NOT NULL,
    conteudo TEXT NOT NULL,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comentarios_chamado
        FOREIGN KEY (chamado_id)
        REFERENCES chamados (id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_comentarios_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios (id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_comentarios_conteudo
        CHECK (LENGTH(TRIM(conteudo)) > 0)
);

-- =====================================================
-- Tabela: historico_status
-- Registra a evolução do status dos chamados.
-- O primeiro registro utiliza status_anterior NULL.
-- =====================================================

CREATE TABLE historico_status (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    chamado_id INTEGER NOT NULL,
    status_anterior VARCHAR(20),
    status_novo VARCHAR(20) NOT NULL,
    usuario_id INTEGER NOT NULL,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_historico_chamado
        FOREIGN KEY (chamado_id)
        REFERENCES chamados (id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_historico_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios (id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_historico_status_anterior
        CHECK (
            status_anterior IS NULL
            OR status_anterior IN (
                'aberto',
                'em_andamento',
                'resolvido',
                'fechado'
            )
        ),

    CONSTRAINT chk_historico_status_novo
        CHECK (
            status_novo IN (
                'aberto',
                'em_andamento',
                'resolvido',
                'fechado'
            )
        ),

    CONSTRAINT chk_historico_transicao
        CHECK (
            (
                status_anterior IS NULL
                AND status_novo = 'aberto'
            )
            OR
            (
                status_anterior IS NOT NULL
                AND status_anterior <> status_novo
            )
        )
);

-- =====================================================
-- Índices para filtros, ordenação e relacionamentos.
-- Chaves primárias e restrições UNIQUE já criam índices.
-- =====================================================

CREATE INDEX idx_chamados_status
    ON chamados (status);

CREATE INDEX idx_chamados_prioridade
    ON chamados (prioridade);

CREATE INDEX idx_chamados_criado_em
    ON chamados (criado_em);

CREATE INDEX idx_chamados_solicitante_id
    ON chamados (solicitante_id);

CREATE INDEX idx_chamados_categoria_id
    ON chamados (categoria_id);

CREATE INDEX idx_comentarios_chamado_criado_em
    ON comentarios (chamado_id, criado_em);

CREATE INDEX idx_historico_chamado_criado_em
    ON historico_status (chamado_id, criado_em);

COMMIT;