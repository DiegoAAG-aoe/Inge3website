<?php
session_start();

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $biografia = $_POST['biografia'];

    // Simulamos un proceso de validación e inserción en la base de datos
    // Asegúrate de agregar la lógica de base de datos aquí (por ejemplo, DynamoDB)
    // En este ejemplo, los datos se simulan como exitosos.

    // Redirige al login después de registrar exitosamente
    $_SESSION['usuario'] = $nombre;  // Guardamos el nombre del usuario en la sesión
    header('Location: ../index.php'); // Regresa al login
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Crear Nueva Cuenta</h2>

                <!-- Formulario para crear una cuenta -->
                <form method="POST" action="crear_usuario.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre de usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="biografia" class="form-label">Biografía</label>
                        <textarea class="form-control" id="biografia" name="biografia" rows="3" placeholder="Escribe algo sobre ti (opcional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión aquí</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
