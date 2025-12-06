-- Fix: Increase DECIMAL column sizes to handle large transaction amounts
-- Issue: Checkout error "Out of range value for column 'total_amount'"
-- Date: 2025-11-26

-- Increase tbl_orders.total_amount from DECIMAL(10,2) to DECIMAL(15,2)
-- Maximum value: from Rp 99,999,999.99 to Rp 9,999,999,999,999.99
ALTER TABLE tbl_orders 
MODIFY COLUMN total_amount DECIMAL(15,2) NOT NULL;

-- Increase tbl_order_items price and subtotal columns
ALTER TABLE tbl_order_items 
MODIFY COLUMN price DECIMAL(15,2) NOT NULL,
MODIFY COLUMN subtotal DECIMAL(15,2) NOT NULL;

-- Increase tbl_products.price for consistency
ALTER TABLE tbl_products 
MODIFY COLUMN price DECIMAL(15,2) NOT NULL;

-- Verify changes
SELECT 'Changes applied successfully!' as status;
DESCRIBE tbl_orders;
DESCRIBE tbl_order_items;
DESCRIBE tbl_products;
