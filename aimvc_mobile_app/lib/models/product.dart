class Product {
  final int id;
  final String name;
  final String description;
  final double price;
  final int stock;
  final String? image;
  final int categoryId;
  final String? categoryName;
  final DateTime? createdAt;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    required this.stock,
    this.image,
    required this.categoryId,
    this.categoryName,
    this.createdAt,
  });

  // Factory constructor untuk membuat Product dari JSON
  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: int.parse(json['id'].toString()),
      name: json['name'] ?? '',
      description: json['description'] ?? '',
      price: double.parse(json['price'].toString()),
      stock: int.parse(json['stock'].toString()),
      image: json['image'],
      categoryId: int.parse(json['category_id'].toString()),
      categoryName: json['category_name'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
    );
  }

  // Method untuk convert Product ke JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'price': price,
      'stock': stock,
      'image': image,
      'category_id': categoryId,
      'category_name': categoryName,
      'created_at': createdAt?.toIso8601String(),
    };
  }

  // Getter untuk format harga dengan Rupiah
  String get formattedPrice {
    return 'Rp ${price.toStringAsFixed(0).replaceAllMapped(
      RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
      (Match m) => '${m[1]}.',
    )}';
  }

  // Getter untuk cek ketersediaan stok
  bool get isAvailable {
    return stock > 0;
  }

  // Copy with method untuk membuat salinan dengan perubahan
  Product copyWith({
    int? id,
    String? name,
    String? description,
    double? price,
    int? stock,
    String? image,
    int? categoryId,
    String? categoryName,
    DateTime? createdAt,
  }) {
    return Product(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      price: price ?? this.price,
      stock: stock ?? this.stock,
      image: image ?? this.image,
      categoryId: categoryId ?? this.categoryId,
      categoryName: categoryName ?? this.categoryName,
      createdAt: createdAt ?? this.createdAt,
    );
  }
}
