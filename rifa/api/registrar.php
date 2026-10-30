<?php
require __DIR__ . '/helpers.php';
requerirMetodo('POST');
requerirSesion();

$nombre   = texto($_POST, 'nombre');
$apellido = texto($_POST, 'apellido');
$numero   = texto($_POST, 'numero_rifa');

if ($nombre === '' || $apellido === '' || $numero === '') {
    responder(400, ['ok' => false, 'mensaje' => 'Debe enviar nombre, apellido y numero_rifa.']);
}
if (!ctype_digit($numero) || (int)$numero <= 0) {
    responder(400, ['ok' => false, 'mensaje' => 'numero_rifa debe ser un entero positivo.']);
}
$numero = (int)$numero;

$participantes = leerJson('participantes.json');

foreach ($participantes as $p) {
    if ((int)$p['numero_rifa'] === $numero) {
        responder(409, ['ok' => false, 'mensaje' => "El número de rifa $numero ya está registrado."]);
    }
}

$ids = array_column($participantes, 'id');
$nuevo = [
    'id'          => $ids ? max($ids) + 1 : 1,
    'nombre'      => $nombre,
    'apellido'    => $apellido,
    'numero_rifa' => $numero,
];
$participantes[] = $nuevo;
guardarJson('participantes.json', $participantes);

responder(201, ['ok' => true, 'mensaje' => 'Participante registrado.', 'participante' => $nuevo]);
