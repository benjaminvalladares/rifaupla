<?php
require __DIR__ . '/helpers.php';
requerirMetodo('POST');

$usuario = texto($_POST, 'usuario');
$clave   = texto($_POST, 'clave');

if ($usuario === '' || $clave === '') {
    responder(400, ['ok' => false, 'mensaje' => 'Debe enviar usuario y clave.']);
}

if ($usuario === API_USUARIO && $clave === API_CLAVE) {
    session_regenerate_id(true);
    $_SESSION['api_autenticado'] = true;
    $_SESSION['api_usuario'] = $usuario;
    responder(200, ['ok' => true, 'mensaje' => 'Sesión iniciada correctamente.']);
}

responder(401, ['ok' => false, 'mensaje' => 'Credenciales incorrectas.']);
