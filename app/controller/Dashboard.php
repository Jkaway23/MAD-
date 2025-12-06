<?php
class Dashboard extends Controller {
    
    public function __construct() {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . 'auth/login');
            exit;
        }
    }
    
    public function index() {
        $data['title'] = 'Dashboard Page';
        $data['user'] = $_SESSION['user_name'] ?? 'User';
        $data['email'] = $_SESSION['user_email'] ?? '';
        $data['login_time'] = date('Y-m-d H:i:s', $_SESSION['login_time'] ?? time());
        $this->view('dashboard/index', $data);
    }
    
    public function stats() {
        $data['title'] = 'Statistics';
        echo "This is dashboard stats page";
    }
    
    public function settings() {
        $data['title'] = 'Settings';
        echo "This is dashboard settings page";
    }
    
    public function profile() {
        $data['title'] = 'My Profile';
        $data['user'] = $_SESSION['user_name'] ?? 'User';
        $data['email'] = $_SESSION['user_email'] ?? '';
        $data['user_id'] = $_SESSION['user_id'] ?? 0;
        $data['login_time'] = date('Y-m-d H:i:s', $_SESSION['login_time'] ?? time());
        $this->view('dashboard/profile', $data);
    }
}
?>