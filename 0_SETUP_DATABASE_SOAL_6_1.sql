-- ============================================================================
-- SETUP DATABASE DAN TABEL UNTUK SOAL 6.1
-- ============================================================================

-- ============================================================================
-- LANGKAH 1: BUAT DATABASE DBPOS1
-- ============================================================================

-- LOKASI: phpMyAdmin → Tab "SQL" (tanpa pilih database)
-- COPY PASTE CODE INI:

CREATE DATABASE IF NOT EXISTS dbpos1;
USE dbpos1;


-- ============================================================================
-- LANGKAH 2: BUAT TABEL JENIS_PRODUK
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

CREATE TABLE jenis_produk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL
);

-- Insert data jenis produk
INSERT INTO jenis_produk (id, nama) VALUES
(1, 'Elektronik'),
(2, 'Makanan'),
(3, 'Pakaian'),
(4, 'Furniture');


-- ============================================================================
-- LANGKAH 3: BUAT TABEL PRODUK
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

CREATE TABLE produk (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jenis_produk_id INT NOT NULL,
    harga_jual DOUBLE NOT NULL,
    stok INT DEFAULT 0,
    FOREIGN KEY (jenis_produk_id) REFERENCES jenis_produk(id)
);

-- Insert data produk
INSERT INTO produk (nama, jenis_produk_id, harga_jual, stok) VALUES
('Laptop Asus', 1, 7500000, 50),
('Mouse Logitech', 1, 150000, 100),
('Keyboard Mechanical', 1, 500000, 75),
('Monitor LG 24"', 1, 2000000, 30),
('iPhone 15', 1, 15000000, 20),
('Nasi Goreng', 2, 25000, 0),
('Mie Ayam', 2, 20000, 0),
('Kaos Polos', 3, 75000, 100),
('Celana Jeans', 3, 250000, 50),
('Meja Kayu', 4, 1500000, 15),
('Kursi Kantor', 4, 850000, 25);


-- ============================================================================
-- LANGKAH 4: BUAT TABEL PELANGGAN
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

CREATE TABLE pelanggan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telepon VARCHAR(20),
    alamat TEXT,
    tgl_lahir DATE NOT NULL
);

-- Insert data pelanggan
INSERT INTO pelanggan (nama, email, telepon, alamat, tgl_lahir) VALUES
('John Doe', 'john@email.com', '081234567890', 'Jakarta', '1990-05-15'),
('Jane Smith', 'jane@email.com', '081234567891', 'Bandung', '1985-08-20'),
('Bob Wilson', 'bob@email.com', '081234567892', 'Surabaya', '1995-12-10'),
('Alice Brown', 'alice@email.com', '081234567893', 'Medan', '2000-03-25'),
('Charlie Davis', 'charlie@email.com', '081234567894', 'Yogyakarta', '1988-07-30'),
('Diana Evans', 'diana@email.com', '081234567895', 'Semarang', '1992-11-05'),
('Frank Miller', 'frank@email.com', '081234567896', 'Bali', '1998-02-14');


-- ============================================================================
-- LANGKAH 5: VERIFIKASI TABEL BERHASIL DIBUAT
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"

-- Lihat semua tabel
SHOW TABLES;

-- Cek data jenis_produk
SELECT * FROM jenis_produk;

-- Cek data produk
SELECT * FROM produk;

-- Cek data pelanggan
SELECT * FROM pelanggan;

-- 📸 SCREENSHOT: Ambil screenshot salah satu query di atas
--    untuk menunjukkan tabel berhasil dibuat dan berisi data


-- ============================================================================
-- RINGKASAN STRUKTUR DATABASE
-- ============================================================================

/*
DATABASE: dbpos1

TABEL 1: jenis_produk
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nama (VARCHAR 50)

TABEL 2: produk
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nama (VARCHAR 100)
- jenis_produk_id (INT, FOREIGN KEY → jenis_produk.id)
- harga_jual (DOUBLE)
- stok (INT)

TABEL 3: pelanggan
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nama (VARCHAR 100)
- email (VARCHAR 100)
- telepon (VARCHAR 20)
- alamat (TEXT)
- tgl_lahir (DATE)

DATA SAMPLE:
- 4 jenis produk (Elektronik, Makanan, Pakaian, Furniture)
- 11 produk dengan berbagai kategori harga
- 7 pelanggan dengan berbagai tanggal lahir
*/


-- ============================================================================
-- SETELAH SETUP SELESAI, LANJUT KE SOAL 6.1
-- ============================================================================

/*
Setelah semua tabel dibuat dan data diisi, lanjutkan ke:
→ File: SOAL_6_1_STORED_PROCEDURE_FUNCTION.sql
→ Mulai dari SOAL NO. 1: PROCEDURE PRO_NAIKAN_HARGA

PASTIKAN:
✓ Database dbpos1 sudah ada
✓ Tabel jenis_produk, produk, pelanggan sudah ada
✓ Data sudah terisi di semua tabel
✓ Query SHOW TABLES menampilkan 3 tabel

Jika sudah OK, lanjut eksekusi SOAL 6.1!
*/
