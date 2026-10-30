<?php
require __DIR__ . '/helpers.php';
requerirMetodo('GET');
requerirSesion();

$participantes = leerJson('participantes.json');
responder(200, [
    'ok' => true,
    'total' => count($participantes),
    'participantes' => $participantes,
]);
