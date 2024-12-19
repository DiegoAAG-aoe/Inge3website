<?php
// Controlador/UsuarioController.php
class UsuarioController {
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ../index.php');
        exit();
    }
}
