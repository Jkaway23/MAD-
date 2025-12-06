<?php
class App {
    // Global variables
    public $controller = ""; // name of controller (string)
    public $method = "";     // method name to call
    public $parameter = [];   // array of parameters

    public function __construct() {
        // Default controller/method/params
        $this->initDefaultController("Home", "index", []);

        // Parse URL into segments
        $url = $this->parseURL();

        // Check if URL has segments
        if (isset($url[0]) && !empty($url[0])) {
            // Capitalize first letter to match controller naming convention
            $controllerName = ucfirst(strtolower($url[0]));
            
            // Check if controller file exists
            if (file_exists(__DIR__ . '/../controller/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                // Controller not found - show 404
                $this->show404();
                return;
            }
        }

        // Load and instantiate controller
        $this->loadController($url);
    }

    // Initialize default global variables
    private function initDefaultController($controller, $method, $param) {
        $this->controller = $controller;
        $this->method = $method;
        $this->parameter = $param;
    }

    // Parse URL request into segments
    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    // Helper function to check if string starts with prefix
    private function starts_with($str, $prefix) {
        return strpos($str, $prefix) === 0;
    }
    
    // Load controller and handle methods
    private function loadController($url) {
        $controllerFile = __DIR__ . '/../controller/' . $this->controller . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            $controllerClass = $this->controller;
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();

                // Handle Method
                if (isset($url[1])) {
                    $name_method = $url[1]; // move method name
                    // Check underscore prefix
                    if ($this->starts_with($name_method, "_")) {
                        // Private method - show 403 Forbidden  
                        $this->show403();
                        return;
                    } else {
                        // Check if method exists
                        if (method_exists($controllerInstance, $name_method)) {
                            // Change method name
                            $this->method = $name_method;
                            // Delete element index 1 in array
                            unset($url[1]);
                        } else {
                            // Method doesn't exist - show 404
                            $this->show404();
                            return;
                        }
                    }
                }

                // Remaining segments are parameters
                $params = $url ? array_values($url) : [];

                // Run controller and method with some parameters
                call_user_func_array([$controllerInstance, $this->method], $params);
            } else {
                // Class not found - show 404
                $this->show404();
            }
        } else {
            // Controller file not found - show 404
            $this->show404();
        }
    }
    
    // Show 403 Forbidden page
    private function show403() {
        http_response_code(403);
        require_once __DIR__ . '/../controller/Errors.php';
        $errorController = new Errors();
        $errorController->error403();
        exit;
    }
    
    // Show 404 Not Found page
    private function show404() {
        http_response_code(404);
        require_once __DIR__ . '/../controller/Errors.php';
        $errorController = new Errors();
        $errorController->error404();
        exit;
    }
}
?>