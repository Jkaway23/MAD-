-- Update all products with images from Unsplash CDN
-- Date: 2025-11-25

-- Electronics
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400' WHERE id = 1; -- Smartphone
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=400' WHERE id = 2; -- Laptop
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400' WHERE id = 3; -- Earbuds

-- Fashion
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400' WHERE id = 4; -- T-shirt
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=400' WHERE id = 5; -- Hoodie
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400' WHERE id = 6; -- Sneakers

-- Food & Beverages
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=400' WHERE id = 7; -- Coffee
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=400' WHERE id = 8; -- Tea

-- Books
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400' WHERE id = 9; -- Novel
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1585366119957-e9730b6d0f60?w=400' WHERE id = 10; -- Pen Set

-- Sports
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1577741314755-048d8525d31e?w=400' WHERE id = 11; -- Gym
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1461141346587-763ab02bced9?w=400' WHERE id = 12; -- Sports

-- Additional products
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400' WHERE id = 13;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400' WHERE id = 14;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1484788984921-03950022c9ef?w=400' WHERE id = 15;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400' WHERE id = 16;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400' WHERE id = 17;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=400' WHERE id = 18;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=400' WHERE id = 19;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?w=400' WHERE id = 20;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=400' WHERE id = 21;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1592286927505-bbb2a8fbe606?w=400' WHERE id = 22;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400' WHERE id = 23;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400' WHERE id = 24;
UPDATE tbl_products SET image = 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=400' WHERE id = 25; -- iPhone 17 Pro Max

-- Verify
SELECT id, name, LEFT(image, 60) as image_preview FROM tbl_products;
