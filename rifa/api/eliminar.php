<?php
require __DIR__ . '/helpers.php';
requerirMetodo('GET');
requerirSesion();

$id = texto($_GET, 'id');
if ($id === '' || !ctype_digit($id)) {
    responder(400, ['ok' => false, 'mensaje' => 'Debe enviar un id válido por GET (?id=1).']);
}
$id = (int)$id;

$participantes = leerJson('participantes.json');
$restantes = array_filter($participantes, fn($p) => (int)$p['id'] !== $id);

if (count($restantes) === count($participantes)) {
    responder(404, ['ok' => false, 'mensaje' => "No existe un participante con id $id."]);
}

guardarJson('participantes.json', $restantes);
responder(200, ['ok' => true, 'mensaje' => "Participante $id eliminado."]);
