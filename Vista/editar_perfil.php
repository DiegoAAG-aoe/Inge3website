<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Simulación de datos de perfil (esto se debería conectar a DynamoDB más adelante)
$usuario = [
    'nombre' => $_SESSION['usuario'],
    'email' => 'admin@dominio.com',
    'biografia' => 'Desarrollador web apasionado por la tecnología y la innovación.',
    'foto_perfil' => 'https://via.placeholder.com/150', // Foto de perfil de prueba
];

// Lógica de actualización (simulada)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario['nombre'] = $_POST['nombre'];
    $usuario['email'] = $_POST['email'];
    $usuario['biografia'] = $_POST['biografia'];
    
    // Aquí, más tarde, se actualizarían estos datos en la base de datos

    // Mensaje de éxito tras la actualización
    $exito = "Perfil actualizado correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - FreeLogs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Vista/feed.php">FreeLogs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hola, <?= htmlspecialchars($_SESSION['usuario']); ?> 👋
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="perfil.php">Ir a mi perfil</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido del perfil -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Perfil de <?= htmlspecialchars($usuario['nombre']); ?></h2>

        <?php if (isset($exito)): ?>
            <div class="alert alert-success"><?= $exito ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?= htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de perfil" class="img-fluid rounded-circle">
            </div>
            <div class="col-md-8">
                <h4>Información del Usuario</h4>
                <form method="POST" action="perfil.php">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="biografia" class="form-label">Biografía</label>
                        <textarea name="biografia" class="form-control" id="biografia" rows="3"><?= htmlspecialchars($usuario['biografia']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="feed.php" class="btn btn-secondary">Volver al Feed</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
