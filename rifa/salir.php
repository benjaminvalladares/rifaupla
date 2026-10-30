<?php
session_start();

// Vaciar variables de sesión
$_SESSION = [];

// Eliminar la cookie de sesión
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

// Destruir la sesión en el servidor
session_destroy();

header('Location: index.php');
exit;
