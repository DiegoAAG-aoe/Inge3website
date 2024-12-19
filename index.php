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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Ingresa tu email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>

                <!-- Botón para crear nuevo usuario -->
                <div class="text-center mt-3">
                    <a href="crear_usuario.php" class="btn btn-link">¿No tienes cuenta? Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
