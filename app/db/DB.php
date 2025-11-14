<?php 

class DB{

    private static $host = 'localhost';
    private static $dbname = 'universidades';
    private static $user = 'root';
    private static $pass = '1234';
   

    public static function conectar(){
      
            try {
                $pdo = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4",
                    self::$user,
                    self::$pass
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
       
    }
    
}