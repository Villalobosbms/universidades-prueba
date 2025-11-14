<?php

require_once __DIR__ . '/../models/User.php';

class CrearUsuarioController{

    public function register(){
                
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

        $n = empty($insertarUsuario->consultarUsuario($nombre)) ? null : $insertarUsuario->consultarUsuario($nombre);
        
        if(isset($n)){
            http_response_code(300);
            echo json_encode(['error' => 'Usuario ya existe']);
            return;
        }
       
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $exitoso = $insertarUsuario->crearUsuario($nombre, $hash_password);
        
        if(!$exitoso){
            http_response_code(400);
            echo json_encode(['error' => "No crear el usuario"]);
            return; 
        } 
        
        http_response_code(201);
        echo json_encode(['success' => 'Usuario creado correctamente inicie session']);
        return;
    }
}