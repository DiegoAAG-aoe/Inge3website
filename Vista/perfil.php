<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Simulación de datos del usuario (esto se debe reemplazar con los datos reales de la base de datos)
$usuario = [
    'nombre' => $_SESSION['usuario'],
    'email' => 'usuario@ejemplo.com', // Esto debería venir de la base de datos
    'foto_perfil' => 'https://via.placeholder.com/150', // Foto de perfil
    'biografia' => 'Soy un apasionado de la tecnología y las redes sociales. Me encanta compartir mis experiencias.',
];

// Simulación de publicaciones (esto debería venir de la base de datos)
$publicaciones = [
    ['contenido' => '¡Estoy disfrutando de este hermoso día!', 'fecha' => '2024-12-17', 'imagen' => 'https://via.placeholder.com/600x300'],
    ['contenido' => 'Acabo de terminar un proyecto importante. ¡Me siento increíble!', 'fecha' => '2024-12-15', 'imagen' => 'https://via.placeholder.com/600x300'],
    ['contenido' => '¡Felices fiestas a todos!', 'fecha' => '2024-12-10', 'imagen' => ''],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajuste del container para que ocupe el ancho total */
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }

        /* Para hacer que la columna de la izquierda tenga el tamaño adecuado */
        .perfil-container {
            max-width: 300px; /* Limitar el tamaño de la columna izquierda */
            margin-right: 20px;
        }

        /* Para mostrar la foto de perfil redonda */
        .perfil-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover; /* Ajustar la imagen para cubrir el contenedor sin deformarse */
        }

        /* Estilo para la biografía */
        .biografia {
            font-size: 1.1em;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="feed.php">FreeLogs</a>
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

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <!-- Columna izquierda con foto y datos -->
            <div class="col-md-3 perfil-container text-center">
                <img src="<?= $usuario['foto_perfil']; ?>" alt="Foto de Perfil" class="img-fluid mb-3">
                <h4><?= $usuario['nombre']; ?></h4>
                <p class="text-muted"><?= $usuario['email']; ?></p>
                
                <!-- Biografía del usuario -->
                <div class="biografia mt-3">
                    <p><strong>Biografía:</strong></p>
                    <p><?= $usuario['biografia']; ?></p>
                </div>
                
                <!-- Botón para editar perfil -->
                <a href="editar_perfil.php" class="btn btn-primary mt-3">Editar Perfil</a>
            </div>

            <!-- Columna derecha con publicaciones -->
            <div class="col-md-9">
                <h3 class="mb-4">Publicaciones</h3>
                
                <!-- Feed de publicaciones -->
                <?php foreach ($publicaciones as $publicacion): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-text"><?= $publicacion['contenido']; ?></p>
                            <?php if (!empty($publicacion['imagen'])): ?>
                                <img src="<?= $publicacion['imagen']; ?>" class="img-fluid mb-2" alt="Imagen de la publicación">
                            <?php endif; ?>
                            <p class="text-muted"><?= $publicacion['fecha']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
