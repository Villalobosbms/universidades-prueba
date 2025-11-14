<?php

require_once __DIR__ . '/../helpers/auth.php';

class HomeController{
   
    public function index(){
        include __DIR__ . '/../views/index.html';
    }

    public function login(){
        include __DIR__ . '/../views/login.html';
    }

    public function register(){
        include __DIR__ . '/../views/register.html';
    }

    public function universidades(){
        requireLogin();

        include __DIR__ . '/../views/univesidadesPaises.html';
    }
}