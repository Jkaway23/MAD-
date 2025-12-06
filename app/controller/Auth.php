<?php
class Auth extends Controller {
    
    public function index() {
        $this->login();
    }
    
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . 'dashboard');
            exit;
        }
        
        $data['title'] = 'Login Page';
        $data['error'] = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $data['error'] = 'Email and password are required!';
            } else {
                require_once __DIR__ . '/../model/Login_model.php';
                $loginModel = new Login_model();
                $user = $loginModel->login($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['login_time'] = time();
                    
                    header('Location: ' . BASEURL . 'dashboard');
                    exit;
                } else {
                    $data['error'] = 'Invalid email or password!';
                }
            }
        }
        
        $this->view('auth/login', $data);
    }
    
    public function register() {
        $data['title'] = 'Register Page';
        $data['error'] = '';
        $data['success'] = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if (empty($name) || empty($email) || empty($password)) {
                $data['error'] = 'All fields are required!';
            } elseif ($password !== $confirm_password) {
                $data['error'] = 'Passwords do not match!';
            } elseif (strlen($password) < 6) {
                $data['error'] = 'Password must be at least 6 characters!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Invalid email format!';
            } else {
                require_once __DIR__ . '/../model/Login_model.php';
                $loginModel = new Login_model();
                
                if ($loginModel->register($email, $password, $name)) {
                    $data['success'] = 'Registration successful! Please login.';
                    $_POST = [];
                } else {
                    $data['error'] = 'Email already exists or registration failed!';
                }
            }
        }
        
        $this->view('auth/register', $data);
    }
    
    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASEURL . 'auth/login');
        exit;
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }
    }
}
?>