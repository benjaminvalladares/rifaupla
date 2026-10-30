<?php
require __DIR__ . '/helpers.php';
requerirMetodo('GET');
requerirSesion();

$premios = leerJson('premios.json');
responder(200, [
    'ok' => true,
    'total' => count($premios),
    'premios' => $premios,
]);
