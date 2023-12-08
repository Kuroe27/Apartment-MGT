<?php
class DbConnection {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'apartment_mgt';

    public $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die('Cannot connect to the database server: ' . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
