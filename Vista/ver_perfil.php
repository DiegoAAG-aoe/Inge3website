<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Simulación de datos del perfil (esto debería venir de DynamoDB)
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : 'Desconocido';
$perfil = [
    'nombre' => $usuario,
    'biografia' => 'Esta es la biografía de ' . htmlspecialchars($usuario),
    'foto' => 'https://via.placeholder.com/150',
    'amigos' => ['Amigo1', 'Amigo2', 'Amigo3'], // Simula amigos actuales
];

// Determinar el estado del usuario respecto al perfil
$esAmigo = in_array($_SESSION['usuario'], $perfil['amigos']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?= htmlspecialchars($usuario) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sección izquierda con foto y biografía -->
            <div class="col-3">
                <div class="card">
                    <img src="<?= $perfil['foto'] ?>" class="card-img-top" alt="Foto de perfil">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($perfil['nombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($perfil['biografia']) ?></p>
                        <?php if ($esAmigo): ?>
                            <form method="POST" action="../acciones_amigos.php">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">
                                <button type="submit" class="btn btn-danger w-100">Eliminar amigo</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="../acciones_amigos.php">
                                <input type="hidden" name="accion" value="enviar_solicitud">
                                <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">
                                <button type="submit" class="btn btn-primary w-100">Enviar solicitud</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Feed del usuario -->
            <div class="col-9">
                <h3>Publicaciones de <?= htmlspecialchars($perfil['nombre']) ?></h3>
                <?php
                // Simulación de publicaciones del perfil
                $publicaciones = [
                    [
                        'fecha' => '2024-12-18',
                        'contenido' => 'Esta es una publicación del perfil de ' . htmlspecialchars($perfil['nombre']),
                        'imagen' => 'https://via.placeholder.com/600x300',
                        'likes' => 3,
                        'comentarios' => [
                            ['usuario' => 'Amigo1', 'comentario' => '¡Increíble publicación!']
                        ]
                    ],
                    [
                        'fecha' => '2024-12-17',
                        'contenido' => 'Otra publicación interesante de ' . htmlspecialchars($perfil['nombre']),
                        'imagen' => '',
                        'likes' => 2,
                        'comentarios' => []
                    ],
                ];
                ?>

                <?php foreach ($publicaciones as $publicacion): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <?= htmlspecialchars($perfil['nombre']) ?>
                            <span class="text-muted float-end"><?= $publicacion['fecha'] ?></span>
                        </div>
                        <div class="card-body">
                            <p><?= htmlspecialchars($publicacion['contenido']) ?></p>
                            <?php if ($publicacion['imagen']): ?>
                                <img src="<?= $publicacion['imagen'] ?>" class="img-fluid" alt="Imagen">
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <form class="d-inline" method="POST" action="../interacciones.php">
                                <input type="hidden" name="accion" value="like">
                                <input type="hidden" name="publicacion" value="<?= $perfil['nombre'] . '-' . $publicacion['fecha'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-primary">👍 <?= $publicacion['likes'] ?> Likes</button>
                            </form>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#comentarios-<?= md5($perfil['nombre'] . $publicacion['fecha']) ?>">💬 Comentarios</button>
                        </div>
                        <div id="comentarios-<?= md5($perfil['nombre'] . $publicacion['fecha']) ?>" class="collapse mt-3 px-3">
                            <?php if (!empty($publicacion['comentarios'])): ?>
                                <?php foreach ($publicacion['comentarios'] as $comentario): ?>
                                    <div>
                                        <strong><?= htmlspecialchars($comentario['usuario']) ?>:</strong> <?= htmlspecialchars($comentario['comentario']) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-muted">No hay comentarios aún.</div>
                            <?php endif; ?>
                            <form method="POST" action="../interacciones.php" class="mt-2">
                                <input type="hidden" name="accion" value="comentar">
                                <input type="hidden" name="publicacion" value="<?= $perfil['nombre'] . '-' . $publicacion['fecha'] ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="comentario" placeholder="Escribe un comentario...">
                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
