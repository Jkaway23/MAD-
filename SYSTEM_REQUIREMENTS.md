# Dokumen System Requirements

## Studi Kasus: AIMVC Store - E-Commerce Platform

### Executive Summary

AIMVC Store adalah platform e-commerce berbasis web dan mobile yang memungkinkan pengguna untuk melakukan transaksi jual beli produk secara online. Sistem ini terdiri dari dua komponen utama: aplikasi web berbasis PHP MVC untuk manajemen dan aplikasi mobile berbasis Flutter untuk pelanggan.

---

## 1. BUSINESS REQUIREMENTS

### 1.1 Business Objectives
- Menyediakan platform e-commerce yang mudah digunakan untuk transaksi online
- Meningkatkan jangkauan pasar melalui aplikasi mobile
- Memberikan pengalaman berbelanja yang seamless dari browsing hingga checkout
- Menyediakan sistem manajemen produk dan pesanan yang efisien

### 1.2 Business Scope
- Target Pengguna: Penjual dan pembeli produk online
- Platform: Web browser dan Android mobile devices
- Coverage: Seluruh Indonesia
- Business Model: B2C (Business to Consumer)

### 1.3 Success Criteria
- Sistem dapat memproses minimal 100 transaksi per hari
- Response time maksimal 3 detik untuk setiap request
- Uptime sistem minimal 99%
- User satisfaction rate minimal 85%

---

## 2. STAKEHOLDERS

### 2.1 Primary Stakeholders
1. **Administrator/Penjual**
   - Mengelola produk (CRUD)
   - Mengelola kategori produk
   - Memproses pesanan
   - Melihat laporan penjualan

2. **Customer/Pembeli**
   - Mencari dan browse produk
   - Menambahkan produk ke keranjang
   - Melakukan checkout dan pembayaran
   - Tracking status pesanan

### 2.2 Secondary Stakeholders
- Developer: Maintenance dan pengembangan sistem
- Database Administrator: Maintenance database
- Customer Service: Menangani komplain dan pertanyaan

---

## 3. FUNCTIONAL REQUIREMENTS

### 3.1 User Management (FR-UM)

#### FR-UM-001: User Registration
**Priority:** High  
**Description:** Sistem harus dapat mendaftarkan user baru  
**Actor:** Customer  
**Precondition:** User belum terdaftar  
**Flow:**
1. User mengisi form registrasi (nama, email, password, telepon)
2. Sistem validasi input data
3. Sistem menyimpan data user ke database
4. Sistem menampilkan konfirmasi registrasi berhasil

**Acceptance Criteria:**
- Validasi email format harus valid
- Password minimal 6 karakter
- Email harus unique (tidak duplikat)
- Nama minimal 3 karakter

#### FR-UM-002: User Login
**Priority:** High  
**Description:** User dapat login ke sistem  
**Actor:** Customer, Administrator  
**Precondition:** User sudah terdaftar  
**Flow:**
1. User memasukkan email dan password
2. Sistem validasi credentials
3. Sistem membuat session
4. Sistem redirect ke dashboard

**Acceptance Criteria:**
- Login berhasil dengan credentials valid
- Error message jika credentials salah
- Session tersimpan di SharedPreferences (mobile) atau Cookie (web)
- Auto-redirect ke halaman products setelah login

#### FR-UM-003: User Logout
**Priority:** High  
**Description:** User dapat logout dari sistem  
**Actor:** Customer, Administrator  
**Flow:**
1. User klik tombol logout
2. Sistem tampilkan konfirmasi
3. Sistem hapus session data
4. Sistem redirect ke login page

**Acceptance Criteria:**
- Session data terhapus sempurna
- User tidak bisa akses halaman yang memerlukan login
- Konfirmasi dialog sebelum logout

---

### 3.2 Product Management (FR-PM)

#### FR-PM-001: View Product List
**Priority:** High  
**Description:** Sistem menampilkan daftar semua produk  
**Actor:** Customer, Administrator  
**Precondition:** Database memiliki data produk  
**Flow:**
1. User mengakses halaman produk
2. Sistem query data produk dari database
3. Sistem tampilkan produk dalam grid/list view
4. Setiap produk menampilkan: gambar, nama, harga, stok

**Acceptance Criteria:**
- Produk ditampilkan dalam grid 2 kolom (mobile)
- Produk out of stock ditandai dengan jelas
- Harga diformat dalam Rupiah dengan separator ribuan
- Gambar produk loading dengan placeholder

#### FR-PM-002: Search Product
**Priority:** High  
**Description:** User dapat mencari produk berdasarkan nama  
**Actor:** Customer  
**Flow:**
1. User input keyword di search box
2. Sistem filter produk secara real-time
3. Sistem tampilkan hasil pencarian

**Acceptance Criteria:**
- Search case-insensitive
- Real-time filtering (tidak perlu submit)
- Hasil kosong menampilkan message "Produk tidak ditemukan"

#### FR-PM-003: View Product Detail
**Priority:** High  
**Description:** User dapat melihat detail lengkap produk  
**Actor:** Customer  
**Precondition:** Produk ada di database  
**Flow:**
1. User klik produk dari list
2. Sistem query detail produk by ID
3. Sistem tampilkan informasi lengkap: nama, harga, stok, deskripsi, gambar besar
4. Tersedia quantity selector dan tombol add to cart

**Acceptance Criteria:**
- Gambar produk ditampilkan ukuran besar
- Stok tersedia ditampilkan
- Quantity selector min: 1, max: stok tersedia
- Button disabled jika stok = 0

#### FR-PM-004: Add Product (Admin)
**Priority:** High  
**Description:** Administrator dapat menambah produk baru  
**Actor:** Administrator  
**Flow:**
1. Admin akses form add product
2. Admin input: nama, kategori, harga, stok, deskripsi, upload gambar
3. Sistem validasi input
4. Sistem simpan ke database
5. Sistem upload gambar ke server

**Acceptance Criteria:**
- Validasi semua field required
- Upload gambar format: jpg, png, gif
- Maksimal size gambar: 2MB
- Harga dan stok harus numeric positive

#### FR-PM-005: Edit Product (Admin)
**Priority:** Medium  
**Description:** Administrator dapat mengubah data produk  
**Actor:** Administrator  
**Flow:**
1. Admin pilih produk yang akan diedit
2. Sistem tampilkan form dengan data existing
3. Admin ubah data yang diperlukan
4. Sistem simpan perubahan

**Acceptance Criteria:**
- Form pre-filled dengan data existing
- Validasi sama dengan add product
- Gambar lama dipertahankan jika tidak upload baru

#### FR-PM-006: Delete Product (Admin)
**Priority:** Medium  
**Description:** Administrator dapat menghapus produk  
**Actor:** Administrator  
**Flow:**
1. Admin pilih produk yang akan dihapus
2. Sistem tampilkan konfirmasi
3. Admin konfirmasi hapus
4. Sistem hapus data dan file gambar

**Acceptance Criteria:**
- Konfirmasi dialog sebelum delete
- File gambar di server ikut terhapus
- Soft delete atau hard delete (konfigurasi)

---

### 3.3 Shopping Cart Management (FR-SC)

#### FR-SC-001: Add to Cart
**Priority:** High  
**Description:** Customer dapat menambah produk ke keranjang  
**Actor:** Customer  
**Precondition:** User sudah login, produk tersedia  
**Flow:**
1. User pilih produk dan quantity
2. User klik tombol "Add to Cart"
3. Sistem validasi stok tersedia
4. Sistem simpan ke tabel cart dengan user_id
5. Sistem tampilkan konfirmasi

**Acceptance Criteria:**
- User harus login
- Quantity tidak boleh melebihi stok
- Jika produk sudah ada di cart, quantity ditambahkan
- Success message setelah add

#### FR-SC-002: View Cart
**Priority:** High  
**Description:** Customer dapat melihat isi keranjang belanja  
**Actor:** Customer  
**Precondition:** User sudah login  
**Flow:**
1. User akses halaman cart
2. Sistem query cart items by user_id
3. Sistem hitung subtotal per item dan total keseluruhan
4. Sistem tampilkan list cart items

**Acceptance Criteria:**
- Tampilkan: gambar produk, nama, harga satuan, quantity, subtotal
- Total keseluruhan di bagian bawah
- Tombol remove untuk setiap item
- Tombol checkout jika cart tidak kosong

#### FR-SC-003: Remove from Cart
**Priority:** High  
**Description:** Customer dapat menghapus item dari keranjang  
**Actor:** Customer  
**Flow:**
1. User klik tombol remove pada item
2. Sistem tampilkan konfirmasi
3. User konfirmasi
4. Sistem hapus item dari cart
5. Sistem refresh cart display dan total

**Acceptance Criteria:**
- Konfirmasi dialog sebelum hapus
- Total otomatis terupdate setelah hapus
- Jika cart kosong, tampilkan empty state

#### FR-SC-004: Update Cart Quantity
**Priority:** Medium  
**Description:** Customer dapat mengubah jumlah item di cart  
**Actor:** Customer  
**Flow:**
1. User ubah quantity via selector
2. Sistem validasi dengan stok tersedia
3. Sistem update quantity
4. Sistem hitung ulang subtotal dan total

**Acceptance Criteria:**
- Quantity min: 1, max: stok
- Auto-calculate subtotal
- Real-time update total

---

### 3.4 Order Management (FR-OM)

#### FR-OM-001: Checkout
**Priority:** High  
**Description:** Customer dapat melakukan checkout pesanan  
**Actor:** Customer  
**Precondition:** Cart tidak kosong, user login  
**Flow:**
1. User klik tombol checkout
2. Sistem tampilkan form: nama, telepon, alamat, payment method
3. User isi dan pilih metode pembayaran
4. User submit order
5. Sistem buat record di tabel orders dan order_items
6. Sistem kosongkan cart
7. Sistem tampilkan order success dengan order_id

**Acceptance Criteria:**
- Form validation semua field required
- Nama minimal 3 karakter
- Telepon minimal 10 digit
- Alamat minimal 10 karakter
- Payment method: Transfer, COD, E-Wallet
- Transaction success create order + order_items
- Cart cleared setelah checkout

#### FR-OM-002: View Order History
**Priority:** High  
**Description:** Customer dapat melihat riwayat pesanan  
**Actor:** Customer  
**Precondition:** User sudah login  
**Flow:**
1. User akses halaman order history
2. Sistem query orders by user_id
3. Sistem tampilkan list orders dengan status

**Acceptance Criteria:**
- Tampilkan: order_id, tanggal, total, status
- Status badge dengan warna berbeda:
  - Pending: Orange
  - Processing: Blue
  - Shipped: Purple
  - Completed: Green
  - Cancelled: Red
- Sorted by tanggal terbaru
- Pull-to-refresh untuk update data

#### FR-OM-003: View Order Detail
**Priority:** High  
**Description:** Customer dapat melihat detail pesanan  
**Actor:** Customer  
**Precondition:** Order exists untuk user  
**Flow:**
1. User klik order dari history
2. Sistem query order detail by order_id dan user_id
3. Sistem tampilkan:
   - Informasi order (ID, tanggal, status)
   - Informasi pengiriman
   - Payment method
   - List produk yang dibeli
   - Total pembayaran

**Acceptance Criteria:**
- Menampilkan semua detail order
- List produk dengan gambar, quantity, harga
- Total sesuai dengan data order
- Status badge sesuai current status

#### FR-OM-004: Update Order Status (Admin)
**Priority:** High  
**Description:** Admin dapat update status pesanan  
**Actor:** Administrator  
**Flow:**
1. Admin view order detail
2. Admin pilih status baru
3. Sistem update status
4. Sistem log perubahan status

**Acceptance Criteria:**
- Status progression logic:
  - Pending → Processing → Shipped → Completed
  - Setiap status bisa → Cancelled
- Timestamp setiap perubahan status
- Notifikasi ke customer (future enhancement)

---

### 3.5 Category Management (FR-CM)

#### FR-CM-001: View Categories
**Priority:** Medium  
**Description:** Sistem menampilkan daftar kategori produk  
**Actor:** Customer, Administrator  
**Flow:**
1. Sistem query data kategori
2. Sistem tampilkan list kategori

**Acceptance Criteria:**
- Tampilkan nama dan deskripsi kategori
- Dapat digunakan untuk filter produk

#### FR-CM-002: Add Category (Admin)
**Priority:** Medium  
**Description:** Admin dapat menambah kategori baru  
**Actor:** Administrator  
**Flow:**
1. Admin akses form add category
2. Admin input nama dan deskripsi
3. Sistem validasi
4. Sistem simpan ke database

**Acceptance Criteria:**
- Nama kategori unique
- Minimal 3 karakter

#### FR-CM-003: Filter Product by Category
**Priority:** Medium  
**Description:** Customer dapat filter produk berdasarkan kategori  
**Actor:** Customer  
**Flow:**
1. User pilih kategori
2. Sistem filter produk by category_id
3. Sistem tampilkan hasil

**Acceptance Criteria:**
- Filter tidak reload halaman (AJAX)
- Hasil filter dapat di-combine dengan search

---

### 3.6 API Integration (FR-API)

#### FR-API-001: REST API Endpoints
**Priority:** High  
**Description:** Sistem menyediakan REST API untuk mobile app  
**Endpoints:**
- `POST /api/login` - Authentication
- `POST /api/register` - Registration
- `GET /api/products` - Get all products
- `GET /api/product/{id}` - Get product detail
- `GET /api/categories` - Get categories
- `POST /api/cart/add` - Add to cart
- `GET /api/cart/{user_id}` - Get cart items
- `POST /api/cart/remove` - Remove cart item
- `POST /api/checkout` - Create order
- `GET /api/orders/{user_id}` - Get order history
- `GET /api/order/{id}/{user_id}` - Get order detail

**Acceptance Criteria:**
- Response format: JSON
- HTTP status codes proper (200, 201, 400, 401, 404, 500)
- CORS headers untuk cross-origin requests
- Error handling dengan message deskriptif

---

## 4. NON-FUNCTIONAL REQUIREMENTS

### 4.1 Performance Requirements (NFR-P)

#### NFR-P-001: Response Time
**Requirement:** Sistem harus merespon request dalam waktu maksimal 3 detik  
**Measurement:** Average response time untuk semua endpoints  
**Acceptance Criteria:**
- 95% request selesai dalam < 2 detik
- 99% request selesai dalam < 3 detik
- Page load time maksimal 5 detik

#### NFR-P-002: Throughput
**Requirement:** Sistem dapat menangani minimal 100 concurrent users  
**Measurement:** Stress testing dengan load tool  
**Acceptance Criteria:**
- 100 concurrent users dengan response time < 3s
- No timeout error pada normal load
- Database query optimization

#### NFR-P-003: Database Performance
**Requirement:** Query database harus efisien  
**Acceptance Criteria:**
- Index pada foreign keys dan frequent search columns
- Query time < 100ms untuk simple queries
- Query time < 500ms untuk complex queries dengan JOIN
- Connection pooling implemented

---

### 4.2 Scalability Requirements (NFR-S)

#### NFR-S-001: Horizontal Scalability
**Requirement:** Sistem dapat di-scale dengan menambah server  
**Acceptance Criteria:**
- Stateless API design
- Session management tidak tied ke single server
- Database dapat di-replicate

#### NFR-S-002: Data Growth
**Requirement:** Sistem dapat menampung data growth  
**Acceptance Criteria:**
- Database design support 1 juta produk
- Support 10 juta transaksi
- Archive strategy untuk old data

---

### 4.3 Security Requirements (NFR-SEC)

#### NFR-SEC-001: Authentication & Authorization
**Requirement:** Sistem harus memiliki mekanisme autentikasi yang aman  
**Acceptance Criteria:**
- Password di-hash dengan bcrypt/argon2
- Session token dengan expiry time
- Role-based access control (Admin vs Customer)
- Prevent brute force attack (rate limiting)

#### NFR-SEC-002: Data Security
**Requirement:** Data sensitif harus dilindungi  
**Acceptance Criteria:**
- HTTPS untuk semua komunikasi (production)
- SQL injection prevention (prepared statements)
- XSS prevention (input sanitization)
- CSRF token untuk form submission

#### NFR-SEC-003: API Security
**Requirement:** API endpoint harus secure  
**Acceptance Criteria:**
- API authentication dengan token
- Input validation semua parameter
- Rate limiting untuk prevent abuse
- CORS configuration proper

#### NFR-SEC-004: Payment Security
**Requirement:** Informasi payment harus aman  
**Acceptance Criteria:**
- PCI-DSS compliance (jika handle credit card)
- Payment gateway integration dengan encryption
- Log semua transaction dengan audit trail

---

### 4.4 Reliability Requirements (NFR-R)

#### NFR-R-001: Availability
**Requirement:** Sistem harus available minimal 99% uptime  
**Measurement:** Uptime monitoring  
**Acceptance Criteria:**
- Maximum downtime: 7 jam per bulan
- Scheduled maintenance di luar jam sibuk
- Backup server untuk critical components

#### NFR-R-002: Error Handling
**Requirement:** Sistem harus handle error dengan graceful  
**Acceptance Criteria:**
- User-friendly error messages
- No system error exposed ke user
- Error logging untuk debugging
- Fallback mechanism untuk critical operations

#### NFR-R-003: Data Backup
**Requirement:** Data harus di-backup regular  
**Acceptance Criteria:**
- Daily automated backup
- Backup retention 30 hari
- Backup verification (restore test)
- Off-site backup storage

#### NFR-R-004: Disaster Recovery
**Requirement:** Sistem dapat recovery dari failure  
**Acceptance Criteria:**
- Recovery Time Objective (RTO): 4 jam
- Recovery Point Objective (RPO): 1 jam
- Documented disaster recovery plan
- Regular DR testing

---

### 4.5 Usability Requirements (NFR-U)

#### NFR-U-001: User Interface
**Requirement:** UI harus intuitif dan mudah digunakan  
**Acceptance Criteria:**
- Material Design principles (mobile)
- Responsive design (web)
- Consistent navigation across pages
- Clear visual hierarchy
- Loading indicators untuk async operations

#### NFR-U-002: Accessibility
**Requirement:** Aplikasi accessible untuk berbagai user  
**Acceptance Criteria:**
- Text size adjustable
- Color contrast ratio WCAG AA compliant
- Screen reader support (semantic HTML)
- Keyboard navigation support (web)

#### NFR-U-003: Mobile User Experience
**Requirement:** Mobile app harus user-friendly  
**Acceptance Criteria:**
- Touch targets minimal 48x48dp
- Swipe gestures untuk navigation
- Pull-to-refresh untuk update data
- Offline handling dengan informative message
- Back button behavior consistent

#### NFR-U-004: Error Messages
**Requirement:** Error messages harus helpful  
**Acceptance Criteria:**
- Bahasa Indonesia untuk end user
- Specific error reason (bukan generic)
- Actionable suggestion untuk fix
- No technical jargon

---

### 4.6 Compatibility Requirements (NFR-C)

#### NFR-C-001: Browser Compatibility
**Requirement:** Web app compatible dengan major browsers  
**Acceptance Criteria:**
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

#### NFR-C-002: Mobile OS Compatibility
**Requirement:** Mobile app support Android devices  
**Acceptance Criteria:**
- Android 5.0 (API Level 21) minimum
- Tested on Android 10, 11, 12, 13, 14
- Support various screen sizes (4.5" - 7")
- Portrait and landscape orientation

#### NFR-C-003: Database Compatibility
**Requirement:** Database portability  
**Acceptance Criteria:**
- MySQL 5.7+
- MariaDB 10.2+
- Standard SQL syntax (avoid vendor-specific)

---

### 4.7 Maintainability Requirements (NFR-M)

#### NFR-M-001: Code Quality
**Requirement:** Code harus maintainable  
**Acceptance Criteria:**
- Follow coding standards (PSR untuk PHP, Dart style guide)
- Code documentation (comments, README)
- Modular architecture (MVC pattern)
- DRY principle (Don't Repeat Yourself)

#### NFR-M-002: Version Control
**Requirement:** Source code managed dengan version control  
**Acceptance Criteria:**
- Git repository
- Branching strategy (main, development, feature branches)
- Commit message yang descriptive
- .gitignore proper

#### NFR-M-003: Documentation
**Requirement:** Sistem harus well-documented  
**Acceptance Criteria:**
- API documentation (endpoints, parameters, responses)
- Database schema documentation
- Setup/installation guide
- User manual
- Developer guide

#### NFR-M-004: Logging
**Requirement:** System activity harus di-log  
**Acceptance Criteria:**
- Application log (info, warning, error)
- Access log (request/response)
- Error log dengan stack trace
- Log rotation policy
- Log level configurable

---

### 4.8 Portability Requirements (NFR-PO)

#### NFR-PO-001: Deployment Flexibility
**Requirement:** Aplikasi dapat di-deploy di berbagai environment  
**Acceptance Criteria:**
- Configuration file untuk environment-specific settings
- Environment variables support
- Docker containerization ready
- Deploy di shared hosting, VPS, atau cloud

#### NFR-PO-002: Data Migration
**Requirement:** Data dapat di-migrate antar environment  
**Acceptance Criteria:**
- SQL dump/restore support
- Migration scripts untuk schema changes
- Seed data untuk testing environment

---

### 4.9 Localization Requirements (NFR-L)

#### NFR-L-001: Language Support
**Requirement:** Sistem mendukung Bahasa Indonesia  
**Acceptance Criteria:**
- UI text dalam Bahasa Indonesia
- Error messages dalam Bahasa Indonesia
- Date/time format Indonesian (dd/mm/yyyy)
- Currency format Rupiah (Rp)

#### NFR-L-002: Timezone
**Requirement:** Sistem menggunakan timezone Indonesia  
**Acceptance Criteria:**
- Server timezone: Asia/Jakarta (WIB)
- Timestamp stored in UTC di database
- Display time converted to user timezone

---

## 5. SYSTEM CONSTRAINTS

### 5.1 Technical Constraints
- **Backend Framework:** PHP 7.4+ dengan MVC pattern custom
- **Mobile Framework:** Flutter 3.24.5 dengan Dart
- **Database:** MySQL 5.7+ atau MariaDB 10.2+
- **Web Server:** Apache 2.4+ dengan mod_rewrite
- **Development Tools:** 
  - Flutter SDK 3.24.5
  - Android Studio (IDE untuk Flutter development)
  - Android SDK dan emulator
  - Java JDK 17+
- **Minimum Server:** 2GB RAM, 2 CPU cores, 20GB storage
- **Development Machine:** Minimal 8GB RAM, 4 CPU cores (untuk menjalankan Android Studio dan emulator)

### 5.2 Business Constraints
- **Budget:** Development budget terbatas
- **Timeline:** 3 bulan untuk MVP (Minimum Viable Product)
- **Team:** 1-2 developers
- **Scope:** Indonesia market only

### 5.3 Regulatory Constraints
- **Data Privacy:** Comply dengan UU Perlindungan Data Pribadi
- **E-Commerce:** Sesuai peraturan e-commerce Indonesia
- **Tax:** Support PPh 22 untuk e-commerce

---

## 6. ASSUMPTIONS AND DEPENDENCIES

### 6.1 Assumptions
1. User memiliki koneksi internet untuk akses aplikasi
2. User Android minimal OS version 5.0
3. Payment gateway akan di-integrate di fase 2
4. Admin akses aplikasi via web browser
5. Product images size reasonable (< 2MB per image)

### 6.2 Dependencies
1. **External Services:**
   - Payment Gateway (Midtrans/Xendit) - future
   - SMS Gateway untuk OTP - future
   - Email service untuk notification - future

2. **Third-party Libraries:**
   - Flutter HTTP package
   - Flutter SharedPreferences
   - PHP mysqli untuk database

3. **Infrastructure:**
   - Web hosting dengan PHP dan MySQL support
   - Domain name dan SSL certificate (production)
   - Google Play Console account untuk publish APK
   
4. **Development Environment:**
   - Operating System: Linux Ubuntu 24.04 / Windows 10+ / macOS
   - Flutter SDK 3.24.5
   - Android Studio 2024.1.1+ (Arctic Fox atau lebih baru)
   - Android SDK Platform 34+
   - Android Emulator atau Physical Device untuk testing
   - Java JDK 17+ (biasanya bundled dengan Android Studio)

---

## 7. ACCEPTANCE CRITERIA SUMMARY

### 7.1 Functional Acceptance
✅ User dapat register dan login  
✅ User dapat browse dan search produk  
✅ User dapat add produk ke cart  
✅ User dapat checkout dan create order  
✅ User dapat view order history dan detail  
✅ Admin dapat manage products  
✅ API endpoints berfungsi dengan proper  

### 7.2 Non-Functional Acceptance
✅ Response time < 3 detik  
✅ Support 100 concurrent users  
✅ Uptime 99%  
✅ Password encrypted  
✅ Mobile app compatible dengan Android 5.0+  
✅ Code documented dengan proper  
✅ Error handling graceful  

---

## 8. USE CASE DIAGRAM

### 8.1 Use Case Overview

Use case diagram menggambarkan interaksi antara aktor (Customer dan Administrator) dengan sistem AIMVC Store.

```
                    AIMVC Store E-Commerce System
    
    Customer                                           Administrator
       |                                                      |
       |-----> [Register]                                    |
       |-----> [Login] <------------------------------------ |
       |-----> [Logout] <----------------------------------- |
       |-----> [Browse Products]                             |
       |-----> [Search Products]                             |
       |-----> [View Product Detail]                         |
       |-----> [Add to Cart]                                 |
       |-----> [View Cart]                                   |
       |-----> [Remove from Cart]                            |
       |-----> [Checkout]                                    |
       |-----> [View Order History]                          |
       |-----> [View Order Detail]                           |
       |                                          [Manage Products] <----
       |                                          [Add Product] <----
       |                                          [Edit Product] <----
       |                                          [Delete Product] <----
       |                                          [Manage Categories] <----
       |                                          [Update Order Status] <----
       |                                          [View All Orders] <----
    
    <<include>>
    [Login] -------> [Authenticate User]
    [Add to Cart] --> [Check Stock Availability]
    [Checkout] -----> [Validate Cart Items]
    [Checkout] -----> [Process Payment]
    [Checkout] -----> [Create Order]
    
    <<extend>>
    [Browse Products] <----- [Filter by Category]
    [Search Products] <----- [Sort Results]
```

### 8.2 Use Case Descriptions

#### UC-001: User Registration
**Actor:** Customer  
**Description:** Customer mendaftar akun baru di sistem  
**Preconditions:** Customer belum memiliki akun  
**Postconditions:** Akun customer berhasil dibuat dan tersimpan di database  
**Main Flow:**
1. Customer membuka halaman registrasi
2. Customer mengisi form (nama, email, password, telepon)
3. System melakukan validasi data
4. System menyimpan data ke database
5. System menampilkan konfirmasi registrasi berhasil
6. Use case selesai

**Alternative Flow:**
- 3a. Validasi gagal (email sudah terdaftar)
  - System menampilkan error message
  - Kembali ke step 2

#### UC-002: User Login
**Actor:** Customer, Administrator  
**Description:** User melakukan login ke sistem  
**Preconditions:** User sudah memiliki akun  
**Postconditions:** User berhasil login dan session dibuat  
**Main Flow:**
1. User membuka halaman login
2. User memasukkan email dan password
3. System melakukan autentikasi <<include Authenticate User>>
4. System membuat session
5. System redirect ke dashboard
6. Use case selesai

**Alternative Flow:**
- 3a. Autentikasi gagal
  - System menampilkan error message "Email atau password salah"
  - Kembali ke step 2

#### UC-003: Browse Products
**Actor:** Customer  
**Description:** Customer melihat daftar produk yang tersedia  
**Preconditions:** -  
**Postconditions:** Daftar produk ditampilkan  
**Main Flow:**
1. Customer membuka halaman products
2. System query produk dari database
3. System menampilkan produk dalam grid view
4. Use case selesai

**Extension Points:**
- <<extend Filter by Category>>: Customer dapat memfilter produk berdasarkan kategori

#### UC-004: Add to Cart
**Actor:** Customer  
**Description:** Customer menambahkan produk ke keranjang belanja  
**Preconditions:** Customer sudah login, produk tersedia  
**Postconditions:** Produk berhasil ditambahkan ke cart  
**Main Flow:**
1. Customer memilih produk dan quantity
2. Customer klik "Add to Cart"
3. System melakukan pengecekan stok <<include Check Stock Availability>>
4. System menyimpan item ke tabel cart
5. System menampilkan konfirmasi
6. Use case selesai

**Alternative Flow:**
- 3a. Stok tidak mencukupi
  - System menampilkan pesan "Stok tidak cukup"
  - Use case selesai

#### UC-005: Checkout
**Actor:** Customer  
**Description:** Customer melakukan checkout pesanan  
**Preconditions:** Cart tidak kosong, customer sudah login  
**Postconditions:** Order berhasil dibuat, cart dikosongkan  
**Main Flow:**
1. Customer membuka halaman cart
2. Customer klik tombol "Checkout"
3. System menampilkan form checkout
4. Customer mengisi informasi pengiriman dan memilih payment method
5. Customer submit order
6. System melakukan validasi cart <<include Validate Cart Items>>
7. System memproses pembayaran <<include Process Payment>>
8. System membuat order record <<include Create Order>>
9. System mengosongkan cart
10. System menampilkan order success page
11. Use case selesai

**Alternative Flow:**
- 6a. Validasi gagal (produk tidak tersedia)
  - System menampilkan error
  - Kembali ke cart
- 7a. Payment processing gagal
  - System menampilkan error
  - Kembali ke step 4

#### UC-006: Manage Products (Admin)
**Actor:** Administrator  
**Description:** Admin mengelola produk (CRUD operations)  
**Preconditions:** Admin sudah login  
**Postconditions:** Produk berhasil ditambah/diubah/dihapus  
**Main Flow:**
1. Admin membuka halaman product management
2. Admin memilih operasi (Add/Edit/Delete)
3. System menampilkan form sesuai operasi
4. Admin melakukan input/perubahan
5. System menyimpan perubahan ke database
6. System menampilkan konfirmasi
7. Use case selesai

#### UC-007: Update Order Status (Admin)
**Actor:** Administrator  
**Description:** Admin mengubah status pesanan customer  
**Preconditions:** Order exists, admin sudah login  
**Postconditions:** Status order berhasil diupdate  
**Main Flow:**
1. Admin membuka halaman orders
2. Admin memilih order yang akan diupdate
3. Admin mengubah status (Pending → Processing → Shipped → Completed)
4. System menyimpan perubahan
5. System mencatat timestamp perubahan
6. System menampilkan konfirmasi
7. Use case selesai

---

## 9. ACTIVITY DIAGRAM

### 9.1 Activity Diagram: User Registration Process

```
    [Start]
       |
       v
  [Open Registration Page]
       |
       v
  [Fill Registration Form]
  (Name, Email, Password, Phone)
       |
       v
  [Submit Form]
       |
       v
  <Validate Input>
       |
       +--[Invalid]-------> [Display Error Message]
       |                           |
       |                           v
    [Valid]                [Correct Input]
       |                           |
       v                           |
  <Check Email Unique>  <----------+
       |
       +--[Email Exists]--> [Display "Email already registered"]
       |                           |
    [Unique]                       |
       |                           v
       v                      [Try Again]
  [Hash Password]                  |
       |                           |
       v                           |
  [Save to Database]               |
       |                           |
       v                           |
  [Create User Record] <-----------+
       |
       v
  [Display Success Message]
       |
       v
  [Redirect to Login]
       |
       v
    [End]
```

### 9.2 Activity Diagram: Shopping and Checkout Process

```
    [Start]
       |
       v
  [Customer Browse Products]
       |
       +---<Search Product?>---[Yes]---> [Enter Search Keyword]
       |                                        |
       v                                        v
    [No]                              [Filter Product List]
       |                                        |
       +----------------------------------------+
       |
       v
  [View Product List]
       |
       v
  [Select Product]
       |
       v
  [View Product Detail]
       |
       v
  <Product Available?>
       |
       +--[No Stock]-----> [Display "Out of Stock"]
       |                           |
    [Yes]                          v
       |                      [Browse Other Products]
       v                                |
  [Select Quantity]                     |
       |                                |
       v                                |
  <Check Stock Sufficient?> <----------+
       |
       +--[Insufficient]---> [Show Error "Stock not enough"]
       |                              |
    [Sufficient]                      |
       |                              v
       v                         [Adjust Quantity]
  <User Logged In?>                   |
       |                              |
       +--[No]---------> [Redirect to Login] ----> [Login]
       |                                                |
    [Yes]                                              |
       |                                               |
       +<----------------------------------------------+
       |
       v
  [Add to Cart]
       |
       v
  [Save to Cart Table]
       |
       v
  [Display Success Notification]
       |
       v
  <Continue Shopping?>
       |
       +--[Yes]--------> [Back to Product List]
       |                          |
    [No]                          |
       |                          |
       +<-------------------------+
       |
       v
  [View Cart]
       |
       v
  [Display Cart Items]
  (Product, Quantity, Price, Subtotal)
       |
       v
  <Modify Cart?>
       |
       +--[Remove Item]---> [Delete from Cart]
       |                           |
       +--[Change Qty]----> [Update Quantity]
       |                           |
       v                           |
    [No Change]                    |
       |                           |
       +<--------------------------+
       |
       v
  <Cart Empty?>
       |
       +--[Yes]-------> [Display "Cart is empty"]
       |                        |
    [No]                        v
       |                   [End Process]
       v
  [Calculate Total]
       |
       v
  [Click Checkout]
       |
       v
  [Display Checkout Form]
       |
       v
  [Fill Shipping Information]
  (Name, Phone, Address)
       |
       v
  [Select Payment Method]
  (Transfer/COD/E-Wallet)
       |
       v
  [Submit Order]
       |
       v
  <Validate Form?>
       |
       +--[Invalid]------> [Show Validation Error]
       |                           |
    [Valid]                        v
       |                    [Correct Information]
       v                           |
  <Validate Stock Again> <---------+
       |
       +--[Stock Changed]----> [Update Cart & Show Error]
       |                                  |
    [Stock OK]                            v
       |                          [Review Cart Again]
       v                                  |
  [Create Order Record] <-----------------+
       |
       v
  [Create Order Items]
  (Link products to order)
       |
       v
  [Update Product Stock]
  (Decrease stock)
       |
       v
  [Clear Customer Cart]
       |
       v
  [Generate Order ID]
       |
       v
  [Send to Payment Gateway]
  (If online payment)
       |
       v
  <Payment Success?>
       |
       +--[Failed]------> [Cancel Order]
       |                      |
    [Success]                 v
       |              [Restore Stock]
       v                      |
  [Update Order Status]       v
  (Set to "Pending")   [Show Payment Error]
       |                      |
       v                      v
  [Display Order Success]  [End]
  (Order ID, Total)
       |
       v
  [Send Confirmation]
  (Email - future feature)
       |
       v
    [End]
```

### 9.3 Activity Diagram: Admin - Manage Products

```
    [Start]
       |
       v
  [Admin Login]
       |
       v
  [Navigate to Product Management]
       |
       v
  [Select Operation]
       |
       +--[Add Product]------+
       |                     |
       +--[Edit Product]-----+
       |                     |
       +--[Delete Product]---+
       |                     |
       v                     v
                    <Which Operation?>
                            |
        +-------------------+-------------------+
        |                   |                   |
     [Add]               [Edit]             [Delete]
        |                   |                   |
        v                   v                   |
  [Display Add Form]  [Select Product]          |
        |                   |                   |
        v                   v                   |
  [Fill Product Info] [Load Product Data]       |
  (Name, Category,          |                   |
   Price, Stock,            v                   |
   Description)      [Display Edit Form]        |
        |                   |                   |
        v                   v                   |
  [Upload Image]      [Modify Data]             |
        |                   |                   |
        v                   v                   v
  [Submit] ----------> [Submit] --------> [Confirm Delete]
        |                   |                   |
        v                   v                   v
  <Validate Input?>   <Validate Input?>   <Confirmed?>
        |                   |                   |
     [Invalid]           [Invalid]           [No]
        |                   |                   |
        v                   v                   v
  [Show Error]        [Show Error]        [Cancel Action]
        |                   |                   |
        v                   v                   v
  [Re-enter Data]     [Re-enter Data]        [End]
        |                   |
        +<------------------+
        |
     [Valid]
        |
        v
  [Process Upload Image]
        |
        v
  <Upload Success?>
        |
        +--[Failed]-------> [Show Upload Error]
        |                         |
     [Success]                    v
        |                   [Retry Upload]
        v                         |
  [Save Image Path] <-------------+
        |
        v
  [Insert/Update Database]
        |
        v
  <Database Operation Success?>
        |
        +--[Failed]-------> [Show DB Error]
        |                        |
     [Success]                   v
        |                   [Rollback]
        v                        |
  [Log Activity]                 v
        |                      [End]
        v
  [Display Success Message]
        |
        v
  [Refresh Product List]
        |
        v
    [End]

For Delete Operation:
  [Confirm Delete]
        |
        v
  <Confirmed?>
        |
     [Yes]
        |
        v
  [Check Product Usage]
  (Orders, Cart)
        |
        v
  <Product in Active Orders?>
        |
     [Yes]-----> [Show Warning]
        |            |
        |            v
        |       [Soft Delete Only]
        |            |
     [No]            |
        |            |
        +<-----------+
        |
        v
  [Delete Product Record]
        |
        v
  [Delete Product Image File]
        |
        v
  [Display Success]
        |
        v
    [End]
```

### 9.4 Activity Diagram: View Order History and Detail

```
    [Start]
       |
       v
  [Customer Login]
       |
       v
  [Navigate to Order History]
       |
       v
  [System Query Orders]
  (Filter by user_id)
       |
       v
  <Orders Exist?>
       |
       +--[No]----------> [Display "No Orders Yet"]
       |                          |
    [Yes]                         v
       |                    [Show "Start Shopping" Button]
       v                          |
  [Display Order List]            v
  (ID, Date, Total, Status)     [End]
       |
       v
  [Sort by Date DESC]
       |
       v
  <Select Order?>
       |
       +--[Pull to Refresh]----> [Reload Order List]
       |                                |
       +--[Back to Shopping]---------> [End]
       |                                
    [View Detail]
       |
       v
  [Click Order Item]
       |
       v
  [Navigate to Order Detail]
       |
       v
  [System Query Order Detail]
  (Order info + Order items)
       |
       v
  [Display Order Information]
       |
       +--[Order ID & Date]
       +--[Status Badge]
       +--[Customer Info]
       +--[Shipping Address]
       +--[Payment Method]
       |
       v
  [Display Order Items]
       |
       v
  [For Each Item: Loop]
       |
       +--[Product Image]
       +--[Product Name]
       +--[Quantity]
       +--[Price]
       +--[Subtotal]
       |
       v
  [Calculate Total Amount]
       |
       v
  [Display Total]
       |
       v
  <Check Order Status>
       |
       +--[Pending]-------> [Show "Processing" Message]
       +--[Processing]----> [Show "Being Processed"]
       +--[Shipped]-------> [Show "On Delivery" + Tracking]
       +--[Completed]-----> [Show "Completed" + Review Option]
       +--[Cancelled]-----> [Show "Cancelled" + Reason]
       |
       v
  <Customer Action?>
       |
       +--[Contact Support]---> [Open Support Chat]
       +--[Reorder]-----------> [Copy Items to Cart]
       +--[Back to History]---> [Return to Order List]
       |
       v
    [End]
```

### 9.5 Activity Diagram: Admin - Update Order Status

```
    [Start]
       |
       v
  [Admin Login]
       |
       v
  [Navigate to Orders Management]
       |
       v
  [Display All Orders]
  (All users)
       |
       v
  <Filter Orders?>
       |
       +--[By Status]-----> [Filter by Status]
       +--[By Date]-------> [Filter by Date Range]
       +--[By Customer]---> [Search by Customer]
       |
       v
  [Select Order]
       |
       v
  [View Order Detail]
       |
       v
  [Display Current Status]
       |
       v
  <Choose Action?>
       |
       +--[Update Status]
       +--[Cancel Order]
       +--[View Only]--------> [End]
       |
       v
  [Update Status Selected]
       |
       v
  [Display Status Options]
       |
       v
  <Current Status?>
       |
       +--[Pending]-------> [Options: Processing, Cancelled]
       +--[Processing]----> [Options: Shipped, Cancelled]
       +--[Shipped]-------> [Options: Completed, Cancelled]
       +--[Completed]-----> [No Change Allowed]
       +--[Cancelled]-----> [No Change Allowed]
       |
       v
  [Admin Select New Status]
       |
       v
  <Validate Status Transition?>
       |
       +--[Invalid]-------> [Show Error "Invalid Transition"]
       |                            |
    [Valid]                         v
       |                         [End]
       v
  <Cancellation?>
       |
    [Yes]
       |
       v
  [Request Cancellation Reason]
       |
       v
  [Input Reason]
       |
       v
  [Restore Product Stock]
       |
       v
  [Update Order Status]
       |
       v
  [Log Status Change]
  (Old Status, New Status, Timestamp, Admin)
       |
       v
  [Send Notification]
  (Email/SMS to Customer - future)
       |
       v
  [Display Success Message]
       |
       v
  [Refresh Order List]
       |
       v
    [End]

For Stock Restoration (Cancel):
  [Restore Product Stock]
       |
       v
  [Get Order Items]
       |
       v
  [For Each Item: Loop]
       |
       v
  [Get Product ID & Quantity]
       |
       v
  [Update Product Stock]
  (stock = stock + quantity)
       |
       v
  [Next Item]
       |
       v
  [All Items Processed]
       |
       v
  [Continue to Update Status]
```

### 9.6 Activity Diagram Summary

**Key Process Flows Documented:**
1. ✅ User Registration - Complete validation dan error handling
2. ✅ Shopping & Checkout - End-to-end customer journey
3. ✅ Admin Product Management - CRUD operations dengan image upload
4. ✅ Order History & Detail - Customer order tracking
5. ✅ Admin Order Status Update - Order fulfillment workflow

**Activity Diagram Features:**
- Decision points (<Diamond shapes>)
- Parallel activities ([Square brackets])
- Loop iterations (For Each loops)
- Error handling flows
- Alternative paths
- Synchronization points

---

## 10. GLOSSARY

| Term | Definition |
|------|------------|
| MVC | Model-View-Controller design pattern |
| API | Application Programming Interface |
| REST | Representational State Transfer |
| CRUD | Create, Read, Update, Delete |
| JWT | JSON Web Token untuk authentication |
| CORS | Cross-Origin Resource Sharing |
| SSL | Secure Sockets Layer |
| HTTPS | HTTP Secure |
| MVP | Minimum Viable Product |
| RTO | Recovery Time Objective |
| RPO | Recovery Point Objective |
| WCAG | Web Content Accessibility Guidelines |

---

## 11. AGILE DEVELOPMENT METHODOLOGY

### 11.1 Extreme Programming (XP) Iterations

Proyek AIMVC Store dikembangkan menggunakan metode Agile dengan XP (Extreme Programming) sebagai framework utama. Total durasi pengembangan adalah 60 hari dengan 6 iterasi.

#### Iteration 1: Foundation & Database Setup (10 hari)
**Tanggal:** 06-Okt-2025 s/d 15-Okt-2025

**Goals:**
- Setup environment pengembangan
- Membuat database schema
- Implementasi MVC framework
- Setup Apache & MySQL

**Deliverables:**
- ✅ Database `aimvc_store` dengan 5 tabel (users, products, categories, carts, orders)
- ✅ Core MVC framework (App.php, Controller.php, Database.php)
- ✅ Apache configuration dengan mod_rewrite
- ✅ Basic routing system

**XP Practices Applied:**
- **Simple Design:** Struktur MVC sederhana dan mudah dipahami
- **Continuous Integration:** Daily commit ke repository
- **Refactoring:** Optimasi database queries

**Testing:**
- Database connection testing
- Routing testing untuk URL friendly

---

#### Iteration 2: User Authentication & Product Management (10 hari)
**Tanggal:** 16-Okt-2025 s/d 25-Okt-2025

**Goals:**
- Implementasi sistem login/register
- CRUD produk untuk admin
- Session management
- Basic security implementation

**Deliverables:**
- ✅ Login_model.php dengan authentication logic
- ✅ Auth controller (login, register, logout)
- ✅ Product_model.php dengan CRUD operations
- ✅ Product controller & views
- ✅ Admin dashboard

**XP Practices Applied:**
- **Test-Driven Development:** Unit testing untuk authentication
- **Pair Programming (Self-review):** Code review sebelum commit
- **Small Releases:** Deploy authentication terlebih dahulu

**Testing:**
- Login dengan credentials valid/invalid
- Register dengan validasi input
- Product CRUD operations

---

#### Iteration 3: Shopping Cart & Category Features (10 hari)
**Tanggal:** 26-Okt-2025 s/d 04-Nov-2025

**Goals:**
- Implementasi shopping cart system
- Category management
- Session-based cart storage
- Frontend shopping experience

**Deliverables:**
- ✅ Cart_model.php dengan cart operations
- ✅ Category_model.php dengan category CRUD
- ✅ Shop controller & views
- ✅ Add to cart, update, remove functionality
- ✅ Category filter di product list

**XP Practices Applied:**
- **Continuous Testing:** Cart calculation testing
- **Refactoring:** Optimasi cart session storage
- **Collective Code Ownership:** Modular code structure

**Testing:**
- Add multiple products to cart
- Update quantity & remove items
- Cart total calculation
- Category filtering

---

#### Iteration 4: Checkout & Order Management (10 hari)
**Tanggal:** 05-Nov-2025 s/d 14-Nov-2025

**Goals:**
- Implementasi checkout process
- Order management system
- Payment integration preparation
- Order tracking

**Deliverables:**
- ✅ Order_model.php dengan order processing
- ✅ Checkout flow (shipping info, payment method)
- ✅ Order history & detail pages
- ✅ Admin order management
- ✅ Order status update system

**XP Practices Applied:**
- **Small Releases:** Deploy checkout dalam stages
- **Sustainable Pace:** Focus pada core features
- **Simple Design:** Straightforward checkout flow

**Testing:**
- Complete checkout process
- Order creation & storage
- Order status updates
- Order history display

---

#### Iteration 5: Mobile App Development (15 hari)
**Tanggal:** 15-Nov-2025 s/d 29-Nov-2025

**Goals:**
- Develop Flutter mobile application
- API integration
- 10 screens implementation
- Mobile-specific features

**Deliverables:**
- ✅ Flutter app dengan 10 screens:
  - Login & Register screens
  - Product List & Detail screens
  - Shopping Cart screen
  - Checkout screen
  - Order Success screen
  - Order History & Detail screens
  - Profile screen
- ✅ API controller dengan 11 endpoints
- ✅ API_service.dart untuk HTTP requests
- ✅ State management dengan Provider
- ✅ Shared Preferences untuk session

**XP Practices Applied:**
- **Continuous Integration:** Flutter build testing
- **Test-Driven Development:** Widget testing
- **Refactoring:** Code optimization untuk performance

**Testing:**
- API endpoint testing (Postman)
- Mobile app functional testing
- Login flow testing
- Complete shopping flow testing
- API integration testing

---

#### Iteration 6: Testing, Documentation & Deployment (5 hari)
**Tanggal:** 30-Nov-2025 s/d 04-Des-2025

**Goals:**
- Comprehensive testing
- Documentation completion
- Bug fixing
- Production deployment preparation

**Deliverables:**
- ✅ API_DOCUMENTATION.md (11 endpoints documented)
- ✅ FLUTTER_APP_DOCS.md (comprehensive guide)
- ✅ SYSTEM_REQUIREMENTS.md (complete SRS)
- ✅ BUSINESS_PROCESS.md (workflow documentation)
- ✅ Bug fixes & optimization
- ✅ Use Case Diagrams (7 diagrams)
- ✅ Activity Diagrams (6 diagrams)

**XP Practices Applied:**
- **Documentation:** Complete technical documentation
- **Acceptance Testing:** End-to-end testing
- **Customer Feedback:** Simulated user acceptance testing

**Testing:**
- Full system integration testing
- Performance testing
- Security testing
- Cross-platform compatibility testing

---

### 11.2 SCRUM Framework Implementation

#### 11.2.1 Scrum Team Roles

Karena proyek ini dikerjakan secara **individual**, maka satu developer menjalankan **multiple roles**:

**Developer (Solo):** [Your Name]

**Responsibilities:**
1. **Product Owner Role:**
   - Mendefinisikan product backlog
   - Menentukan prioritas fitur
   - Mendefinisikan acceptance criteria
   - Membuat keputusan tentang scope

2. **Scrum Master Role:**
   - Mengelola sprint planning
   - Memfasilitasi daily scrum (self-reflection)
   - Mengelola sprint review & retrospective
   - Menghilangkan impediments

3. **Development Team Role:**
   - Implementasi fitur (frontend & backend)
   - Testing & debugging
   - Documentation
   - Code review (self-review)

**Note:** Dalam pengembangan individual, semua roles dijalankan oleh satu person dengan time-boxing yang ketat untuk memastikan semua aspek tercakup.

---

#### 11.2.2 Product Backlog

Product Backlog berisi semua user stories yang akan dikembangkan, diurutkan berdasarkan prioritas dan business value.

| ID | User Story | Priority | Story Points | Estimasi (hari) | Status |
|----|------------|----------|--------------|-----------------|--------|
| PB-001 | Sebagai admin, saya ingin login ke sistem agar dapat mengelola produk | High | 5 | 2 | ✅ Done |
| PB-002 | Sebagai admin, saya ingin menambah produk baru agar dapat dijual | High | 8 | 3 | ✅ Done |
| PB-003 | Sebagai admin, saya ingin mengedit produk agar informasi tetap akurat | High | 5 | 2 | ✅ Done |
| PB-004 | Sebagai admin, saya ingin menghapus produk yang tidak dijual lagi | Medium | 3 | 1 | ✅ Done |
| PB-005 | Sebagai customer, saya ingin register akun agar dapat berbelanja | High | 5 | 2 | ✅ Done |
| PB-006 | Sebagai customer, saya ingin login untuk mengakses akun saya | High | 5 | 2 | ✅ Done |
| PB-007 | Sebagai customer, saya ingin melihat daftar produk yang tersedia | High | 8 | 3 | ✅ Done |
| PB-008 | Sebagai customer, saya ingin melihat detail produk sebelum membeli | High | 5 | 2 | ✅ Done |
| PB-009 | Sebagai customer, saya ingin menambahkan produk ke keranjang | High | 8 | 3 | ✅ Done |
| PB-010 | Sebagai customer, saya ingin mengubah quantity produk di keranjang | Medium | 5 | 2 | ✅ Done |
| PB-011 | Sebagai customer, saya ingin menghapus produk dari keranjang | Medium | 3 | 1 | ✅ Done |
| PB-012 | Sebagai customer, saya ingin checkout dan melakukan pembayaran | High | 13 | 5 | ✅ Done |
| PB-013 | Sebagai customer, saya ingin melihat history pesanan saya | Medium | 5 | 2 | ✅ Done |
| PB-014 | Sebagai customer, saya ingin melihat detail pesanan | Medium | 3 | 1 | ✅ Done |
| PB-015 | Sebagai admin, saya ingin melihat semua pesanan yang masuk | High | 5 | 2 | ✅ Done |
| PB-016 | Sebagai admin, saya ingin mengupdate status pesanan | High | 5 | 2 | ✅ Done |
| PB-017 | Sebagai customer, saya ingin menggunakan aplikasi mobile untuk belanja | High | 21 | 8 | ✅ Done |
| PB-018 | Sebagai developer, saya ingin API untuk mobile app integration | High | 13 | 5 | ✅ Done |
| PB-019 | Sebagai admin, saya ingin mengelola kategori produk | Medium | 5 | 2 | ✅ Done |
| PB-020 | Sebagai customer, saya ingin filter produk berdasarkan kategori | Medium | 5 | 2 | ✅ Done |
| PB-021 | Sebagai user, saya ingin dokumentasi lengkap sistem | Medium | 8 | 3 | ✅ Done |

**Total Story Points:** 180  
**Total Estimasi:** 60 hari  
**Status:** ✅ All items completed

---

#### 11.2.3 Sprint Planning

Sprint dilakukan dengan durasi **10 hari** (kecuali Sprint 5 yang 15 hari dan Sprint 6 yang 5 hari) untuk memberikan waktu yang cukup dalam pengembangan individual.

---

##### SPRINT 1: Foundation & Authentication (10 hari)
**Tanggal:** 06-Okt-2025 s/d 15-Okt-2025  
**Sprint Goal:** Setup project foundation dan implementasi user authentication system

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S1-T01 | Setup | Install Apache, MySQL, PHP | 4 | ✅ Done |
| S1-T02 | Setup | Create database schema | 4 | ✅ Done |
| S1-T03 | Setup | Setup MVC framework structure | 8 | ✅ Done |
| S1-T04 | Setup | Configure routing system | 4 | ✅ Done |
| S1-T05 | PB-001 | Create Login_model.php | 6 | ✅ Done |
| S1-T06 | PB-001 | Create Auth controller | 6 | ✅ Done |
| S1-T07 | PB-001 | Create login view | 4 | ✅ Done |
| S1-T08 | PB-001 | Implement session management | 4 | ✅ Done |
| S1-T09 | PB-005 | Create register functionality | 6 | ✅ Done |
| S1-T10 | PB-005 | Create register view | 4 | ✅ Done |
| S1-T11 | PB-006 | Implement login validation | 4 | ✅ Done |
| S1-T12 | Testing | Test authentication flow | 4 | ✅ Done |
| S1-T13 | Security | Implement password hashing | 3 | ✅ Done |
| S1-T14 | Security | Add CSRF protection | 3 | ✅ Done |

**Total Tasks:** 14  
**Total Hours:** 64 jam (8 hari kerja)  
**Story Points Completed:** 26  
**Sprint Result:** ✅ **SUCCESS** - Authentication system fully functional

---

##### SPRINT 2: Product Management (10 hari)
**Tanggal:** 16-Okt-2025 s/d 25-Okt-2025  
**Sprint Goal:** Implementasi complete product management system untuk admin

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S2-T01 | PB-002 | Create Product_model.php | 6 | ✅ Done |
| S2-T02 | PB-002 | Create Product controller | 6 | ✅ Done |
| S2-T03 | PB-002 | Create add product view | 6 | ✅ Done |
| S2-T04 | PB-002 | Implement image upload | 8 | ✅ Done |
| S2-T05 | PB-002 | Add product validation | 4 | ✅ Done |
| S2-T06 | PB-003 | Create edit product functionality | 6 | ✅ Done |
| S2-T07 | PB-003 | Create edit product view | 4 | ✅ Done |
| S2-T08 | PB-004 | Implement delete product | 4 | ✅ Done |
| S2-T09 | PB-019 | Create Category_model.php | 4 | ✅ Done |
| S2-T10 | PB-019 | Implement category CRUD | 6 | ✅ Done |
| S2-T11 | Testing | Test product CRUD operations | 6 | ✅ Done |
| S2-T12 | UI | Create admin dashboard | 8 | ✅ Done |

**Total Tasks:** 12  
**Total Hours:** 68 jam (8.5 hari kerja)  
**Story Points Completed:** 34  
**Sprint Result:** ✅ **SUCCESS** - Product management fully implemented

---

##### SPRINT 3: Shopping Cart & Frontend (10 hari)
**Tanggal:** 26-Okt-2025 s/d 04-Nov-2025  
**Sprint Goal:** Implementasi shopping cart system dan customer-facing features

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S3-T01 | PB-007 | Create shop controller | 6 | ✅ Done |
| S3-T02 | PB-007 | Create product list view | 6 | ✅ Done |
| S3-T03 | PB-008 | Create product detail view | 6 | ✅ Done |
| S3-T04 | PB-009 | Create Cart_model.php | 6 | ✅ Done |
| S3-T05 | PB-009 | Implement add to cart functionality | 6 | ✅ Done |
| S3-T06 | PB-009 | Create cart view | 6 | ✅ Done |
| S3-T07 | PB-010 | Implement update cart quantity | 4 | ✅ Done |
| S3-T08 | PB-011 | Implement remove from cart | 4 | ✅ Done |
| S3-T09 | PB-020 | Implement category filter | 6 | ✅ Done |
| S3-T10 | UI | Create responsive design | 8 | ✅ Done |
| S3-T11 | Testing | Test cart calculations | 4 | ✅ Done |
| S3-T12 | Testing | Test shopping flow | 6 | ✅ Done |

**Total Tasks:** 12  
**Total Hours:** 68 jam (8.5 hari kerja)  
**Story Points Completed:** 31  
**Sprint Result:** ✅ **SUCCESS** - Shopping cart fully functional

---

##### SPRINT 4: Checkout & Order Management (10 hari)
**Tanggal:** 05-Nov-2025 s/d 14-Nov-2025  
**Sprint Goal:** Implementasi checkout process dan order management system

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S4-T01 | PB-012 | Create Order_model.php | 6 | ✅ Done |
| S4-T02 | PB-012 | Create checkout view | 8 | ✅ Done |
| S4-T03 | PB-012 | Implement checkout logic | 8 | ✅ Done |
| S4-T04 | PB-012 | Implement payment method selection | 4 | ✅ Done |
| S4-T05 | PB-012 | Create order confirmation | 4 | ✅ Done |
| S4-T06 | PB-013 | Create order history view | 6 | ✅ Done |
| S4-T07 | PB-014 | Create order detail view | 6 | ✅ Done |
| S4-T08 | PB-015 | Create admin order list | 6 | ✅ Done |
| S4-T09 | PB-016 | Implement order status update | 6 | ✅ Done |
| S4-T10 | Testing | Test checkout process | 6 | ✅ Done |
| S4-T11 | Testing | Test order management | 4 | ✅ Done |

**Total Tasks:** 11  
**Total Hours:** 64 jam (8 hari kerja)  
**Story Points Completed:** 34  
**Sprint Result:** ✅ **SUCCESS** - Order system complete

---

##### SPRINT 5: Mobile Application Development (15 hari)
**Tanggal:** 15-Nov-2025 s/d 29-Nov-2025  
**Sprint Goal:** Develop complete Flutter mobile application dengan API integration

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S5-T01 | Setup | Install Flutter SDK | 4 | ✅ Done |
| S5-T02 | Setup | Create Flutter project | 2 | ✅ Done |
| S5-T03 | PB-018 | Create API controller | 8 | ✅ Done |
| S5-T04 | PB-018 | Implement 11 API endpoints | 12 | ✅ Done |
| S5-T05 | PB-018 | Test API with Postman | 4 | ✅ Done |
| S5-T06 | PB-017 | Create data models (4 models) | 6 | ✅ Done |
| S5-T07 | PB-017 | Create api_service.dart | 8 | ✅ Done |
| S5-T08 | PB-017 | Create login screen | 6 | ✅ Done |
| S5-T09 | PB-017 | Create register screen | 6 | ✅ Done |
| S5-T10 | PB-017 | Create product list screen | 8 | ✅ Done |
| S5-T11 | PB-017 | Create product detail screen | 6 | ✅ Done |
| S5-T12 | PB-017 | Create cart screen | 8 | ✅ Done |
| S5-T13 | PB-017 | Create checkout screen | 8 | ✅ Done |
| S5-T14 | PB-017 | Create order success screen | 4 | ✅ Done |
| S5-T15 | PB-017 | Create order history screen | 6 | ✅ Done |
| S5-T16 | PB-017 | Create profile screen | 4 | ✅ Done |

**Total Tasks:** 16  
**Total Hours:** 100 jam (12.5 hari kerja)  
**Story Points Completed:** 42  
**Sprint Result:** ✅ **SUCCESS** - Mobile app fully functional

---

##### SPRINT 6: Testing & Documentation (5 hari)
**Tanggal:** 30-Nov-2025 s/d 04-Des-2025  
**Sprint Goal:** Complete testing, documentation, dan preparation untuk submission

**Sprint Backlog:**

| Task ID | User Story | Task Description | Estimasi (jam) | Status |
|---------|------------|------------------|----------------|--------|
| S6-T01 | PB-021 | Create API_DOCUMENTATION.md | 6 | ✅ Done |
| S6-T02 | PB-021 | Create FLUTTER_APP_DOCS.md | 6 | ✅ Done |
| S6-T03 | PB-021 | Create SYSTEM_REQUIREMENTS.md | 8 | ✅ Done |
| S6-T04 | PB-021 | Create Use Case Diagrams | 4 | ✅ Done |
| S6-T05 | PB-021 | Create Activity Diagrams | 6 | ✅ Done |
| S6-T06 | Testing | Final integration testing | 10 | ✅ Done |

**Total Tasks:** 6  
**Total Hours:** 40 jam (5 hari kerja)  
**Story Points Completed:** 13  
**Sprint Result:** ✅ **SUCCESS** - Documentation complete & ready for submission

---

#### 11.2.4 Daily Scrum Activities

Dalam pengembangan individual, Daily Scrum dilakukan sebagai **self-reflection** setiap hari untuk tracking progress dan mengidentifikasi blockers.

**Format Daily Scrum (15 menit):**
1. Apa yang saya kerjakan kemarin?
2. Apa yang akan saya kerjakan hari ini?
3. Apakah ada impediments/blockers?

**Contoh Daily Scrum Logs:**

```
=== SPRINT 1 - Day 1 (06-Okt-2025) ===
Yesterday: -
Today: Install Apache, MySQL, PHP dan create database schema
Blockers: None

=== SPRINT 1 - Day 2 (07-Okt-2025) ===
Yesterday: Completed server installation dan database setup
Today: Build MVC framework structure dan routing system
Blockers: None

=== SPRINT 1 - Day 5 (10-Okt-2025) ===
Yesterday: Completed routing system
Today: Create Login_model.php dan Auth controller
Blockers: None

=== SPRINT 2 - Day 3 (18-Okt-2025) ===
Yesterday: Created Product_model dan controller
Today: Implement image upload untuk products
Blockers: Permission issue di folder upload - RESOLVED dengan chmod 755

=== SPRINT 3 - Day 4 (29-Okt-2025) ===
Yesterday: Completed shopping cart model
Today: Create cart view dan implement add to cart
Blockers: Session issue - RESOLVED dengan session_start()

=== SPRINT 4 - Day 6 (10-Nov-2025) ===
Yesterday: Completed checkout logic
Today: Create order history dan detail views
Blockers: None

=== SPRINT 5 - Day 8 (22-Nov-2025) ===
Yesterday: Completed API endpoints testing
Today: Create Flutter product list dan detail screens
Blockers: CORS issue - RESOLVED dengan header configuration

=== SPRINT 5 - Day 12 (26-Nov-2025) ===
Yesterday: Completed checkout screen
Today: Create order history screen
Blockers: API response parsing - RESOLVED dengan proper JSON handling

=== SPRINT 6 - Day 3 (02-Des-2025) ===
Yesterday: Completed Flutter documentation
Today: Create Use Case Diagrams
Blockers: None

=== SPRINT 6 - Day 5 (04-Des-2025) ===
Yesterday: Completed Activity Diagrams
Today: Final review dan testing
Blockers: None - READY FOR SUBMISSION
```

**Key Blockers Identified & Resolved:**
1. ✅ Permission issue di upload folder → chmod 755
2. ✅ Session management issue → proper session_start()
3. ✅ CORS issue untuk API → header configuration
4. ✅ JSON parsing di Flutter → proper model mapping

---

#### 11.2.5 Sprint Review

Sprint Review dilakukan di akhir setiap sprint untuk demo hasil kerja dan mendapatkan feedback.

##### Sprint 1 Review (15-Okt-2025)
**Demo:**
- ✅ MVC framework berjalan dengan baik
- ✅ Login/Register functionality working
- ✅ Session management implemented
- ✅ Password hashing dengan bcrypt

**Feedback & Improvements:**
- ✅ Add "Remember Me" feature → Added to backlog
- ✅ Improve error messages → Implemented di Sprint 2

**Sprint Goal Achievement:** 100% ✅

---

##### Sprint 2 Review (25-Okt-2025)
**Demo:**
- ✅ Product CRUD fully functional
- ✅ Image upload working
- ✅ Admin dashboard dengan product management
- ✅ Category management implemented

**Feedback & Improvements:**
- ✅ Add product search feature → Implemented di Sprint 3
- ✅ Add image preview before upload → Implemented

**Sprint Goal Achievement:** 100% ✅

---

##### Sprint 3 Review (04-Nov-2025)
**Demo:**
- ✅ Shopping cart fully functional
- ✅ Add/Update/Remove cart items working
- ✅ Cart calculation accurate
- ✅ Category filter working
- ✅ Product search implemented

**Feedback & Improvements:**
- ✅ Add cart item count badge → Implemented
- ✅ Improve responsive design → Enhanced

**Sprint Goal Achievement:** 100% ✅

---

##### Sprint 4 Review (14-Nov-2025)
**Demo:**
- ✅ Checkout process complete
- ✅ Order creation working
- ✅ Order history & detail views
- ✅ Admin order management
- ✅ Order status update

**Feedback & Improvements:**
- ✅ Add order confirmation email → Added to future backlog
- ✅ Add payment gateway → Added to Phase 2 backlog

**Sprint Goal Achievement:** 100% ✅

---

##### Sprint 5 Review (29-Nov-2025)
**Demo:**
- ✅ Flutter app dengan 10 screens completed
- ✅ 11 API endpoints working perfectly
- ✅ Complete shopping flow di mobile
- ✅ State management dengan Provider
- ✅ Session persistence dengan SharedPreferences

**Feedback & Improvements:**
- ✅ Add loading indicators → Implemented
- ✅ Add error handling untuk network issues → Implemented
- ✅ Add pull-to-refresh → Implemented

**Sprint Goal Achievement:** 100% ✅

---

##### Sprint 6 Review (04-Des-2025)
**Demo:**
- ✅ Complete documentation package:
  - API_DOCUMENTATION.md (11 endpoints)
  - FLUTTER_APP_DOCS.md (comprehensive)
  - SYSTEM_REQUIREMENTS.md (100+ pages)
  - BUSINESS_PROCESS.md
- ✅ 7 Use Case Diagrams
- ✅ 6 Activity Diagrams
- ✅ All testing completed
- ✅ System ready for deployment

**Feedback & Improvements:**
- ✅ Documentation comprehensive dan ready for submission
- ✅ System stable dan production-ready

**Sprint Goal Achievement:** 100% ✅

---

#### 11.2.6 Sprint Retrospective

##### Sprint 1 Retrospective
**What Went Well:**
- ✅ Environment setup lebih cepat dari estimasi
- ✅ MVC structure clean dan maintainable
- ✅ Authentication implementation smooth

**What Could Be Improved:**
- ⚠️ Database design bisa lebih dioptimalkan
- ⚠️ Testing coverage masih minimal

**Action Items:**
- ✅ Add database indexing di Sprint 2
- ✅ Implement unit testing di Sprint 2

---

##### Sprint 2 Retrospective
**What Went Well:**
- ✅ Image upload implementation successful
- ✅ Admin dashboard UI intuitive
- ✅ Category management straightforward

**What Could Be Improved:**
- ⚠️ File validation perlu diperkuat
- ⚠️ Error handling bisa lebih descriptive

**Action Items:**
- ✅ Enhanced file validation implemented
- ✅ Improved error messages

---

##### Sprint 3 Retrospective
**What Went Well:**
- ✅ Cart system calculation accurate
- ✅ Session management stable
- ✅ Responsive design working well

**What Could Be Improved:**
- ⚠️ Cart persistence saat logout
- ⚠️ Product search bisa lebih advanced

**Action Items:**
- ✅ Noted untuk future enhancement
- ✅ Basic search sufficient untuk MVP

---

##### Sprint 4 Retrospective
**What Went Well:**
- ✅ Checkout flow intuitive
- ✅ Order management comprehensive
- ✅ Status update system working well

**What Could Be Improved:**
- ⚠️ Payment integration tidak included
- ⚠️ Email notification tidak implemented

**Action Items:**
- ✅ Payment gateway → Phase 2 backlog
- ✅ Email → Phase 2 backlog

---

##### Sprint 5 Retrospective
**What Went Well:**
- ✅ Flutter learning curve manageable
- ✅ API integration smooth
- ✅ Mobile UI clean dan user-friendly
- ✅ State management dengan Provider effective

**What Could Be Improved:**
- ⚠️ Initial CORS issue delayed progress
- ⚠️ JSON parsing needs better error handling

**Action Items:**
- ✅ CORS configuration documented
- ✅ Error handling improved

---

##### Sprint 6 Retrospective
**What Went Well:**
- ✅ Documentation comprehensive
- ✅ Use Case & Activity Diagrams clear
- ✅ Final testing thorough
- ✅ All deliverables completed on time

**What Could Be Improved:**
- ⚠️ Documentation bisa dimulai lebih awal
- ⚠️ Automated testing bisa lebih extensive

**Action Items:**
- ✅ Lesson learned: continuous documentation
- ✅ Consider automated testing untuk future projects

---

##### Overall Project Retrospective

**Project Summary:**
- **Duration:** 60 hari (06-Okt-2025 s/d 04-Des-2025)
- **Total Sprints:** 6
- **Total Story Points:** 180
- **Total Tasks Completed:** 71
- **Sprint Success Rate:** 100%

**Major Achievements:**
1. ✅ Complete e-commerce platform (Web + Mobile)
2. ✅ 11 REST API endpoints
3. ✅ 10 Flutter screens fully functional
4. ✅ Comprehensive documentation package
5. ✅ All requirements met on time

**Technical Highlights:**
- ✅ Clean MVC architecture
- ✅ RESTful API design
- ✅ Secure authentication
- ✅ Responsive UI/UX
- ✅ Cross-platform compatibility

**Lessons Learned:**
1. **Time Management:** Solo development requires strict time-boxing
2. **Documentation:** Continuous documentation lebih baik daripada di akhir
3. **Testing:** Early testing prevents late-stage bugs
4. **Scope Management:** Focus on MVP first, enhancements later
5. **Tool Selection:** Flutter + PHP combination effective untuk e-commerce

**Success Metrics Achieved:**
- ✅ 100% user stories completed
- ✅ 0 critical bugs
- ✅ On-time delivery
- ✅ Comprehensive documentation
- ✅ Production-ready application

**Future Enhancements (Phase 2 Backlog):**
1. Payment gateway integration (Midtrans/GoPay)
2. Email/SMS notifications
3. Product reviews & ratings
4. Wishlist feature
5. Advanced search & filtering
6. Analytics dashboard
7. Multi-language support

**Velocity Analysis:**
| Sprint | Story Points | Days | Velocity (points/day) |
|--------|--------------|------|-----------------------|
| Sprint 1 | 26 | 10 | 2.6 |
| Sprint 2 | 34 | 10 | 3.4 |
| Sprint 3 | 31 | 10 | 3.1 |
| Sprint 4 | 34 | 10 | 3.4 |
| Sprint 5 | 42 | 15 | 2.8 |
| Sprint 6 | 13 | 5 | 2.6 |
| **Average** | **30** | **10** | **3.0** |

**Team Performance (Individual):**
- **Average Velocity:** 3.0 story points per day
- **Consistency:** High (all sprints met goals)
- **Quality:** Excellent (no major rework needed)
- **Documentation:** Comprehensive
- **Technical Skills:** Full-stack development demonstrated

---

### 11.3 Agile Principles Applied

**1. Customer Satisfaction through Early & Continuous Delivery:**
- ✅ MVP delivered di Sprint 4
- ✅ Mobile app di Sprint 5
- ✅ Continuous improvements setiap sprint

**2. Welcome Changing Requirements:**
- ✅ Added search feature berdasarkan feedback Sprint 2
- ✅ Enhanced error handling berdasarkan testing
- ✅ Improved UI/UX berdasarkan user feedback simulation

**3. Deliver Working Software Frequently:**
- ✅ Working software setiap akhir sprint
- ✅ 10-day iterations untuk feedback cepat

**4. Sustainable Development:**
- ✅ 8 jam/hari work schedule
- ✅ No overtime yang excessive
- ✅ Quality maintained throughout

**5. Continuous Attention to Technical Excellence:**
- ✅ Code refactoring dilakukan regular
- ✅ Best practices diterapkan (MVC, REST, Clean Code)
- ✅ Testing integrated dalam development

**6. Simplicity:**
- ✅ Simple design yang effective
- ✅ Focus on essential features first
- ✅ Avoid over-engineering

**7. Self-Organizing Teams:**
- ✅ Individual project dengan full ownership
- ✅ Decision making autonomy
- ✅ Proactive problem-solving

**8. Regular Reflection:**
- ✅ Daily scrum untuk tracking
- ✅ Sprint retrospectives untuk improvement
- ✅ Continuous learning mindset

---

### 11.4 SCRUM Artifacts Summary

**1. Product Backlog:**
- 21 user stories
- Prioritized by business value
- Continuously refined

**2. Sprint Backlogs (6 sprints):**
- 71 detailed tasks
- Time-boxed estimates
- Clear acceptance criteria

**3. Increment:**
- Working software setiap sprint
- Cumulative functionality
- Production-ready quality

**4. Definition of Done (DoD):**
- ✅ Code implemented & tested
- ✅ Documentation updated
- ✅ No critical bugs
- ✅ Acceptance criteria met
- ✅ Code reviewed (self-review)

**5. Burn-down Chart (Conceptual):**
```
Story Points Remaining:
Sprint 1: 180 → 154 (26 completed)
Sprint 2: 154 → 120 (34 completed)
Sprint 3: 120 → 89 (31 completed)
Sprint 4: 89 → 55 (34 completed)
Sprint 5: 55 → 13 (42 completed)
Sprint 6: 13 → 0 (13 completed)

✅ All 180 story points delivered
```

---

## 12. REVISION HISTORY

| Version | Date | Author | Description |
|---------|------|--------|-------------|
| 1.0 | 05-Dec-2025 | Development Team | Initial requirements document |
| 1.1 | 05-Dec-2025 | Development Team | Added Use Case Diagrams and Activity Diagrams |
| 2.0 | 05-Dec-2025 | Development Team | Added complete Agile/XP Iterations and SCRUM Framework documentation |

---

**Document Status:** ✅ Approved  
**Next Review Date:** 05-Mar-2026  
**Contact:** development@aimvcstore.com

---

## APPENDIX A: SCRUM ARTIFACTS

### A.1 Sprint Planning Template
```
Sprint Number: [X]
Sprint Duration: [X days]
Sprint Goal: [Goal statement]

Selected User Stories:
- PB-XXX: [Story description] - [X story points]

Sprint Backlog Tasks:
1. [Task description] - [X hours]
2. ...

Team Capacity: [X hours]
Commitment: [X story points]
```

### A.2 Daily Scrum Template
```
Date: [DD-MMM-YYYY]
Sprint: [Sprint X - Day Y]

Yesterday: [What was accomplished]
Today: [What will be accomplished]
Blockers: [Any impediments]
```

### A.3 Sprint Review Template
```
Sprint Number: [X]
Review Date: [DD-MMM-YYYY]

Completed Items:
- [List of completed user stories]

Demo:
- [What was demonstrated]

Feedback:
- [Stakeholder feedback]

Improvements for Next Sprint:
- [Action items]
```

### A.4 Sprint Retrospective Template
```
Sprint Number: [X]
Retrospective Date: [DD-MMM-YYYY]

What Went Well:
- [Positive aspects]

What Could Be Improved:
- [Areas for improvement]

Action Items:
- [Concrete actions for next sprint]
```

---

**END OF SYSTEM REQUIREMENTS DOCUMENT**
