<?php 

require_once __DIR__ . '/../db/DB.php';

class User{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::conectar();
    }

    public function crearUsuario($usuario, $password){
        try{
            $sql = ("INSERT INTO usuarios (username, password_hash) VALUES (:username, :password)");
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':username' => $usuario,
                ':password' => $password
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
       
    }

    public function consultarUsuario($usuario){
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
            $stmt->execute([
                ':username' => $usuario
            ]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           
           
            return $result ?: null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}