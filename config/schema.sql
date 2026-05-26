CREATE DATABASE IF NOT EXISTS shop_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE shop_db;

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120)        NOT NULL,
    email      VARCHAR(255) UNIQUE NOT NULL,
    password   VARCHAR(255)        NOT NULL,
    role       ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255)  NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    image_url   VARCHAR(500),
    category    VARCHAR(100),
    stock       INT UNSIGNED  DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Default admin: password = "password"
INSERT INTO users (name, email, password, role) VALUES
  ('Admin', 'admin@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

INSERT INTO products (name, description, price, image_url, category, stock) VALUES
  ('AirPods Pro', 'Active noise cancellation. Up to 6 hours of listening time.', 249.00, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83?wid=400&hei=400&fmt=jpeg', 'Audio', 42),
  ('Magic Mouse', 'Wireless. Rechargeable. Multi-Touch surface.', 79.00, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MK2E3?wid=400&hei=400&fmt=jpeg', 'Accessories', 18),
  ('MagSafe Charger', '15W fast wireless charging for iPhone 12 and later.', 39.00, 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MHXH3?wid=400&hei=400&fmt=jpeg', 'Charging', 75),
  ('USB-C Hub', '7-in-1 USB-C hub with HDMI, SD, and USB 3.0.', 59.00, 'https://ir.ozone.ru/s3/multimedia-s/c1000/6753268972.jpg', 'Accessories', 30),
  ('iPhone 15 Case', 'Precision cutouts. MagSafe compatible.', 49.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_PC8_s-hhiREvM9iwVPytPKLfwd66HSYdqA&s', 'Cases', 120);
