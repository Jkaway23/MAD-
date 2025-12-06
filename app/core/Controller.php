<?php
/**
 * Base Controller Class
 * All controllers extend this class
 */
class Controller {
    /**
     * Load a view file and pass data to it
     * @param string $view - View file path (without .php)
     * @param array $data - Data to pass to the view
     */
    public function view($view, $data = []) {
        // Extract data array to variables
        if (is_array($data)) {
            extract($data);
        }
        
        // Check if view file exists
        $viewFile = __DIR__ . '/../view/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once __DIR__ . '/../view/template/header.php';
            require_once $viewFile;
            require_once __DIR__ . '/../view/template/footer.php';
        } else {
            die("View file not found: {$view}.php");
        }
    }

    /**
     * Load a model and return its instance
     * @param string $model - Model class name
     * @return object|null - Model instance or null
     */
    public function model($model) {
        $modelFile = __DIR__ . '/../model/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            if (class_exists($model)) {
                return new $model();
            }
        }
        return null;
    }
}
?>