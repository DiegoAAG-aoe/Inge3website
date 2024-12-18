<?php
session_start();

// Redirigir al login si no está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulación de publicación exitosa
    $contenido = $_POST['contenido'];
    $imagen = !empty($_FILES['imagen']['name']) ? 'https://via.placeholder.com/600x300' : ''; // Reemplazar con la lógica de carga de imagen

    // Agregar publicación a la lista (esto debería ser una inserción en la base de datos)
    $publicaciones[] = [
        'usuario' => $_SESSION['usuario'],
        'fecha' => date('Y-m-d'),
        'contenido' => $contenido,
        'imagen' => $imagen,
    ];

    $mensaje = "Publicación creada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Crear una Nueva Publicación</h2>

        <!-- Mensaje de éxito al crear publicación -->
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?= $mensaje ?></div>
        <?php endif; ?>

        <!-- Formulario para crear una publicación -->
        <form method="POST" action="Vista/crear_publicacion.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="contenido">¿Qué estás pensando?</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="imagen">Sube una imagen (opcional)</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            
            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-primary">Publicar</button>
                <a href="feed.php" class="btn btn-secondary">Volver al Feed</a>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
