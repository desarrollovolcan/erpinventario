CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255)
);

CREATE TABLE providers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    tax_id VARCHAR(50),
    address VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(120),
    payment_terms VARCHAR(50),
    notes TEXT
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    parent_id INT DEFAULT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL,
    barcode VARCHAR(50),
    name VARCHAR(150) NOT NULL,
    description TEXT,
    category_id INT,
    unit VARCHAR(20) DEFAULT 'unidad',
    type ENUM('normal','servicio') DEFAULT 'normal',
    tax_included TINYINT(1) DEFAULT 1,
    cost_price DECIMAL(12,2) DEFAULT 0,
    sale_price DECIMAL(12,2) DEFAULT 0,
    discount_max DECIMAL(5,2) DEFAULT 0,
    stock_min INT DEFAULT 0,
    provider_id INT,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (provider_id) REFERENCES providers(id)
);

CREATE TABLE warehouses_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    product_id INT NOT NULL,
    stock INT DEFAULT 0,
    UNIQUE KEY wh_prod (warehouse_id, product_id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE inventory_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    user_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    unit_cost DECIMAL(12,2) DEFAULT 0,
    comments TEXT,
    movement_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    tax_id VARCHAR(50),
    business VARCHAR(150),
    address VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(120),
    payment_terms VARCHAR(50),
    credit_limit DECIMAL(12,2) DEFAULT 0,
    notes TEXT
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NULL,
    user_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    document_type VARCHAR(20) DEFAULT 'boleta',
    document_number VARCHAR(50),
    total DECIMAL(12,2) NOT NULL,
    tax DECIMAL(12,2) DEFAULT 0,
    payment_method VARCHAR(50),
    status VARCHAR(20) DEFAULT 'pagada',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)
);

CREATE TABLE sale_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    discount DECIMAL(5,2) DEFAULT 0,
    tax DECIMAL(12,2) DEFAULT 0,
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE accounts_receivable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    sale_id INT NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    balance DECIMAL(12,2) NOT NULL,
    due_date DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (sale_id) REFERENCES sales(id)
);

CREATE TABLE receivable_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receivable_id INT NOT NULL,
    paid_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(12,2) NOT NULL,
    method VARCHAR(50),
    notes TEXT,
    FOREIGN KEY (receivable_id) REFERENCES accounts_receivable(id)
);

CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    provider_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    user_id INT NOT NULL,
    document_type VARCHAR(20) DEFAULT 'factura',
    document_number VARCHAR(50),
    issue_date DATE,
    payment_terms VARCHAR(50),
    status VARCHAR(20) DEFAULT 'pendiente',
    total DECIMAL(12,2) DEFAULT 0,
    tax DECIMAL(12,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (provider_id) REFERENCES providers(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE purchase_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    cost DECIMAL(12,2) NOT NULL,
    tax DECIMAL(12,2) DEFAULT 0,
    FOREIGN KEY (purchase_id) REFERENCES purchases(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    type VARCHAR(50),
    amount DECIMAL(12,2) NOT NULL,
    payment_method VARCHAR(50),
    notes TEXT,
    expense_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)
);

CREATE TABLE cash_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    opened_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    closed_at DATETIME NULL,
    opening_amount DECIMAL(12,2) DEFAULT 0,
    closing_amount DECIMAL(12,2) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'open',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)
);

CREATE OR REPLACE VIEW product_stock_view AS
SELECT
    p.id,
    p.name,
    p.stock_min,
    p.cost_price,
    SUM(COALESCE(wp.stock,0)) AS total_stock
FROM products p
LEFT JOIN warehouses_products wp ON wp.product_id = p.id
GROUP BY p.id, p.name, p.stock_min, p.cost_price;

INSERT INTO roles (name, slug) VALUES
('Administrador', 'admin'),
('Vendedor/Cajero', 'vendedor'),
('Bodeguero', 'bodeguero'),
('Supervisor/Contador', 'supervisor');

INSERT INTO users (name, email, password_hash, role_id, status) VALUES
('Administrador', 'admin@erp.test', '$2y$12$xOIjeJSBeFEfXnDsh7R.x.D7A8AIGRHqw/cy51k0aKbWQuhjMzVnq', 1, 1);

INSERT INTO warehouses (name, address) VALUES
('Local 1', 'Calle Principal 123'),
('Local 2', 'Avenida Secundaria 456');

INSERT INTO providers (name, tax_id, phone, email, payment_terms) VALUES
('Clavos Chile', '76.123.456-7', '+56 9 1111 1111', 'ventas@clavos.cl', '30 días'),
('Pinturas Color', '77.987.654-3', '+56 9 2222 2222', 'contacto@pinturascolor.cl', 'contado');

INSERT INTO categories (name) VALUES ('Herramientas'), ('Pintura'), ('Electricidad');

INSERT INTO products (sku, barcode, name, description, category_id, unit, type, tax_included, cost_price, sale_price, discount_max, stock_min, provider_id, status) VALUES
('H001', '780000000001', 'Martillo', 'Martillo de acero', 1, 'unidad', 'normal', 1, 5000, 7500, 10, 5, 1, 1),
('P001', '780000000002', 'Pintura blanca 1L', 'Pintura látex interior', 2, 'lts', 'normal', 1, 3000, 5200, 5, 8, 2, 1),
('E001', '780000000003', 'Cable eléctrico 2mm', 'Cable por metro', 3, 'm', 'normal', 1, 800, 1500, 15, 20, 1, 1);

INSERT INTO warehouses_products (warehouse_id, product_id, stock) VALUES
(1, 1, 10),
(1, 2, 15),
(1, 3, 50),
(2, 1, 5),
(2, 2, 8),
(2, 3, 30);

INSERT INTO customers (name, tax_id, phone, email, payment_terms, credit_limit) VALUES
('Ferretería San Juan', '78.123.456-0', '+56 9 3333 3333', 'contacto@sanjuan.cl', '30 días', 300000),
('Constructora Andes', '76.555.444-1', '+56 9 4444 4444', 'compras@andes.cl', '45 días', 500000);

INSERT INTO inventory_movements (product_id, warehouse_id, user_id, type, quantity, unit_cost, comments) VALUES
(1, 1, 1, 'entrada compra', 20, 5000, 'Stock inicial'),
(2, 1, 1, 'entrada compra', 30, 3000, 'Stock inicial'),
(3, 1, 1, 'entrada compra', 80, 800, 'Stock inicial');

INSERT INTO sales (customer_id, user_id, warehouse_id, document_type, document_number, total, tax, payment_method) VALUES
(NULL, 1, 1, 'boleta', 'B001', 15000, 2395, 'efectivo');

INSERT INTO sale_details (sale_id, product_id, quantity, price, discount, tax) VALUES
(1, 1, 1, 7500, 0, 1196),
(1, 2, 1, 5200, 0, 828);

INSERT INTO accounts_receivable (customer_id, sale_id, amount, balance, due_date) VALUES
(1, 1, 15000, 5000, DATE_SUB(CURDATE(), INTERVAL 3 DAY));

INSERT INTO cash_sessions (user_id, warehouse_id, opened_at, opening_amount, status) VALUES
(1, 1, NOW(), 50000, 'open');

INSERT INTO expenses (user_id, warehouse_id, type, amount, payment_method, notes) VALUES
(1, 1, 'Servicios', 12000, 'transferencia', 'Pago de luz'),
(1, 1, 'Gastos menores', 8000, 'efectivo', 'Reposición insumos');
