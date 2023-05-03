USE `u283994777_scandiweb`;

-- Create 5 DVD products
INSERT INTO `products` (`sku`, `name`, `price`, `product_type`, `value`) 
VALUES 
    ('DVD1', 'The Matrix', 12.99, 'DVD', 700),
    ('DVD2', 'Inception', 14.99, 'DVD', 650),
    ('DVD3', 'Sneakers', 16.99, 'DVD', 800),
    ('DVD4', 'Hackers', 9.99, 'DVD', 600),
    ('DVD5', 'Snowden', 3.99, 'DVD', 550);

-- Create 5 Book products
INSERT INTO `products` (`sku`, `name`, `price`, `product_type`, `value`) 
VALUES 
    ('BOK1', 'Python Crash Course', 29.99, 'Book', 20),
    ('BOK2', 'Fluent Python', 39.99, 'Book', 12),
    ('BOK3', 'Automate the Boring Stuff with Python', 0, 'Book', 6),
    ('BOK4', 'Python for Data Analysis', 49.99, 'Book', 8),
    ('BOK5', "59 Ways to Write Better Python", 52.49, 'Book', 5);

-- Create 5 Furniture products
INSERT INTO `products` (`sku`, `name`, `price`, `product_type`, `value`) 
VALUES 
    ('FUR1', 'GTRACING Gaming Chair', 149.99, 'Furniture', '26x51.97x5'),
    ('FUR2', 'GeForce RTX™ 3060', 1099.00, 'Furniture', '11x5.5x2.5'),
    ('FUR3', 'Monarch Specialties Corner Desk', 382.49, 'Furniture', '60x47x30'),
    ('FUR4', 'GreenForest Gaming Computer Desk', 109.99, 'Furniture', '58.1x44.3x29.13'),
    ('FUR5', 'Ficmax Ergonomic Gaming Desk', 249.99, 'Furniture', '4x30.7x7.3');
