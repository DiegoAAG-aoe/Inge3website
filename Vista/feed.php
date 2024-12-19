<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

// Publicaciones simuladas (esto se conectará con DynamoDB más adelante)
$publicaciones = [
    [
        'usuario' => 'Usuario1',
        'fecha' => '2024-12-18',
        'contenido' => '¡Este es mi primer post en esta red social!',
        'imagen' => 'https://via.placeholder.com/600x300',
        'likes' => 5,
        'comentarios' => [
            ['usuario' => 'Usuario2', 'comentario' => '¡Genial!'],
            ['usuario' => 'Usuario3', 'comentario' => '¡Bienvenido!']
        ]
    ],
    [
        'usuario' => 'Usuario2',
        'fecha' => '2024-12-17',
        'contenido' => 'Me encanta esta comunidad.',
        'imagen' => '',
        'likes' => 8,
        'comentarios' => []
    ],
];

// Amigos simulados
$amigos = [
    'conectados' => ['Amigo1', 'Amigo2', 'Amigo3'],
    'desconectados' => ['Amigo4', 'Amigo5'],
    'sugerencias' => ['Amigo6', 'Amigo7'],
    'solicitudes' => ['Amigo8'],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Barra izquierda -->
            <div class="col-2 bg-light vh-100 p-3">
                <h5>Amigos</h5>
                <!-- Conectados -->
                <div class="mb-3">
                    <h6 class="text-primary">Conectados</h6>
                    <ul class="list-unstyled">
                        <?php foreach ($amigos['conectados'] as $amigo): ?>
                            <li><a href="ver_perfil.php?usuario=<?= urlencode($amigo) ?>"><?= htmlspecialchars($amigo) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Desconectados -->
                <div class="mb-3">
                    <h6 class="text-secondary">Desconectados</h6>
                    <ul class="list-unstyled">
                        <?php foreach ($amigos['desconectados'] as $amigo): ?>
                            <li><a href="ver_perfil.php?usuario=<?= urlencode($amigo) ?>"><?= htmlspecialchars($amigo) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Sugerencias -->
                <div class="mb-3">
                    <h6 class="text-success">Sugerencias</h6>
                    <ul class="list-unstyled">
                        <?php foreach ($amigos['sugerencias'] as $amigo): ?>
                            <li><a href="ver_perfil.php?usuario=<?= urlencode($amigo) ?>"><?= htmlspecialchars($amigo) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Solicitudes -->
                <div class="mb-3">
                    <h6 class="text-warning">Solicitudes</h6>
                    <ul class="list-unstyled">
                        <?php foreach ($amigos['solicitudes'] as $amigo): ?>
                            <li>
                                <a href="ver_perfil.php?usuario=<?= urlencode($amigo) ?>"><?= htmlspecialchars($amigo) ?></a>
                                <div class="mt-1">
                                    <button class="btn btn-sm btn-success">Aceptar</button>
                                    <button class="btn btn-sm btn-danger">Rechazar</button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Feed principal -->
            <div class="col-8">
                <div class="mt-3">
                    <h2>Feed</h2>
                    <?php foreach ($publicaciones as $publicacion): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="ver_perfil.php?usuario=<?= urlencode($publicacion['usuario']) ?>">
                                    <?= htmlspecialchars($publicacion['usuario']) ?>
                                </a>
                                <span class="text-muted float-end"><?= $publicacion['fecha'] ?></span>
                            </div>
                            <div class="card-body">
                                <p><?= htmlspecialchars($publicacion['contenido']) ?></p>
                                <?php if ($publicacion['imagen']): ?>
                                    <img src="<?= $publicacion['imagen'] ?>" class="img-fluid" alt="Imagen">
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <form class="d-inline" method="POST" action="interacciones.php">
                                    <input type="hidden" name="accion" value="like">
                                    <input type="hidden" name="publicacion" value="<?= $publicacion['usuario'] . '-' . $publicacion['fecha'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">👍 <?= $publicacion['likes'] ?> Likes</button>
                                </form>
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#comentarios-<?= md5($publicacion['usuario'] . $publicacion['fecha']) ?>">💬 Comentarios</button>
                            </div>
                            <div id="comentarios-<?= md5($publicacion['usuario'] . $publicacion['fecha']) ?>" class="collapse mt-3 px-3">
                                <?php if (!empty($publicacion['comentarios'])): ?>
                                    <?php foreach ($publicacion['comentarios'] as $comentario): ?>
                                        <div>
                                            <strong><?= htmlspecialchars($comentario['usuario']) ?>:</strong> <?= htmlspecialchars($comentario['comentario']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-muted">No hay comentarios aún.</div>
                                <?php endif; ?>
                                <form method="POST" action="interacciones.php" class="mt-2">
                                    <input type="hidden" name="accion" value="comentar">
                                    <input type="hidden" name="publicacion" value="<?= $publicacion['usuario'] . '-' . $publicacion['fecha'] ?>">
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

            <!-- Barra derecha -->
            <div class="col-2 bg-light vh-100">
                <h5 class="mt-3">Pendiente</h5>
                <!-- Aquí va contenido adicional -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
