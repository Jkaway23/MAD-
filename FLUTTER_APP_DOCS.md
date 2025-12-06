# AIMVC Mobile App - Dokumentasi Lengkap

## 📱 Overview

AIMVC Mobile App adalah aplikasi e-commerce mobile lengkap yang dibangun dengan Flutter 3.24.5, terintegrasi dengan backend AIMVC Store (PHP MVC). Aplikasi ini menyediakan pengalaman berbelanja yang lengkap dari browsing produk hingga checkout dan tracking pesanan.

## ✨ Fitur Lengkap

### 1. 🔐 Autentikasi
- **Login**: Email & password validation dengan session management
- **Register**: Pendaftaran user baru dengan konfirmasi password
- **Session Persistent**: Menggunakan SharedPreferences untuk menyimpan login session
- **Auto Navigation**: Redirect otomatis sesuai status login

### 2. 🛍️ Manajemen Produk
- **Product List**: Grid view dengan thumbnail, nama, harga, dan stok
- **Live Search**: Pencarian real-time produk
- **Product Detail**: Informasi lengkap dengan gambar besar dan deskripsi
- **Quantity Selector**: Pilih jumlah produk sebelum tambah ke keranjang
- **Stock Validation**: Validasi ketersediaan stok otomatis
- **Price Formatting**: Format harga Rupiah dengan separator

### 3. 🛒 Shopping Cart
- **Add to Cart**: Tambah produk dengan quantity pilihan
- **View Cart**: Lihat semua item dengan subtotal per item
- **Update Quantity**: Ubah jumlah item (implementasi bisa ditambahkan)
- **Remove Item**: Hapus item dengan konfirmasi dialog
- **Cart Total**: Kalkulasi total otomatis dari backend API
- **Empty State**: Tampilan khusus saat keranjang kosong

### 4. 💳 Checkout & Payment
- **Customer Info Form**: Input nama, telepon, alamat pengiriman
- **Form Validation**: Validasi lengkap semua input field
- **Payment Methods**: 
  - Transfer Bank (BCA, Mandiri, BNI, BRI)
  - COD (Cash on Delivery)
  - E-Wallet (GoPay, OVO, DANA, ShopeePay)
- **Order Summary**: Review total pembayaran sebelum submit
- **Transaction Processing**: Proses checkout dengan API backend

### 5. 📦 Order Management
- **Order Success**: Konfirmasi pesanan dengan nomor order dan total
- **Order History**: Daftar semua pesanan dengan status badges:
  - 🟠 Pending (Menunggu)
  - 🔵 Processing (Diproses)
  - 🟣 Shipped (Dikirim)
  - 🟢 Completed (Selesai)
  - 🔴 Cancelled (Dibatalkan)
- **Order Detail**: Informasi lengkap:
  - Nomor pesanan dan tanggal
  - Status pesanan
  - Informasi pengiriman (nama, telepon, alamat)
  - Metode pembayaran
  - List produk yang dibeli
  - Total pembayaran
- **Pull to Refresh**: Refresh data pesanan

### 6. 👤 User Profile
- **Profile Display**: Avatar, nama, dan email user
- **Menu Options**:
  - 📦 Pesanan Saya (link ke order history)
  - 📍 Alamat (untuk pengembangan)
  - 💳 Metode Pembayaran (untuk pengembangan)
  - 🔔 Notifikasi (untuk pengembangan)
  - ❓ Bantuan & FAQ (untuk pengembangan)
  - ℹ️ Tentang Aplikasi (versi 1.0.0)
- **Logout**: Hapus session dengan konfirmasi dialog
- **Navigation**: Bottom navigation bar ke semua menu utama

## 🏗️ Struktur Aplikasi

### File Structure
```
aimvc_mobile_app/
├── lib/
│   ├── main.dart                       # Entry point & routing config
│   ├── models/                         # Data Models
│   │   ├── product.dart               # Product model
│   │   ├── user.dart                  # User model  
│   │   ├── category.dart              # Category model
│   │   └── order.dart                 # Order & OrderItem models
│   ├── screens/                        # UI Screens
│   │   ├── login_screen.dart          # Login page
│   │   ├── register_screen.dart       # Registration page
│   │   ├── product_list_screen.dart   # Product browsing
│   │   ├── product_detail_screen.dart # Product detail view
│   │   ├── cart_screen.dart           # Shopping cart
│   │   ├── checkout_screen.dart       # Checkout form
│   │   ├── order_success_screen.dart  # Order confirmation
│   │   ├── order_history_screen.dart  # Order list
│   │   ├── order_detail_screen.dart   # Order detail view
│   │   └── profile_screen.dart        # User profile
│   ├── services/
│   │   └── api_service.dart           # HTTP API client
│   ├── widgets/                        # Reusable widgets
│   └── utils/                          # Helper functions
├── android/                            # Android platform
├── ios/                                # iOS platform  
├── web/                                # Web platform
├── pubspec.yaml                        # Dependencies
└── README.md

```

### Dependencies
```yaml
dependencies:
  flutter:
    sdk: flutter
  cupertino_icons: ^1.0.8
  http: ^1.6.0                    # HTTP requests
  shared_preferences: ^2.5.3     # Local storage
  provider: ^6.1.5                # State management
```

## 🔀 Navigation & Routing

### Route Configuration

| Route | Screen | Arguments | Description |
|-------|--------|-----------|-------------|
| `/login` | LoginScreen | - | User login |
| `/register` | RegisterScreen | - | User registration |
| `/products` | ProductListScreen | - | Browse products (initial route) |
| `/product-detail` | ProductDetailScreen | `Product` | View product details |
| `/cart` | CartScreen | - | Shopping cart |
| `/checkout` | CheckoutScreen | `double totalAmount` | Checkout form |
| `/order-success` | OrderSuccessScreen | `Map<orderId, totalAmount>` | Order confirmation |
| `/order-history` | OrderHistoryScreen | - | List of orders |
| `/order-detail` | OrderDetailScreen | `int orderId` | Order details |
| `/profile` | ProfileScreen | - | User profile |

### Navigation Flow

```
Login/Register → Products → Product Detail → Cart → Checkout → Order Success
                     ↓                          ↓
                 Profile ←→ Order History → Order Detail
```

## 🌐 API Integration

### Base URL Configuration
```dart
// For Android Emulator
static const String baseUrl = 'http://10.0.2.2/lecture27/aimvc/public';

// For Physical Device (replace with your IP)
// static const String baseUrl = 'http://192.168.1.100/lecture27/aimvc/public';
```

### API Endpoints Used

| Method | Endpoint | Purpose | Auth Required |
|--------|----------|---------|---------------|
| POST | `/api/login` | User authentication | No |
| POST | `/api/register` | New user registration | No |
| GET | `/api/products` | Get all products | No |
| GET | `/api/product/{id}` | Get product detail | No |
| GET | `/api/categories` | Get all categories | No |
| POST | `/api/cart/add` | Add item to cart | Yes |
| GET | `/api/cart/{user_id}` | Get cart items | Yes |
| POST | `/api/cart/remove` | Remove cart item | Yes |
| POST | `/api/checkout` | Create order | Yes |
| GET | `/api/orders/{user_id}` | Get order history | Yes |
| GET | `/api/order/{id}/{user_id}` | Get order detail | Yes |

### Authentication Flow

1. **Login/Register**: Receive user data from API
2. **Store Session**: Save to SharedPreferences:
   - `user_id`
   - `user_name`
   - `user_email`
   - `token` (if implemented)
3. **API Calls**: Include `user_id` in authenticated requests
4. **Logout**: Clear all SharedPreferences data

## 🎨 UI/UX Features

### Design System
- **Material Design 3**: Modern UI components
- **Color Scheme**: Blue primary color
- **Responsive**: Adaptive layouts for different screen sizes
- **Icons**: Material Icons for consistent look

### User Experience
- **Loading States**: CircularProgressIndicator during API calls
- **Error Handling**: User-friendly error messages via SnackBar
- **Empty States**: Helpful messages when no data available
- **Pull to Refresh**: Refresh data gestures
- **Confirmation Dialogs**: Confirm destructive actions
- **Navigation Bar**: Bottom navigation for main sections
- **Search**: Real-time filtering with debounce

### Image Handling
- **Network Images**: Load from backend server
- **Error Fallback**: Icon placeholder on error
- **Loading**: Grey placeholder during load
- **Caching**: Automatic by Flutter's Image.network

## 🧪 Testing Guide

### 1. Run on Linux Desktop (Quick Test)
```bash
cd /var/www/html/lecture27/aimvc/aimvc_mobile_app
flutter run -d linux
```

### 2. Run on Android Emulator
```bash
# Start emulator first
flutter emulators --launch <emulator_name>

# Run app
flutter run
```

### 3. Test Scenarios

**Authentication Test:**
1. Register new user
2. Login with credentials
3. Verify session persistence (restart app)
4. Test logout

**Shopping Flow Test:**
1. Browse products
2. Search for products
3. View product detail
4. Add multiple items to cart
5. Modify cart (remove items)
6. Checkout with different payment methods
7. View order in history
8. Check order details

**Edge Cases:**
- Login with wrong credentials
- Add product with 0 stock
- Checkout with empty cart
- Network error handling
- Session expiry

## 🚀 Build & Deployment

### Build APK for Android
```bash
# Build debug APK
flutter build apk --debug

# Build release APK
flutter build apk --release

# Build App Bundle (for Play Store)
flutter build appbundle --release
```

### APK Location
```
build/app/outputs/flutter-apk/app-release.apk
```

### Build for iOS
```bash
# Requires macOS and Xcode
flutter build ios --release
```

## 🔧 Configuration

### Change Backend URL

Edit `lib/services/api_service.dart`:
```dart
static const String baseUrl = 'http://YOUR_IP/lecture27/aimvc/public';
```

### Change App Name

Edit `android/app/src/main/AndroidManifest.xml`:
```xml
<application
    android:label="AIMVC Store"
    ...>
```

### Change App Icon

Replace files in:
- `android/app/src/main/res/mipmap-*/ic_launcher.png`
- `ios/Runner/Assets.xcassets/AppIcon.appiconset/`

## 📝 Development Notes

### State Management
- Currently using `setState()` for local state
- SharedPreferences for persistent data
- Can be upgraded to Provider/Riverpod for complex state

### Future Enhancements
1. **Wishlist**: Save favorite products
2. **Product Reviews**: Rating and comments
3. **Push Notifications**: Order status updates
4. **Payment Gateway**: Real payment integration
5. **Social Login**: Google, Facebook auth
6. **Dark Mode**: Theme switching
7. **Localization**: Multi-language support
8. **Offline Mode**: Cache data locally

### Known Limitations
- Images must be in `public/img/` folder on backend
- No real-time cart sync between devices
- Basic error handling (can be improved)
- Payment is simulation only

## 🐛 Troubleshooting

### Issue: "Unable to connect to API"
**Solution:**
- Check backend server is running
- Verify IP address in `baseUrl`
- For emulator, use `10.0.2.2`
- For device, use actual IP and same network

### Issue: "Images not loading"
**Solution:**
- Check image paths in database
- Ensure images exist in `public/img/`
- Check file permissions on server

### Issue: "Session lost after restart"
**Solution:**
- Verify SharedPreferences write success
- Check for async/await errors
- Test with `flutter run --release`

### Issue: "Build failed"
**Solution:**
```bash
flutter clean
flutter pub get
flutter run
```

## 📚 Resources

- [Flutter Documentation](https://docs.flutter.dev/)
- [Dart Language](https://dart.dev/)
- [Material Design 3](https://m3.material.io/)
- [HTTP Package](https://pub.dev/packages/http)
- [SharedPreferences](https://pub.dev/packages/shared_preferences)

## 👨‍💻 Development Team

Aplikasi ini dikembangkan sebagai bagian dari project AIMVC Store - Full Stack E-Commerce Platform.

**Tech Stack:**
- Backend: PHP MVC (AIMVC Framework)
- Frontend Web: PHP Views
- Mobile: Flutter
- Database: MySQL

---

**Version:** 1.0.0  
**Last Updated:** December 2025  
**Flutter Version:** 3.24.5  
**Dart Version:** 3.5.4
