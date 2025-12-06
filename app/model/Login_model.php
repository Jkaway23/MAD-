<?php
class Login_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Check if user exists with email and password
    public function login($email, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM tbl_login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Register new user
    public function register($email, $password, $name) {
        $conn = $this->db->getConnection();
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM tbl_login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return false; // Email already exists
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO tbl_login (email, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $name);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all users
    public function getAllUsers() {
        $conn = $this->db->getConnection();
        $result = $conn->query("SELECT id, email, name, created_at FROM tbl_login ORDER BY created_at DESC");
        $users = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // Get user by ID
    public function getUserById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id, email, name, created_at FROM tbl_login WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    // Get user by email
    public function getUserByEmail($email) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id, email, name, created_at FROM tbl_login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    // Alias for login method (for API compatibility)
    public function checkLogin($email, $password) {
        return $this->login($email, $password);
    }
}
?>
