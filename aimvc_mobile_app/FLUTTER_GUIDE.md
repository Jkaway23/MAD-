# AIMVC Mobile App - Flutter Setup Guide

## 📱 Tentang Aplikasi

AIMVC Mobile App adalah aplikasi mobile e-commerce yang terhubung dengan backend AIMVC Store (PHP MVC). Aplikasi ini memungkinkan pengguna untuk:

- Browse produk
- Mencari produk
- Melihat detail produk
- Menambah produk ke keranjang
- Checkout pesanan
- Melihat riwayat order

## 🛠️ Teknologi

- **Flutter 3.24.5** - Framework mobile
- **Dart** - Programming language
- **HTTP Package** - API communication
- **SharedPreferences** - Local storage
- **Provider** - State management

## 📦 Struktur Project

```
lib/
├── main.dart                 # Entry point & routing
├── models/                   # Data models
│   ├── product.dart
│   ├── user.dart
│   └── category.dart
├── screens/                  # UI Screens
│   ├── login_screen.dart
│   ├── register_screen.dart
│   ├── product_list_screen.dart
│   ├── product_detail_screen.dart
│   └── cart_screen.dart
├── services/                 # API services
│   └── api_service.dart
├── widgets/                  # Reusable widgets
└── utils/                    # Helper functions
```

## 🚀 Setup & Installation

### 1. Prerequisites

```bash
# Cek Flutter installation
flutter --version

# Cek Flutter doctor
flutter doctor
```

### 2. Install Dependencies

```bash
cd aimvc_mobile_app
flutter pub get
```

### 3. Konfigurasi API

Edit `lib/services/api_service.dart`:

```dart
// Untuk Android Emulator
static const String baseUrl = 'http://10.0.2.2/lecture27/aimvc/public';

// Untuk Physical Device (ganti dengan IP komputer Anda)
// static const String baseUrl = 'http://192.168.1.100/lecture27/aimvc/public';
```

### 4. Jalankan Aplikasi

**Linux Desktop:**
```bash
flutter run -d linux
```

**Android Emulator:**
```bash
flutter run -d emulator-5554
```

**Physical Device:**
```bash
flutter run
```

## 📱 Screens Yang Tersedia

### 1. Login Screen (`/login`)
- Input email & password
- Validasi form
- Auto-save user session

### 2. Register Screen (`/register`)
- Input nama, email, password
- Konfirmasi password
- Validasi email format

### 3. Product List Screen (`/products`)
- Grid view products
- Search functionality
- Add to cart button
- Stock indicator

### 4. Product Detail Screen (`/product-detail`)
- Full product image
- Product description
- Price display
- Quantity selector

### 5. Cart Screen (`/cart`)
- List cart items
- Remove item
- Total calculation
- Checkout button

## 🔌 API Endpoints

Backend API documentation: `../API_DOCUMENTATION.md`

## 🧪 Testing

### Test dengan Flutter:
```bash
flutter run -d linux
```

### Test dengan cURL:
```bash
curl http://localhost/lecture27/aimvc/public/api/products
```

## 🐛 Troubleshooting

### API Connection Failed
- Pastikan Apache running
- Cek base URL di `api_service.dart`
- Untuk emulator gunakan `10.0.2.2`
- Untuk physical device, gunakan IP komputer

### Image Not Loading
- Pastikan path image benar
- Cek file image ada di server

## 📝 Next Steps

Screens yang perlu ditambahkan:
1. Checkout Screen
2. Order Success Screen
3. Order History Screen
4. Order Detail Screen
5. Profile Screen

## 📱 Build APK

```bash
# Debug APK
flutter build apk

# Release APK
flutter build apk --release
```

---
**Created:** December 5, 2025
**Flutter Version:** 3.24.5
