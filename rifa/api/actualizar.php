<?php
require __DIR__ . '/helpers.php';
requerirMetodo('POST');
requerirSesion();

$id = texto($_POST, 'id');
if ($id === '' || !ctype_digit($id)) {
    responder(400, ['ok' => false, 'mensaje' => 'Debe enviar un id válido.']);
}
$id = (int)$id;

$participantes = leerJson('participantes.json');
$indice = null;
foreach ($participantes as $i => $p) {
    if ((int)$p['id'] === $id) {
        $indice = $i;
        break;
    }
}
if ($indice === null) {
    responder(404, ['ok' => false, 'mensaje' => "No existe un participante con id $id."]);
}

$nombre   = texto($_POST, 'nombre');
$apellido = texto($_POST, 'apellido');
$numero   = texto($_POST, 'numero_rifa');

if ($nombre === '' && $apellido === '' && $numero === '') {
    responder(400, ['ok' => false, 'mensaje' => 'Envíe al menos un campo a modificar: nombre, apellido o numero_rifa.']);
}

if ($numero !== '') {
    if (!ctype_digit($numero) || (int)$numero <= 0) {
        responder(400, ['ok' => false, 'mensaje' => 'numero_rifa debe ser un entero positivo.']);
    }
    foreach ($participantes as $p) {
        if ((int)$p['numero_rifa'] === (int)$numero && (int)$p['id'] !== $id) {
            responder(409, ['ok' => false, 'mensaje' => "El número de rifa $numero ya está en uso."]);
        }
    }
    $participantes[$indice]['numero_rifa'] = (int)$numero;
}
if ($nombre !== '')   { $participantes[$indice]['nombre'] = $nombre; }
if ($apellido !== '') { $participantes[$indice]['apellido'] = $apellido; }

guardarJson('participantes.json', $participantes);
responder(200, ['ok' => true, 'mensaje' => 'Participante actualizado.', 'participante' => $participantes[$indice]]);
