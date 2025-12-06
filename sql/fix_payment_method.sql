-- Fix: Add missing payment_method column to tbl_orders
-- Date: 2025-11-23
-- Issue: HTTP 500 error when creating orders

ALTER TABLE tbl_orders 
ADD COLUMN payment_method ENUM('cod', 'transfer') NOT NULL DEFAULT 'cod' 
AFTER phone;
