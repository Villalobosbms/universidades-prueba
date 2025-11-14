<?php 
require_once __DIR__ . '/../models/User.php';
class SingInController{

    public function login(){

        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(405);
            echo json_encode(['error' => "Metodo no permitido"]);
            return;
        }
        $body = file_get_contents('php://input');
        $data =  json_decode($body, true);

        $nombre = $data['usuario'] ?? null;
        $password = $data['password'] ?? null;
        
        if (empty($nombre) || empty($password)) {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los datos son obligatorios']);
            return;
        }   
        
        $insertarUsuario = new User();

        $n = $insertarUsuario->consultarUsuario($nombre) ?? null;
        
        if(!$n){
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no existe']);
            return;
        }
        
        $validarPassword = password_verify($password, $n['password_hash']);

        if(!$validarPassword){
            http_response_code(401);
            echo json_encode(['error' => 'Contraseña incorrecta']);
            return;
        }

        $_SESSION['user_id'] = $n['id'];
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Inicio exitoso']);
        return;
    }

    public function logout(){
        header('Content-Type: application/json');

        if($_SERVER['REQUEST_METHOD'] !== 'GET'){
            http_response_code(405);
            echo json_encode(['error' => "Metodo no permitido"]);
            return;
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        http_response_code(200);
        echo json_encode(["succes" => "session eliminada"]);
        return;
    }

}