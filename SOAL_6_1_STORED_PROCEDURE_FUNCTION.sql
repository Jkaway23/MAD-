-- ============================================================================
-- SOAL 6.1 - STORED PROCEDURES DAN STORED FUNCTIONS
-- ============================================================================

-- Nama    : [ISI NAMA ANDA]
-- NIM     : [ISI NIM ANDA]
-- Kelas   : [ISI KELAS ANDA]
-- Tanggal : 27 November 2025

-- ============================================================================
-- SOAL NO. 1: PROCEDURE PRO_NAIKAN_HARGA
-- ============================================================================

-- LOKASI EKSEKUSI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

DELIMITER $$

DROP PROCEDURE IF EXISTS pro_naikan_harga$$

CREATE PROCEDURE pro_naikan_harga(
    IN jenis_produk INT,
    IN persentase_kenaikan INT
)
BEGIN
    UPDATE produk 
    SET harga_jual = harga_jual + (harga_jual * persentase_kenaikan / 100)
    WHERE jenis_produk_id = jenis_produk;
END$$

DELIMITER ;

-- VERIFIKASI PROCEDURE DIBUAT:
SHOW PROCEDURE STATUS WHERE Name = 'pro_naikan_harga';

-- 📸 SCREENSHOT 1: Hasil SHOW PROCEDURE STATUS


-- ============================================================================
-- TESTING PROCEDURE PRO_NAIKAN_HARGA
-- ============================================================================

-- LANGKAH 1: CEK HARGA SEBELUM DINAIKAN
-- LOKASI: Database dbpos1 → Tab "SQL"

SELECT 
    p.id,
    p.nama,
    p.harga_jual,
    jp.nama as jenis_produk
FROM produk p
JOIN jenis_produk jp ON p.jenis_produk_id = jp.id
WHERE p.jenis_produk_id = 1;

-- 📸 SCREENSHOT 2: Harga sebelum kenaikan untuk jenis_produk_id = 1


-- LANGKAH 2: PANGGIL PROCEDURE (NAIKAN HARGA 4%)
-- LOKASI: Database dbpos1 → Tab "SQL"

CALL pro_naikan_harga(1, 4);

-- Penjelasan:
-- Parameter 1: jenis_produk = 1 (ID jenis produk yang akan dinaikan)
-- Parameter 2: persentase_kenaikan = 4 (kenaikan 4%)


-- LANGKAH 3: CEK HARGA SETELAH DINAIKAN
-- LOKASI: Database dbpos1 → Tab "SQL"

SELECT 
    p.id,
    p.nama,
    p.harga_jual,
    jp.nama as jenis_produk
FROM produk p
JOIN jenis_produk jp ON p.jenis_produk_id = jp.id
WHERE p.jenis_produk_id = 1;

-- 📸 SCREENSHOT 3: Harga setelah kenaikan 4%
-- Contoh: Jika harga awal 100000, setelah naik 4% menjadi 104000


-- ============================================================================
-- SOAL NO. 2: FUNCTION UMUR
-- ============================================================================

-- LOKASI EKSEKUSI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

DELIMITER $$

DROP FUNCTION IF EXISTS umur$$

CREATE FUNCTION umur(tgl_lahir DATE)
RETURNS INT
BEGIN
    DECLARE umur_tahun INT;
    SET umur_tahun = YEAR(CURDATE()) - YEAR(tgl_lahir);
    RETURN umur_tahun;
END$$

DELIMITER ;

-- VERIFIKASI FUNCTION DIBUAT:
SHOW FUNCTION STATUS WHERE Name = 'umur';

-- 📸 SCREENSHOT 4: Hasil SHOW FUNCTION STATUS


-- ============================================================================
-- TESTING FUNCTION UMUR
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"

SELECT 
    nama,
    tgl_lahir,
    umur(tgl_lahir) AS umur
FROM pelanggan;

-- 📸 SCREENSHOT 5: Hasil query dengan kolom umur
-- Contoh:
-- nama: John Doe, tgl_lahir: 1990-05-15, umur: 35
-- nama: Jane Smith, tgl_lahir: 1985-08-20, umur: 40


-- ============================================================================
-- SOAL NO. 3: FUNCTION KATEGORI_HARGA
-- ============================================================================

-- LOKASI EKSEKUSI: Database dbpos1 → Tab "SQL"
-- COPY PASTE CODE INI:

DELIMITER $$

DROP FUNCTION IF EXISTS kategori_harga$$

CREATE FUNCTION kategori_harga(harga DOUBLE)
RETURNS VARCHAR(20)
BEGIN
    DECLARE kategori VARCHAR(20);
    
    IF harga >= 0 AND harga <= 500000 THEN
        SET kategori = 'murah';
    ELSEIF harga > 500000 AND harga <= 3000000 THEN
        SET kategori = 'sedang';
    ELSEIF harga > 3000000 AND harga <= 10000000 THEN
        SET kategori = 'mahal';
    ELSEIF harga > 10000000 THEN
        SET kategori = 'sangat mahal';
    ELSE
        SET kategori = 'tidak valid';
    END IF;
    
    RETURN kategori;
END$$

DELIMITER ;

-- VERIFIKASI FUNCTION DIBUAT:
SHOW FUNCTION STATUS WHERE Name = 'kategori_harga';

-- 📸 SCREENSHOT 6: Hasil SHOW FUNCTION STATUS


-- ============================================================================
-- TESTING FUNCTION KATEGORI_HARGA
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"

SELECT 
    nama,
    harga_jual,
    kategori_harga(harga_jual) AS kategori
FROM produk
ORDER BY harga_jual;

-- 📸 SCREENSHOT 7: Hasil query dengan kolom kategori
-- Contoh:
-- nama: Mouse, harga_jual: 150000, kategori: murah
-- nama: Laptop, harga_jual: 7500000, kategori: mahal
-- nama: Server, harga_jual: 15000000, kategori: sangat mahal


-- ============================================================================
-- TESTING DENGAN BERBAGAI NILAI
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"

SELECT 
    300000 AS harga,
    kategori_harga(300000) AS kategori
UNION ALL
SELECT 
    750000 AS harga,
    kategori_harga(750000) AS kategori
UNION ALL
SELECT 
    5000000 AS harga,
    kategori_harga(5000000) AS kategori
UNION ALL
SELECT 
    12000000 AS harga,
    kategori_harga(12000000) AS kategori;

-- 📸 SCREENSHOT 8: Testing berbagai kategori harga
-- Hasil yang diharapkan:
-- 300000    → murah
-- 750000    → sedang
-- 5000000   → mahal
-- 12000000  → sangat mahal


-- ============================================================================
-- VERIFIKASI AKHIR - SEMUA PROCEDURE DAN FUNCTION
-- ============================================================================

-- LOKASI: Database dbpos1 → Tab "SQL"

-- Lihat semua Stored Procedures
SHOW PROCEDURE STATUS WHERE Db = 'dbpos1';

-- 📸 SCREENSHOT 9: Daftar semua procedures


-- Lihat semua Stored Functions
SHOW FUNCTION STATUS WHERE Db = 'dbpos1';

-- 📸 SCREENSHOT 10: Daftar semua functions


-- ============================================================================
-- RANGKUMAN UNTUK LAPORAN
-- ============================================================================

/*
SOAL 6.1 - STORED PROCEDURES DAN STORED FUNCTIONS

1. PROCEDURE PRO_NAIKAN_HARGA
   ✓ Fungsi: Menaikkan harga_jual produk berdasarkan jenis_produk_id
   ✓ Parameter:
     - jenis_produk (INT): ID jenis produk yang akan dinaikan
     - persentase_kenaikan (INT): Persentase kenaikan (contoh: 4 untuk 4%)
   ✓ Testing: Berhasil menaikkan harga produk jenis_produk_id=1 sebesar 4%

2. FUNCTION UMUR
   ✓ Fungsi: Menghitung umur berdasarkan tanggal lahir
   ✓ Parameter: tgl_lahir (DATE)
   ✓ Return: Umur dalam tahun (INT)
   ✓ Testing: Berhasil menampilkan umur pelanggan

3. FUNCTION KATEGORI_HARGA
   ✓ Fungsi: Mengkategorikan harga produk
   ✓ Parameter: harga (DOUBLE)
   ✓ Return: Kategori harga (VARCHAR)
   ✓ Kategori:
     - 0-500rb: murah
     - 500rb-3jt: sedang
     - 3jt-10jt: mahal
     - >10jt: sangat mahal
   ✓ Testing: Berhasil mengkategorikan produk sesuai harga
*/


-- ============================================================================
-- CATATAN EKSEKUSI
-- ============================================================================

/*
LOKASI UNTUK SEMUA QUERY:
→ Sidebar kiri: Klik database "dbpos1"
→ Bagian atas: Klik tab "SQL"
→ Paste query di kotak putih
→ Klik tombol "Kirim"

URUTAN SCREENSHOT:
1. SHOW PROCEDURE STATUS pro_naikan_harga
2. SELECT harga sebelum kenaikan
3. SELECT harga setelah kenaikan (CALL procedure)
4. SHOW FUNCTION STATUS umur
5. SELECT pelanggan dengan kolom umur
6. SHOW FUNCTION STATUS kategori_harga
7. SELECT produk dengan kolom kategori
8. Testing berbagai nilai kategori
9. SHOW semua PROCEDURE
10. SHOW semua FUNCTION

PENTING:
- Semua query dijalankan di database "dbpos1", bukan "toko_db"
- Pastikan tabel produk, pelanggan, dan jenis_produk sudah ada
- Jika ada error "table doesn't exist", buat tabel dulu
*/
