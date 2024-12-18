<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Simulación de publicaciones
$publicaciones = [
    [
        'usuario' => 'Juan Pérez',
        'fecha' => '2024-06-17',
        'contenido' => '¡Hola a todos! Estoy feliz de unirme a esta nueva plataforma.',
        'imagen' => 'https://via.placeholder.com/600x300', // Imagen de prueba
    ],
    [
        'usuario' => 'María López',
        'fecha' => '2024-06-18',
        'contenido' => 'Una hermosa mañana para trabajar en mis proyectos 😊.',
        'imagen' => 'https://via.placeholder.com/600x300',
    ],
    [
        'usuario' => 'Carlos Sánchez',
        'fecha' => '2024-06-19',
        'contenido' => 'La vida es mejor con amigos y buen café ☕.',
        'imagen' => 'https://via.placeholder.com/600x300',
    ],
];

// Datos de ejemplo para los amigos y solicitudes
$amigos_conectados = ['Carlos Sánchez', 'María López'];
$amigos_desconectados = ['Juan Pérez'];
$sugerencias = ['Luis Fernández', 'Ana García'];
$solicitudes = ['Pedro Gómez'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - Red Social</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajustamos el margen para que el contenedor ocupe todo el ancho */
        .container-fluid {
            padding: 0; /* Elimina el relleno del contenedor */
        }

        /* Aseguramos que las columnas no tengan márgenes o rellenos */
        .col-md-2 {
            padding-left: 0;
            padding-right: 0;
        }

        .col-md-8 {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
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

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Columna izquierda (2 columnas) -->
            <div class="col-md-2">
                <div class="list-group">
                    <!-- Amigos Conectados -->
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Amigos Conectados
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($amigos_conectados as $amigo): ?>
                                <li><a class="dropdown-item" href="#"><?= htmlspecialchars($amigo); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <!-- Amigos Desconectados -->
                    <div class="dropdown mt-2">
                        <button class="btn btn-warning dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Amigos Desconectados
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($amigos_desconectados as $amigo): ?>
                                <li><a class="dropdown-item" href="#"><?= htmlspecialchars($amigo); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Sugerencias -->
                    <div class="dropdown mt-2">
                        <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sugerencias
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($sugerencias as $sugerido): ?>
                                <li><a class="dropdown-item" href="#"><?= htmlspecialchars($sugerido); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Solicitudes Pendientes -->
                    <div class="dropdown mt-2">
                        <button class="btn btn-danger dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Solicitudes Pendientes
                        </button>
                        <ul class="dropdown-menu">
                            <?php foreach ($solicitudes as $solicitud): ?>
                                <li><a class="dropdown-item" href="#"><?= htmlspecialchars($solicitud); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Columna central con publicaciones (8 columnas) -->
            <div class="col-md-8">
                <h2 class="text-center mb-4">Publicaciones Recientes</h2>

                <!-- Botón para Crear Publicación -->
                <div class="text-center mb-4">
                    <a href="crear_publicacion.php" class="btn btn-primary mb-4">Crear una Publicación</a>
                </div>

                <?php foreach ($publicaciones as $post): ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <strong><?= htmlspecialchars($post['usuario']); ?></strong>
                            <span class="text-muted float-end"><?= htmlspecialchars($post['fecha']); ?></span>
                        </div>
                        <?php if (!empty($post['imagen'])): ?>
                            <img src="<?= htmlspecialchars($post['imagen']); ?>" class="card-img-top" alt="Publicación">
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="card-text"><?= htmlspecialchars($post['contenido']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Columna derecha (2 columnas) - De momento vacía -->
            <div class="col-md-2">
                <!-- Aquí puedes agregar contenido más adelante -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
