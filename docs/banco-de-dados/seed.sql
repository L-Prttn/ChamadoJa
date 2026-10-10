BEGIN;

-- Usuarios ficticios para testes.
-- A senha nao e preenchida nesta versao inicial.
INSERT INTO usuarios (id, nome, email, senha_hash, tipo) OVERRIDING SYSTEM VALUE VALUES
    (1, 'Ana Souza', 'ana@example.com', NULL, 'usuario'),
    (2, 'Bruno Lima', 'bruno@example.com', NULL, 'usuario'),
    (3, 'Carla Mendes', 'carla@example.com', NULL, 'usuario'),
    (4, 'Daniel Alves', 'daniel@example.com', NULL, 'atendente'),
    (5, 'Eduarda Costa', 'eduarda@example.com', NULL, 'atendente');

-- Categorias iniciais.
INSERT INTO categorias (id, nome, descricao) OVERRIDING SYSTEM VALUE VALUES
    (1, 'Hardware', 'Problemas com computadores e equipamentos.'),
    (2, 'Software', 'Problemas com programas e aplicativos.'),
    (3, 'Acesso', 'Problemas de acesso e permissao.');

-- Chamados em diferentes prioridades e status.
INSERT INTO chamados (id, solicitante_id, categoria_id, titulo, descricao, prioridade, status, criado_em, atualizado_em) OVERRIDING SYSTEM VALUE VALUES
    (1, 1, 1, 'Computador nao liga', 'O computador nao liga ao pressionar o botao de energia.', 'alta', 'aberto', CURRENT_TIMESTAMP - INTERVAL '5 days', CURRENT_TIMESTAMP - INTERVAL '5 days'),
    (2, 2, 2, 'Aplicativo fecha sozinho', 'O aplicativo fecha ao tentar abrir um relatorio.', 'normal', 'em_andamento', CURRENT_TIMESTAMP - INTERVAL '4 days', CURRENT_TIMESTAMP - INTERVAL '3 days'),
    (3, 3, 3, 'Acesso bloqueado', 'Nao consigo acessar o sistema interno.', 'urgente', 'resolvido', CURRENT_TIMESTAMP - INTERVAL '3 days', CURRENT_TIMESTAMP - INTERVAL '1 day'),
    (4, 1, 2, 'Erro ao salvar arquivo', 'O sistema apresenta erro ao salvar um documento.', 'alta', 'fechado', CURRENT_TIMESTAMP - INTERVAL '10 days', CURRENT_TIMESTAMP - INTERVAL '7 days'),
    (5, 2, 1, 'Teclado com defeito', 'Algumas teclas do teclado nao respondem.', 'normal', 'aberto', CURRENT_TIMESTAMP - INTERVAL '1 day', CURRENT_TIMESTAMP - INTERVAL '1 day'),
    (6, 3, 3, 'Solicitacao de permissao', 'Preciso de permissao para acessar uma pasta compartilhada.', 'urgente', 'em_andamento', CURRENT_TIMESTAMP - INTERVAL '2 days', CURRENT_TIMESTAMP - INTERVAL '1 day');

-- Comentarios vinculados a chamados e seus autores.
INSERT INTO comentarios (id, chamado_id, usuario_id, conteudo, criado_em) OVERRIDING SYSTEM VALUE VALUES
    (1, 1, 1, 'O problema comecou hoje pela manha.', CURRENT_TIMESTAMP - INTERVAL '4 days 22 hours'),
    (2, 2, 4, 'Estamos analisando os registros de erro.', CURRENT_TIMESTAMP - INTERVAL '3 days 20 hours'),
    (3, 3, 5, 'O acesso foi restabelecido. Pode testar novamente.', CURRENT_TIMESTAMP - INTERVAL '1 day 2 hours'),
    (4, 4, 1, 'O arquivo voltou a ser salvo normalmente.', CURRENT_TIMESTAMP - INTERVAL '7 days 1 hour'),
    (5, 6, 4, 'A solicitacao esta em atendimento.', CURRENT_TIMESTAMP - INTERVAL '20 hours');

-- Historico completo de status para os chamados de exemplo.
-- Cada chamado possui um registro inicial com status_anterior NULL.
INSERT INTO historico_status (id, chamado_id, status_anterior, status_novo, usuario_id, criado_em) OVERRIDING SYSTEM VALUE VALUES
    (1, 1, NULL, 'aberto', 1, CURRENT_TIMESTAMP - INTERVAL '5 days'),
    (2, 2, NULL, 'aberto', 2, CURRENT_TIMESTAMP - INTERVAL '4 days'),
    (3, 2, 'aberto', 'em_andamento', 4, CURRENT_TIMESTAMP - INTERVAL '3 days'),
    (4, 3, NULL, 'aberto', 3, CURRENT_TIMESTAMP - INTERVAL '3 days'),
    (5, 3, 'aberto', 'em_andamento', 5, CURRENT_TIMESTAMP - INTERVAL '2 days'),
    (6, 3, 'em_andamento', 'resolvido', 5, CURRENT_TIMESTAMP - INTERVAL '1 day'),
    (7, 4, NULL, 'aberto', 1, CURRENT_TIMESTAMP - INTERVAL '10 days'),
    (8, 4, 'aberto', 'em_andamento', 4, CURRENT_TIMESTAMP - INTERVAL '9 days'),
    (9, 4, 'em_andamento', 'resolvido', 4, CURRENT_TIMESTAMP - INTERVAL '8 days'),
    (10, 4, 'resolvido', 'fechado', 1, CURRENT_TIMESTAMP - INTERVAL '7 days'),
    (11, 5, NULL, 'aberto', 2, CURRENT_TIMESTAMP - INTERVAL '1 day'),
    (12, 6, NULL, 'aberto', 3, CURRENT_TIMESTAMP - INTERVAL '2 days'),
    (13, 6, 'aberto', 'em_andamento', 4, CURRENT_TIMESTAMP - INTERVAL '1 day');

-- Sincroniza as sequencias de identidade apos inserir IDs explicitos.
SELECT setval(pg_get_serial_sequence('usuarios', 'id'), (SELECT MAX(id) FROM usuarios), true);
SELECT setval(pg_get_serial_sequence('categorias', 'id'), (SELECT MAX(id) FROM categorias), true);
SELECT setval(pg_get_serial_sequence('chamados', 'id'), (SELECT MAX(id) FROM chamados), true);
SELECT setval(pg_get_serial_sequence('comentarios', 'id'), (SELECT MAX(id) FROM comentarios), true);
SELECT setval(pg_get_serial_sequence('historico_status', 'id'), (SELECT MAX(id) FROM historico_status), true);

COMMIT;