<?php
/**
 * Database Connection Class
 * Handles MySQLi connection and provides connection instance
 */
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $port;
    private $conn;

    public function __construct() {
        // Load configuration from Config.php if not already loaded
        if (!defined('DB_HOST')) {
            require_once __DIR__ . '/../../config/Config.php';
        }
        
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;
        $this->port = defined('DB_PORT') ? DB_PORT : 3306;
        
        // Create connection
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
        
        // Check connection
        if ($this->conn->connect_error) {
            error_log("Database connection failed: " . $this->conn->connect_error);
            die("Database connection failed. Please check your configuration.");
        }
        
        // Set charset to utf8mb4
        $this->conn->set_charset("utf8mb4");
    }

    /**
     * Get the MySQLi connection instance
     * @return mysqli
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Close the database connection
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    /**
     * Destructor - close connection when object is destroyed
     */
    public function __destruct() {
        $this->close();
    }
}
?>