<?php 

require_once __DIR__ . '/../models/Descargas_pdf.php';

class ApiController{

    public function save_pdf(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            exit;
        }

        if (!isset($_FILES['archivo_pdf'])) {
            echo json_encode(["error" => "No se recibió el PDF"]);
            exit;
        }

        $archivo = $_FILES['archivo_pdf'];
        $pais = $_POST['pais'];

        $ruta = "../app/uploads/";

        if (!is_dir($ruta)) {
            mkdir($ruta, 0777, true);
        }

        $id = $_SESSION['user_id'] ;
        $fecha = date("Ymd_His");
        $fechabd = date('Y-m-d H:i:s');

        $nombreArchivo =  $id ."_". $fecha;
        
        $destino = $ruta . basename($nombreArchivo) . ".pdf";

        $modelGuardar = new Descargas_pdf();
        $exitoso = $modelGuardar->crearRegistro($id, $pais, $destino, $fechabd); 

        if(!$exitoso){
            http_response_code(400);
            echo json_encode(['error' => "Error"]);
            return; 
        } 

        if (move_uploaded_file($archivo["tmp_name"], $destino)) {
            echo json_encode(["success" => true, "mensaje" => "PDF guardado"]);
        } else {
            echo json_encode(["error" => "Error al guardar el PDF"]);
        }
    }
    
}