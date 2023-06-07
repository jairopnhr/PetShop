<?php 
define('HOST','127.0.0.1:3307');
define('PASSWORD','');
define('USER','root');
define('DB','petshop');
class DatabaseConnection {
   private $host;
   private $dbname;
   private $username;
   private $password;
   private $conn;
   public function __construct() {
       $this->host = HOST;
       $this->dbname = DB;
       $this->username = USER;
       $this->password = PASSWORD;
   }
   public function connect() {
       try {
           $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
           $this->conn = new PDO($dsn, $this->username, $this->password);
           $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           return $this->conn;
       } catch (PDOException $e) {
           echo "Falha na conexão com o banco de dados: " . $e->getMessage();
       }
   }
   public function close() {
       $this->conn = null;
   }
}

?>