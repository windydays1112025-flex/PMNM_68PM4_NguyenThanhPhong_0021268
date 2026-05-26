<?php 
    class ConnectDB{
        private $servername = "localhost";
        private $username = "root";
        private $password = "123456";
        private $dbname = "qlsv";
        public $conn;
        public static function Connect(){
            $self = new self();
            $self->conn = null;
           try{
            $self->conn = new PDO('mysql:host=' . $self->servername . ';dbname=' . $self->dbname, $self->username, $self->password);
            $self->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }catch(PDOException $e){
            echo "Connection Error: " . $e->getMessage();
           }
           return $self->conn;
        }
    }
?>