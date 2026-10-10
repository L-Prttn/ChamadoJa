-- =====================================================
-- ChamadoJá - Consultas PostgreSQL
-- Consultas para validar o modelo e apoiar os requisitos.
-- =====================================================

-- 1. Listar chamados abertos.
SELECT id, titulo, prioridade, status, criado_em
FROM chamados
WHERE status = 'aberto'
ORDER BY criado_em DESC;

-- 2. Listar chamados em atendimento.
SELECT id, titulo, prioridade, status, criado_em
FROM chamados
WHERE status = 'em_andamento'
ORDER BY criado_em DESC;

-- 3. Listar chamados ordenados por prioridade: urgente, alta e normal.
SELECT id, titulo, prioridade, status, criado_em
FROM chamados
ORDER BY
    CASE prioridade
        WHEN 'urgente' THEN 1
        WHEN 'alta' THEN 2
        WHEN 'normal' THEN 3
    END,
    criado_em DESC;

-- 4. Consultar chamados com nome do solicitante e nome da categoria.
SELECT
    ch.id,
    ch.titulo,
    u.nome AS solicitante,
    ca.nome AS categoria,
    ch.prioridade,
    ch.status,
    ch.criado_em
FROM chamados AS ch
INNER JOIN usuarios AS u ON u.id = ch.solicitante_id
INNER JOIN categorias AS ca ON ca.id = ch.categoria_id
ORDER BY ch.criado_em DESC;

-- 5. Contar chamados por status.
SELECT status, COUNT(*) AS quantidade
FROM chamados
GROUP BY status
ORDER BY quantidade DESC, status;

-- 6. Contar chamados por categoria, incluindo categorias sem chamados.
SELECT
    ca.id,
    ca.nome AS categoria,
    COUNT(ch.id) AS quantidade_chamados
FROM categorias AS ca
LEFT JOIN chamados AS ch ON ch.categoria_id = ca.id
GROUP BY ca.id, ca.nome
ORDER BY quantidade_chamados DESC, ca.nome;

-- 7. Consultar chamados criados nos ultimos sete dias.
SELECT id, titulo, prioridade, status, criado_em
FROM chamados
WHERE criado_em >= CURRENT_TIMESTAMP - INTERVAL '7 days'
  AND criado_em <= CURRENT_TIMESTAMP
ORDER BY criado_em DESC;

-- 8. Consultar os comentarios de um chamado especifico.
-- Altere o valor de 1 para o ID desejado.
SELECT
    co.id,
    co.conteudo,
    u.nome AS autor,
    co.criado_em
FROM comentarios AS co
INNER JOIN usuarios AS u ON u.id = co.usuario_id
WHERE co.chamado_id = 1
ORDER BY co.criado_em ASC;

-- 9. Consultar o historico de status de um chamado.
-- Altere o valor de 1 para o ID desejado.
SELECT
    hs.id,
    hs.status_anterior,
    hs.status_novo,
    u.nome AS responsavel,
    hs.criado_em
FROM historico_status AS hs
INNER JOIN usuarios AS u ON u.id = hs.usuario_id
WHERE hs.chamado_id = 1
ORDER BY hs.criado_em ASC, hs.id ASC;

-- 10. Contar chamados por prioridade.
SELECT prioridade, COUNT(*) AS quantidade
FROM chamados
GROUP BY prioridade
ORDER BY
    CASE prioridade
        WHEN 'urgente' THEN 1
        WHEN 'alta' THEN 2
        WHEN 'normal' THEN 3
    END;

-- 11. Consultar a quantidade de chamados por status e prioridade.
SELECT status, prioridade, COUNT(*) AS quantidade
FROM chamados
GROUP BY status, prioridade
ORDER BY status, prioridade;

-- 12. Listar os chamados de um solicitante especifico.
-- Altere o valor de 1 para o ID do usuario desejado.
SELECT
    ch.id,
    ch.titulo,
    ca.nome AS categoria,
    ch.prioridade,
    ch.status,
    ch.criado_em
FROM chamados AS ch
INNER JOIN categorias AS ca ON ca.id = ch.categoria_id
WHERE ch.solicitante_id = 1
ORDER BY ch.criado_em DESC;

-- 13. Resumo geral da quantidade de chamados por status.
-- Retorna uma linha para cada status permitido, inclusive com zero.
SELECT
    s.status,
    COUNT(ch.id) AS quantidade
FROM (
    VALUES
        ('aberto'),
        ('em_andamento'),
        ('resolvido'),
        ('fechado')
) AS s(status)
LEFT JOIN chamados AS ch ON ch.status = s.status
GROUP BY s.status
ORDER BY
    CASE s.status
        WHEN 'aberto' THEN 1
        WHEN 'em_andamento' THEN 2
        WHEN 'resolvido' THEN 3
        WHEN 'fechado' THEN 4
    END;
