-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS quadtech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quadtech;

-- Tabela de Clientes
CREATE TABLE clientes (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(15),
    data_nascimento DATE,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acesso DATETIME,
    status ENUM('ativo', 'inativo', 'bloqueado') DEFAULT 'ativo'
);

-- Tabela de Endereços
CREATE TABLE enderecos (
    endereco_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    tipo VARCHAR(20) DEFAULT 'residencial',
    cep VARCHAR(9) NOT NULL,
    logradouro VARCHAR(100) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(50),
    bairro VARCHAR(50) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    estado CHAR(2) NOT NULL,
    padrao BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id) ON DELETE CASCADE
);

-- Tabela de Categorias
CREATE TABLE categorias (
    categoria_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    categoria_pai_id INT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (categoria_pai_id) REFERENCES categorias(categoria_id) ON DELETE SET NULL
);

-- Tabela de Produtos
CREATE TABLE produtos (
    produto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    categoria_id INT,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    peso DECIMAL(8, 3),
    dimensoes VARCHAR(50),
    destaque BOOLEAN DEFAULT FALSE,
    codigo_barras VARCHAR(20),
    FOREIGN KEY (categoria_id) REFERENCES categorias(categoria_id) ON DELETE SET NULL
);

-- Tabela de Imagens de Produtos
CREATE TABLE imagens_produtos (
    imagem_id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    caminho VARCHAR(255) NOT NULL,
    ordem INT DEFAULT 0,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE
);

-- Tabela de Fornecedores
CREATE TABLE fornecedores (
    fornecedor_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    contato_nome VARCHAR(100),
    email VARCHAR(100),
    telefone VARCHAR(15),
    endereco TEXT,
    categorias_fornecidas TEXT,
    prazo_entrega_dias INT DEFAULT 7,
    valor_minimo_pedido DECIMAL(10, 2) DEFAULT 0,
    status ENUM('ativo', 'inativo', 'suspenso') DEFAULT 'ativo'
);

-- Tabela de Relação Produtos-Fornecedores
CREATE TABLE produtos_fornecedores (
    produto_id INT NOT NULL,
    fornecedor_id INT NOT NULL,
    preco_compra DECIMAL(10, 2) NOT NULL,
    prazo_entrega_dias INT DEFAULT 7,
    PRIMARY KEY (produto_id, fornecedor_id),
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(fornecedor_id) ON DELETE CASCADE
);

-- Tabela de Carrinhos
CREATE TABLE carrinhos (
    carrinho_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id) ON DELETE CASCADE
);

-- Tabela de Itens do Carrinho
CREATE TABLE itens_carrinho (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    carrinho_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (carrinho_id) REFERENCES carrinhos(carrinho_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE
);

-- Tabela de Cupons
CREATE TABLE cupons (
    cupom_id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    tipo ENUM('valor', 'percentual') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    usos_maximo INT DEFAULT NULL,
    usos_realizados INT DEFAULT 0,
    valor_minimo_pedido DECIMAL(10, 2) DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE
);

-- Tabela de Promoções
CREATE TABLE promocoes (
    promocao_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    tipo ENUM('valor', 'percentual') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    limite_usos INT DEFAULT NULL,
    usos_realizados INT DEFAULT 0,
    status ENUM('ativa', 'inativa', 'agendada', 'encerrada') DEFAULT 'agendada',
    categorias_aplicaveis TEXT
);

-- Tabela de Produtos em Promoção
CREATE TABLE produtos_promocao (
    produto_id INT NOT NULL,
    promocao_id INT NOT NULL,
    PRIMARY KEY (produto_id, promocao_id),
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE,
    FOREIGN KEY (promocao_id) REFERENCES promocoes(promocao_id) ON DELETE CASCADE
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
    pedido_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    status_pedido ENUM('aguardando_pagamento', 'pago', 'em_separacao', 'enviado', 'entregue', 'cancelado') DEFAULT 'aguardando_pagamento',
    endereco_entrega_id INT NOT NULL,
    valor_produtos DECIMAL(10, 2) NOT NULL,
    valor_frete DECIMAL(10, 2) NOT NULL,
    valor_desconto DECIMAL(10, 2) DEFAULT 0,
    valor_total DECIMAL(10, 2) NOT NULL,
    codigo_rastreio VARCHAR(50),
    metodo_pagamento VARCHAR(50) NOT NULL,
    cupom_id INT,
    observacoes TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id),
    FOREIGN KEY (endereco_entrega_id) REFERENCES enderecos(endereco_id),
    FOREIGN KEY (cupom_id) REFERENCES cupons(cupom_id) ON DELETE SET NULL
);

-- Tabela de Itens do Pedido
CREATE TABLE itens_pedido (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id)
);

-- Tabela de Histórico de Status do Pedido
CREATE TABLE historico_status_pedido (
    historico_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    status_pedido ENUM('aguardando_pagamento', 'pago', 'em_separacao', 'enviado', 'entregue', 'cancelado') NOT NULL,
    data_modificacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    observacao TEXT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE CASCADE
);

-- Tabela de Pagamentos
CREATE TABLE pagamentos (
    pagamento_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    tipo ENUM('credito', 'debito', 'boleto', 'pix', 'transferencia') NOT NULL,
    status ENUM('pendente', 'aprovado', 'recusado', 'estornado') DEFAULT 'pendente',
    valor DECIMAL(10, 2) NOT NULL,
    data_pagamento DATETIME,
    codigo_transacao VARCHAR(100),
    parcelas INT DEFAULT 1,
    detalhes_pagamento TEXT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE CASCADE
);

-- Tabela de Transações
CREATE TABLE transacoes (
    transacao_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('pagamento', 'estorno', 'reembolso', 'cancelamento') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_transacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'confirmada', 'cancelada', 'estornada') DEFAULT 'pendente',
    gateway_pagamento VARCHAR(50) NOT NULL,
    codigo_autorizacao VARCHAR(100),
    taxa_gateway DECIMAL(10, 2) DEFAULT 0,
    detalhes TEXT,
    transacao_confirmada BOOLEAN DEFAULT FALSE
);

-- Tabela de Entregas
CREATE TABLE entregas (
    entrega_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    tipo_entrega ENUM('normal', 'expressa', 'retirada') NOT NULL,
    custo_entrega DECIMAL(10, 2) NOT NULL,
    data_estimada DATE,
    data_entrega DATE,
    status_entrega ENUM('aguardando_separacao', 'em_transporte', 'entregue', 'devolvida', 'cancelada') DEFAULT 'aguardando_separacao',
    codigo_rastreio VARCHAR(50),
    detalhes_transportadora TEXT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE CASCADE
);

-- Tabela de Avaliações
CREATE TABLE avaliacoes (
    avaliacao_id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    cliente_id INT NOT NULL,
    pedido_id INT,
    nota INT NOT NULL CHECK (nota >= 1 AND nota <= 5),
    comentario TEXT,
    data_avaliacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    aprovado BOOLEAN DEFAULT FALSE,
    motivo_rejeicao TEXT,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id) ON DELETE CASCADE,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE SET NULL
);

-- Tabela de Lista de Desejos
CREATE TABLE lista_desejos (
    desejo_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    produto_id INT NOT NULL,
    data_adicao DATETIME DEFAULT CURRENT_TIMESTAMP,
    notificar_promocao BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(cliente_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id) ON DELETE CASCADE
);

-- Tabela de Devoluções
CREATE TABLE devolucoes (
    devolucao_id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    item_id INT NOT NULL,
    motivo TEXT NOT NULL,
    status ENUM('solicitada', 'aprovada', 'rejeitada', 'concluida') DEFAULT 'solicitada',
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_aprovacao DATETIME,
    data_conclusao DATETIME,
    valor_devolucao DECIMAL(10, 2),
    detalhes_transacao TEXT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(pedido_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES itens_pedido(item_id)
);

-- Tabela de Newsletter
CREATE TABLE newsletter (
    newsletter_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE
);

-- Tabela de Visitantes
CREATE TABLE visitantes (
    visitante_id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL,
    user_agent TEXT,
    pagina_visitada VARCHAR(255) NOT NULL,
    data_visita DATETIME DEFAULT CURRENT_TIMESTAMP,
    tempo_permanencia INT,
    referencia VARCHAR(255)
);

-- Tabela de Logs
CREATE TABLE logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    tipo VARCHAR(50) NOT NULL,
    acao VARCHAR(100) NOT NULL,
    descricao TEXT,
    ip VARCHAR(45),
    data_log DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES clientes(cliente_id) ON DELETE SET NULL
);

-- Tabela de Usuários Admin
CREATE TABLE usuarios_admin (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cargo VARCHAR(50),
    permissoes TEXT,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acesso DATETIME,
    ativo BOOLEAN DEFAULT TRUE
);

-- Criação das VIEWS

-- VIEW 1: Produtos em Estoque com Categoria
CREATE VIEW vw_produtos_estoque AS
SELECT 
    p.produto_id,
    p.nome AS nome_produto,
    p.descricao,
    p.preco,
    p.estoque,
    c.nome AS categoria,
    c.categoria_id,
    p.destaque,
    p.data_cadastro
FROM 
    produtos p
LEFT JOIN 
    categorias c ON p.categoria_id = c.categoria_id
WHERE 
    p.estoque > 0 AND c.ativo = TRUE;

-- VIEW 2: Pedidos com Detalhes do Cliente
CREATE VIEW vw_pedidos_detalhados AS
SELECT 
    p.pedido_id,
    p.data_pedido,
    p.status_pedido,
    p.valor_total,
    c.nome AS nome_cliente,
    c.email,
    c.telefone,
    e.logradouro,
    e.numero,
    e.complemento,
    e.bairro,
    e.cidade,
    e.estado,
    e.cep
FROM 
    pedidos p
JOIN 
    clientes c ON p.cliente_id = c.cliente_id
JOIN 
    enderecos e ON p.endereco_entrega_id = e.endereco_id;

-- VIEW 3: Avaliações de Produtos Aprovadas
CREATE VIEW vw_avaliacoes_produtos AS
SELECT 
    a.avaliacao_id,
    p.produto_id,
    p.nome AS nome_produto,
    a.nota,
    a.comentario,
    c.nome AS nome_cliente,
    a.data_avaliacao
FROM 
    avaliacoes a
JOIN 
    produtos p ON a.produto_id = p.produto_id
JOIN 
    clientes c ON a.cliente_id = c.cliente_id
WHERE 
    a.aprovado = TRUE
ORDER BY 
    a.data_avaliacao DESC;

-- Criação das PROCEDURES

-- PROCEDURE 1: Atualizar Estoque do Produto
DELIMITER //
CREATE PROCEDURE sp_atualizar_estoque(
    IN p_produto_id INT,
    IN p_quantidade INT
)
BEGIN
    DECLARE estoque_atual INT;
    
    -- Obter estoque atual
    SELECT estoque INTO estoque_atual FROM produtos WHERE produto_id = p_produto_id;
    
    -- Atualizar estoque
    UPDATE produtos 
    SET estoque = estoque_atual + p_quantidade 
    WHERE produto_id = p_produto_id;
    
    -- Verificar se o estoque ficou negativo
    IF (estoque_atual + p_quantidade < 0) THEN
        UPDATE produtos SET estoque = 0 WHERE produto_id = p_produto_id;
    END IF;
END //
DELIMITER ;

-- PROCEDURE 2: Processar Pedido
DELIMITER //
CREATE PROCEDURE sp_processar_pedido(
    IN p_cliente_id INT,
    IN p_endereco_id INT,
    IN p_metodo_pagamento VARCHAR(50),
    IN p_cupom_id INT,
    OUT p_pedido_id INT
)
BEGIN
    DECLARE v_valor_produtos DECIMAL(10, 2) DEFAULT 0;
    DECLARE v_valor_frete DECIMAL(10, 2) DEFAULT 0;
    DECLARE v_valor_desconto DECIMAL(10, 2) DEFAULT 0;
    DECLARE v_valor_total DECIMAL(10, 2);
    DECLARE v_carrinho_id INT;
    
    -- Obter ID do carrinho do cliente
    SELECT carrinho_id INTO v_carrinho_id FROM carrinhos WHERE cliente_id = p_cliente_id ORDER BY data_criacao DESC LIMIT 1;
    
    -- Calcular valor total dos produtos
    SELECT SUM(ic.quantidade * p.preco) INTO v_valor_produtos
    FROM itens_carrinho ic
    JOIN produtos p ON ic.produto_id = p.produto_id
    WHERE ic.carrinho_id = v_carrinho_id;
    
    -- Calcular valor do frete (exemplo simples, poderia ser baseado em CEP, peso, etc.)
    SET v_valor_frete = 15.00;
    
    -- Aplicar cupom se existir
    IF p_cupom_id IS NOT NULL THEN
        SELECT CASE
            WHEN tipo = 'valor' THEN valor
            WHEN tipo = 'percentual' THEN (v_valor_produtos * valor / 100)
        END INTO v_valor_desconto
        FROM cupons
        WHERE cupom_id = p_cupom_id AND ativo = TRUE
        AND CURRENT_DATE BETWEEN data_inicio AND data_fim
        AND (usos_maximo IS NULL OR usos_realizados < usos_maximo)
        AND v_valor_produtos >= valor_minimo_pedido;
        
        -- Atualizar uso do cupom
        IF v_valor_desconto > 0 THEN
            UPDATE cupons SET usos_realizados = usos_realizados + 1 WHERE cupom_id = p_cupom_id;
        END IF;
    END IF;
    
    -- Calcular valor total
    SET v_valor_total = v_valor_produtos + v_valor_frete - v_valor_desconto;
    
    -- Criar o pedido
    INSERT INTO pedidos (
        cliente_id, 
        endereco_entrega_id, 
        valor_produtos, 
        valor_frete, 
        valor_desconto, 
        valor_total, 
        metodo_pagamento, 
        cupom_id
    ) VALUES (
        p_cliente_id,
        p_endereco_id,
        v_valor_produtos,
        v_valor_frete,
        v_valor_desconto,
        v_valor_total,
        p_metodo_pagamento,
        p_cupom_id
    );
    
    -- Obter ID do pedido criado
    SET p_pedido_id = LAST_INSERT_ID();
    
    -- Inserir itens do pedido
    INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario, subtotal)
    SELECT 
        p_pedido_id,
        ic.produto_id,
        ic.quantidade,
        p.preco,
        ic.quantidade * p.preco
    FROM 
        itens_carrinho ic
    JOIN 
        produtos p ON ic.produto_id = p.produto_id
    WHERE 
        ic.carrinho_id = v_carrinho_id;
    
    -- Atualizar estoque
    UPDATE produtos p
    JOIN itens_carrinho ic ON p.produto_id = ic.produto_id
    SET p.estoque = p.estoque - ic.quantidade
    WHERE ic.carrinho_id = v_carrinho_id;
    
    -- Registrar histórico do status do pedido
    INSERT INTO historico_status_pedido (pedido_id, status_pedido, observacao)
    VALUES (p_pedido_id, 'aguardando_pagamento', 'Pedido criado');
    
    -- Limpar carrinho
    DELETE FROM itens_carrinho WHERE carrinho_id = v_carrinho_id;
END //
DELIMITER ;

-- PROCEDURE 3: Atualizar Status do Pedido
DELIMITER //
CREATE PROCEDURE sp_atualizar_status_pedido(
    IN p_pedido_id INT,
    IN p_novo_status ENUM('aguardando_pagamento', 'pago', 'em_separacao', 'enviado', 'entregue', 'cancelado'),
    IN p_observacao TEXT
)
BEGIN
    -- Atualizar o status do pedido
    UPDATE pedidos SET status_pedido = p_novo_status WHERE pedido_id = p_pedido_id;
    
    -- Registrar o histórico
    INSERT INTO historico_status_pedido (pedido_id, status_pedido, observacao)
    VALUES (p_pedido_id, p_novo_status, p_observacao);
    
    -- Se o status for "cancelado", devolver os produtos para o estoque
    IF p_novo_status = 'cancelado' THEN
        UPDATE produtos p
        JOIN itens_pedido ip ON p.produto_id = ip.produto_id
        SET p.estoque = p.estoque + ip.quantidade
        WHERE ip.pedido_id = p_pedido_id;
    END IF;
END //
DELIMITER ;

-- Criação das TRIGGERS

-- TRIGGER 1: Atualizar Data de Último Acesso do Cliente
DELIMITER //
CREATE TRIGGER tr_atualizar_acesso_cliente
AFTER UPDATE ON clientes
FOR EACH ROW
BEGIN
    IF NEW.ultimo_acesso != OLD.ultimo_acesso THEN
        INSERT INTO logs (usuario_id, tipo, acao, descricao)
        VALUES (NEW.cliente_id, 'acesso', 'login', CONCAT('Login realizado em ', NEW.ultimo_acesso));
    END IF;
END //
DELIMITER ;

-- TRIGGER 2: Monitorar Alterações de Preço
DELIMITER //
CREATE TRIGGER tr_monitorar_preco_produto
BEFORE UPDATE ON produtos
FOR EACH ROW
BEGIN
    IF NEW.preco != OLD.preco THEN
        INSERT INTO logs (tipo, acao, descricao)
        VALUES (
            'produto', 
            'alteracao_preco', 
            CONCAT(
                'Produto ID: ', NEW.produto_id, 
                ' - Preço alterado de R$ ', OLD.preco, 
                ' para R$ ', NEW.preco
            )
        );
    END IF;
END //
DELIMITER ;
