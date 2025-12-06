import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  // Base URL untuk backend PHP
  // Gunakan 10.0.2.2 untuk Android Emulator
  // Gunakan localhost atau IP komputer untuk device fisik
  static const String baseUrl = 'http://10.0.2.2/lecture27/aimvc/public';
  
  // GET request
  Future<dynamic> get(String endpoint) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl$endpoint'),
        headers: {'Content-Type': 'application/json'},
      );
      
      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to load data: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
  
  // POST request
  Future<dynamic> post(String endpoint, Map<String, dynamic> data) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl$endpoint'),
        headers: {'Content-Type': 'application/json'},
        body: json.encode(data),
      );
      
      if (response.statusCode == 200 || response.statusCode == 201) {
        return json.decode(response.body);
      } else {
        throw Exception('Failed to post data: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
  
  // GET Products
  Future<List<dynamic>> getProducts() async {
    return await get('/api/products');
  }
  
  // GET Product by ID
  Future<dynamic> getProduct(int id) async {
    return await get('/api/product/$id');
  }
  
  // GET Categories
  Future<List<dynamic>> getCategories() async {
    return await get('/api/categories');
  }
  
  // POST Login
  Future<dynamic> login(String email, String password) async {
    return await post('/api/login', {
      'email': email,
      'password': password,
    });
  }
  
  // POST Register
  Future<dynamic> register(Map<String, dynamic> userData) async {
    return await post('/api/register', userData);
  }
  
  // POST Add to Cart
  Future<dynamic> addToCart(int productId, int quantity) async {
    return await post('/api/cart/add', {
      'product_id': productId,
      'quantity': quantity,
    });
  }
  
  // POST Checkout
  Future<dynamic> checkout(Map<String, dynamic> orderData) async {
    return await post('/api/checkout', orderData);
  }
  
  // GET Orders
  Future<dynamic> getOrders() async {
    final prefs = await SharedPreferences.getInstance();
    final userId = prefs.getInt('user_id');
    return await get('/api/orders/$userId');
  }
  
  // GET Order Detail
  Future<dynamic> getOrderDetail(int orderId) async {
    final prefs = await SharedPreferences.getInstance();
    final userId = prefs.getInt('user_id');
    return await get('/api/order/$orderId/$userId');
  }
}
