-- Create Categories Table
CREATE TABLE IF NOT EXISTS tbl_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Products Table
CREATE TABLE IF NOT EXISTS tbl_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES tbl_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Cart Table
CREATE TABLE IF NOT EXISTS tbl_cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbl_login(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES tbl_products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Orders Table
CREATE TABLE IF NOT EXISTS tbl_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES tbl_login(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Order Items Table
CREATE TABLE IF NOT EXISTS tbl_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES tbl_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES tbl_products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample categories
INSERT INTO tbl_categories (name, description) VALUES
('Electronics', 'Electronic devices and gadgets'),
('Fashion', 'Clothing and accessories'),
('Food & Beverages', 'Food and drink products'),
('Books', 'Books and magazines'),
('Sports', 'Sports equipment and gear');

-- Insert sample products
INSERT INTO tbl_products (category_id, name, description, price, stock, status) VALUES
(1, 'Smartphone X Pro', 'Latest smartphone with 5G technology', 5999000, 50, 'active'),
(1, 'Wireless Headphones', 'Noise-canceling bluetooth headphones', 899000, 100, 'active'),
(1, 'Smart Watch Series 5', 'Fitness tracker and smartwatch', 2499000, 75, 'active'),
(2, 'Men T-Shirt Premium', 'Cotton t-shirt various colors', 149000, 200, 'active'),
(2, 'Women Dress Elegant', 'Elegant dress for formal occasions', 499000, 80, 'active'),
(2, 'Sneakers Sport', 'Comfortable sport shoes', 799000, 120, 'active'),
(3, 'Organic Coffee Beans 1kg', 'Premium arabica coffee beans', 150000, 300, 'active'),
(3, 'Green Tea Premium', 'Japanese green tea leaves', 85000, 250, 'active'),
(4, 'Programming Book: PHP', 'Complete guide to PHP programming', 250000, 50, 'active'),
(4, 'Novel: The Adventure', 'Bestselling adventure novel', 95000, 150, 'active'),
(5, 'Yoga Mat', 'Non-slip yoga exercise mat', 199000, 100, 'active'),
(5, 'Dumbbell Set 5kg', 'Adjustable dumbbell weights', 350000, 60, 'active');
