<?php 

require_once __DIR__ . '/../db/BD.php';

class Descargas_pdf{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DB::conectar();
    }

    public function crearRegistro($use_id, $pais, $ruta, $fecha){
        try{
            $sql = "INSERT INTO descargas_pdf (user_id, pais, ruta_archivo, fecha) VALUES  (:user_id, :pais, :ruta_archivo, :fecha)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ":user_id" => $use_id,
                ":pais" => $pais,
                ":ruta_archivo" => $ruta,
                ":fecha" => $fecha,
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}