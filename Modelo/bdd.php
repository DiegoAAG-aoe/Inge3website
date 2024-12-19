<?php
require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;

$client = new DynamoDbClient([
    'region' => 'us-west-2', // Cambiar a tu región
    'version' => 'latest',
    'credentials' => [
        'key' => 'YOUR_AWS_ACCESS_KEY',
        'secret' => 'YOUR_AWS_SECRET_KEY',
    ],
]);

function createTable($client, $tableName, $keySchema, $attributeDefinitions, $provisionedThroughput) {
    try {
        $result = $client->createTable([
            'TableName' => $tableName,
            'KeySchema' => $keySchema,
            'AttributeDefinitions' => $attributeDefinitions,
            'ProvisionedThroughput' => $provisionedThroughput,
        ]);

        echo "Tabla {$tableName} creada exitosamente.\n";
    } catch (Exception $e) {
        echo "Error creando la tabla {$tableName}: {$e->getMessage()}\n";
    }
}

// Tabla Usuarios
createTable(
    $client,
    'Usuarios',
    [
        ['AttributeName' => 'email', 'KeyType' => 'HASH'],
    ],
    [
        ['AttributeName' => 'email', 'AttributeType' => 'S'],
    ],
    ['ReadCapacityUnits' => 5, 'WriteCapacityUnits' => 5]
);

// Tabla Publicaciones
createTable(
    $client,
    'Publicaciones',
    [
        ['AttributeName' => 'id_publicacion', 'KeyType' => 'HASH'],
    ],
    [
        ['AttributeName' => 'id_publicacion', 'AttributeType' => 'S'],
    ],
    ['ReadCapacityUnits' => 5, 'WriteCapacityUnits' => 5]
);

// Tabla Comentarios
createTable(
    $client,
    'Comentarios',
    [
        ['AttributeName' => 'id_comentario', 'KeyType' => 'HASH'],
    ],
    [
        ['AttributeName' => 'id_comentario', 'AttributeType' => 'S'],
    ],
    ['ReadCapacityUnits' => 5, 'WriteCapacityUnits' => 5]
);

// Tabla Amigos
createTable(
    $client,
    'Amigos',
    [
        ['AttributeName' => 'email_usuario', 'KeyType' => 'HASH'],
        ['AttributeName' => 'email_amigo', 'KeyType' => 'RANGE'],
    ],
    [
        ['AttributeName' => 'email_usuario', 'AttributeType' => 'S'],
        ['AttributeName' => 'email_amigo', 'AttributeType' => 'S'],
    ],
    ['ReadCapacityUnits' => 5, 'WriteCapacityUnits' => 5]
);

// Tabla Likes
createTable(
    $client,
    'Likes',
    [
        ['AttributeName' => 'id_publicacion', 'KeyType' => 'HASH'],
        ['AttributeName' => 'email_usuario', 'KeyType' => 'RANGE'],
    ],
    [
        ['AttributeName' => 'id_publicacion', 'AttributeType' => 'S'],
        ['AttributeName' => 'email_usuario', 'AttributeType' => 'S'],
    ],
    ['ReadCapacityUnits' => 5, 'WriteCapacityUnits' => 5]
);

echo "Creación de tablas completada.\n";
?>
