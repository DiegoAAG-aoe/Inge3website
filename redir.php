<?php
// index.php
session_start();

// Simulación de usuarios (puedes conectarlo más tarde con DynamoDB)
$usuarios = [
    ['email' => 'admin@admin', 'password' => 'admin', 'nombre' => 'Usuario Ejemplo'],
];

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar credenciales (esto debe ser reemplazado con una consulta a DynamoDB)
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] == $email && $usuario['password'] == $password) {
            $_SESSION['usuario'] = $usuario['nombre'];
            header('Location: Vista/feed.php'); // Redirige al feed
            exit();
        }
    }
    $error = "Correo electrónico o contraseña incorrectos.";
}
?>