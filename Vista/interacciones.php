<?php
session_start();

// Simulación de publicaciones (esto se conectará con DynamoDB en el futuro)
$publicaciones = [
    [
        'id' => 'post1',
        'usuario' => 'admin@admin',
        'contenido' => 'Este es mi primer post!',
        'imagen' => 'https://via.placeholder.com/600x300',
        'likes' => 5,
        'comentarios' => [
            ['usuario' => 'usuario1', 'contenido' => '¡Genial publicación!'],
            ['usuario' => 'usuario2', 'contenido' => 'Me encanta este contenido.'],
        ],
    ],
];

// Simular interacciones (puedes reemplazar con consultas a DynamoDB)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $idPublicacion = $_POST['id_publicacion'];

    // Simulación de like
    if ($accion === 'like') {
        foreach ($publicaciones as &$publicacion) {
            if ($publicacion['id'] === $idPublicacion) {
                $publicacion['likes']++;
                break;
            }
        }
    }

    // Simulación de comentario
    if ($accion === 'comentar') {
        $nuevoComentario = [
            'usuario' => $_SESSION['usuario'],
            'contenido' => $_POST['contenido_comentario'],
        ];
        foreach ($publicaciones as &$publicacion) {
            if ($publicacion['id'] === $idPublicacion) {
                $publicacion['comentarios'][] = $nuevoComentario;
                break;
            }
        }
    }
}
?>

<!-- HTML -->
<div class="container">
    <?php foreach ($publicaciones as $publicacion): ?>
        <div class="card my-3">
            <div class="card-header">
                <a href="ver_perfil.php?usuario=<?= $publicacion['usuario'] ?>"><?= $publicacion['usuario'] ?></a>
            </div>
            <div class="card-body">
                <p><?= $publicacion['contenido'] ?></p>
                <?php if ($publicacion['imagen']): ?>
                    <img src="<?= $publicacion['imagen'] ?>" class="img-fluid" alt="Imagen del post">
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <!-- Likes -->
                <form method="POST" class="d-inline">
                    <input type="hidden" name="accion" value="like">
                    <input type="hidden" name="id_publicacion" value="<?= $publicacion['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-primary">👍 Me gusta (<?= $publicacion['likes'] ?>)</button>
                </form>
                
                <!-- Comentarios -->
                <button class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#comentarios-<?= $publicacion['id'] ?>">
                    Comentarios (<?= count($publicacion['comentarios']) ?>)
                </button>

                <!-- Comentarios colapsables -->
                <div id="comentarios-<?= $publicacion['id'] ?>" class="collapse mt-2">
                    <ul class="list-group">
                        <?php foreach ($publicacion['comentarios'] as $comentario): ?>
                            <li class="list-group-item">
                                <strong><?= $comentario['usuario'] ?>:</strong> <?= $comentario['contenido'] ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <form method="POST" class="mt-2">
                        <input type="hidden" name="accion" value="comentar">
                        <input type="hidden" name="id_publicacion" value="<?= $publicacion['id'] ?>">
                        <div class="input-group">
                            <input type="text" name="contenido_comentario" class="form-control" placeholder="Escribe un comentario...">
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
