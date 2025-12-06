# AIMVC Store - API Documentation

Base URL: `http://localhost/lecture27/aimvc/public/api`

## Authentication Endpoints

### 1. Login
**POST** `/login`

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user_id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "token": "abc123..."
  }
}
```

### 2. Register
**POST** `/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

## Product Endpoints

### 3. Get All Products
**GET** `/products`

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": "1",
      "name": "Product Name",
      "description": "Product description",
      "price": "100000",
      "stock": "50",
      "image": "product1.jpg",
      "category_id": "1",
      "category_name": "Category Name"
    }
  ]
}
```

### 4. Get Product by ID
**GET** `/product/{id}`

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": "1",
    "name": "Product Name",
    "description": "Product description",
    "price": "100000",
    "stock": "50",
    "image": "product1.jpg",
    "category_id": "1",
    "category_name": "Category Name"
  }
}
```

## Category Endpoints

### 5. Get All Categories
**GET** `/categories`

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": "1",
      "name": "Electronics",
      "description": "Electronic products"
    }
  ]
}
```

## Cart Endpoints

### 6. Add to Cart
**POST** `/cart/add`

**Request Body:**
```json
{
  "user_id": 1,
  "product_id": 1,
  "quantity": 2
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Product added to cart"
}
```

### 7. Get Cart Items
**GET** `/cart/{user_id}`

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "items": [
      {
        "id": "1",
        "product_id": "1",
        "product_name": "Product Name",
        "price": "100000",
        "quantity": "2",
        "image": "product1.jpg"
      }
    ],
    "total": 200000
  }
}
```

### 8. Remove from Cart
**POST** `/cart/remove`

**Request Body:**
```json
{
  "cart_id": 1,
  "user_id": 1
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "message": "Item removed from cart"
}
```

## Order Endpoints

### 9. Checkout
**POST** `/checkout`

**Request Body:**
```json
{
  "user_id": 1,
  "customer_name": "John Doe",
  "customer_phone": "08123456789",
  "customer_address": "Jl. Example No. 123",
  "payment_method": "Transfer Bank"
}
```

**Response (201 Created):**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 1,
    "total_amount": 200000
  }
}
```

### 10. Get User Orders
**GET** `/orders/{user_id}`

**Response (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": "1",
      "user_id": "1",
      "customer_name": "John Doe",
      "customer_phone": "08123456789",
      "customer_address": "Jl. Example No. 123",
      "payment_method": "Transfer Bank",
      "total_amount": "200000",
      "status": "pending",
      "order_date": "2025-12-05 13:00:00"
    }
  ]
}
```

### 11. Get Order Detail
**GET** `/order/{order_id}/{user_id}`

**Response (200 OK):**
```json
{
  "success": true,
  "data": {
    "order": {
      "id": "1",
      "customer_name": "John Doe",
      "total_amount": "200000",
      "status": "pending"
    },
    "items": [
      {
        "product_name": "Product Name",
        "quantity": "2",
        "price": "100000",
        "subtotal": "200000"
      }
    ]
  }
}
```

## Error Responses

**400 Bad Request:**
```json
{
  "success": false,
  "message": "Error message"
}
```

**401 Unauthorized:**
```json
{
  "success": false,
  "message": "Invalid email or password"
}
```

**404 Not Found:**
```json
{
  "success": false,
  "message": "Resource not found"
}
```

**500 Internal Server Error:**
```json
{
  "success": false,
  "message": "Internal server error"
}
```

## Testing with cURL

### Test Login:
```bash
curl -X POST http://localhost/lecture27/aimvc/public/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'
```

### Test Get Products:
```bash
curl http://localhost/lecture27/aimvc/public/api/products
```

### Test Add to Cart:
```bash
curl -X POST http://localhost/lecture27/aimvc/public/api/cart/add \
  -H "Content-Type: application/json" \
  -d '{"user_id":1,"product_id":1,"quantity":2}'
```

## Notes for Flutter Integration

1. **Base URL for Android Emulator:** `http://10.0.2.2/lecture27/aimvc/public/api`
2. **Base URL for Physical Device:** Use your computer's IP address
3. **Headers:** Set `Content-Type: application/json` for POST requests
4. **CORS:** Already enabled with `Access-Control-Allow-Origin: *`
