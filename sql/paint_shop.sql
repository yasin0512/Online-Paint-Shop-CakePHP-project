-- ============================================================
-- Online Paint Shop - Database Schema
-- Tamkang University, Dept. of Computer Science and Information Engineering — Capstone Project, Academic Year 112
-- ============================================================

CREATE DATABASE IF NOT EXISTS paint CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE paint;

-- ------------------------------------------------------------
-- Customers Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS customers (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    phone       VARCHAR(20)   NOT NULL,
    email       VARCHAR(150)  NOT NULL UNIQUE,
    address     VARCHAR(255)  NOT NULL,
    password    VARCHAR(255)  NOT NULL,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Paints Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS paints (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    color       VARCHAR(50)   NOT NULL,
    color_code  VARCHAR(20)   NOT NULL,
    type        VARCHAR(50)   NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    image       VARCHAR(255)  DEFAULT NULL,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Storages Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS storages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    location    VARCHAR(100)  NOT NULL,
    capacity    INT           NOT NULL DEFAULT 0,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Paints_Storages (Junction: paint stock per storage location)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS paints_storages (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    paint_id    INT UNSIGNED  NOT NULL,
    storage_id  INT UNSIGNED  NOT NULL,
    quantity    INT           NOT NULL DEFAULT 0,
    start_date  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    end_date    DATETIME      DEFAULT NULL,
    FOREIGN KEY (paint_id)   REFERENCES paints(id)   ON DELETE CASCADE,
    FOREIGN KEY (storage_id) REFERENCES storages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Orders Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED  NOT NULL,
    date        DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status      ENUM('pending','inspecting','shipped','delivered','returned') NOT NULL DEFAULT 'pending',
    total       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Orders_Paints (Junction: line items in an order)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders_paints (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    INT UNSIGNED  NOT NULL,
    paint_id    INT UNSIGNED  NOT NULL,
    quantity    INT           NOT NULL DEFAULT 1,
    subtotal    DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (paint_id) REFERENCES paints(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Payments Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS payments (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    INT UNSIGNED  NOT NULL,
    customer_id INT UNSIGNED  NOT NULL,
    acct_no     VARCHAR(50)   DEFAULT NULL,
    type        ENUM('credit_card','cash','bank_transfer') NOT NULL DEFAULT 'cash',
    amount      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    paid_at     DATETIME      DEFAULT NULL,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id)    REFERENCES orders(id)    ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Shipments Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS shipments (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    INT UNSIGNED  NOT NULL,
    customer_id INT UNSIGNED  NOT NULL,
    seq_num     INT           NOT NULL,
    type        ENUM('standard','express') NOT NULL DEFAULT 'standard',
    shipped_at  DATETIME      DEFAULT NULL,
    created     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id)    REFERENCES orders(id)    ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Seed Data
-- ============================================================

-- Storages
INSERT INTO storages (location, capacity) VALUES
('Shelf A1', 200),
('Shelf A2', 200),
('Shelf B1', 150);

-- Paints
INSERT INTO paints (name, color, color_code, type, description, price, image) VALUES
('Bell Pepper Green',  'Green',  '#5D8A5E', 'Interior', 'A vibrant green inspired by fresh bell peppers.', 350.00, 'bell_pepper_green.jpg'),
('Tomato Red',         'Red',    '#CE2939', 'Interior', 'Bold and energetic red, inspired by ripe tomatoes.', 350.00, 'tomato_red.jpg'),
('Ocean Blue',         'Blue',   '#1A6B9A', 'Exterior', 'A deep ocean blue for a calming atmosphere.', 420.00, 'ocean_blue.jpg'),
('Sunshine Yellow',    'Yellow', '#F5C518', 'Interior', 'Bright and cheerful yellow to liven any room.', 380.00, 'sunshine_yellow.jpg'),
('Charcoal Grey',      'Grey',   '#4A4A4A', 'Exterior', 'A modern charcoal grey for a sleek look.', 400.00, 'charcoal_grey.jpg'),
('Ivory White',        'White',  '#FFFFF0', 'Interior', 'Clean and classic ivory white.', 300.00, 'ivory_white.jpg');

-- Paints_Storages (stock)
INSERT INTO paints_storages (paint_id, storage_id, quantity, start_date) VALUES
(1, 1, 65,  NOW()),
(2, 1, 45,  NOW()),
(3, 2, 80,  NOW()),
(4, 2, 30,  NOW()),
(5, 3, 50,  NOW()),
(6, 3, 100, NOW());

-- Sample customer
INSERT INTO customers (name, phone, email, address, password) VALUES
('Test User', '0912-345-678', 'test@example.com', 'No. 151, Yingzhuan Rd., Tamsui Dist., New Taipei City', MD5('password123'));
