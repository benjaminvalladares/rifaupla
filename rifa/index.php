<?php
require __DIR__ . '/inc.php';

// Si ya hay sesión, ir directo al panel
if (!empty($_SESSION['autenticado'])) {
    header('Location: panel.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = $_POST['clave'] ?? '';
    $captcha = trim($_POST['captcha'] ?? '');
    $esperado = $_SESSION['captcha'] ?? null;

    $usuarioOk  = $usuario === WEB_USUARIO;
    $claveOk    = $clave === WEB_CLAVE;
    $captchaOk  = $esperado !== null && $captcha !== '' && ctype_digit($captcha) && (int)$captcha === (int)$esperado;

    // Después de cada intento se genera un nuevo CAPTCHA
    unset($_SESSION['captcha']);

    if ($usuarioOk && $claveOk && $captchaOk) {
        session_regenerate_id(true);
        $_SESSION['autenticado'] = true;
        $_SESSION['usuario'] = $usuario;
        header('Location: panel.php');
        exit;
    }
    $error = 'Acceso rechazado: usuario, contraseña o CAPTCHA incorrectos.';
}

// Generar CAPTCHA nuevo (aleatorio) y guardar el resultado en sesión
$a = random_int(1, 9);
$b = random_int(1, 9);
$_SESSION['captcha'] = $a + $b;

cabecera('Iniciar sesión', false);
?>
<h1>Rifa UPLA - Iniciar sesión</h1>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<form method="POST" action="index.php" autocomplete="off">
    <label for="usuario">Usuario</label>
    <input type="text" id="usuario" name="usuario" required>
    <label for="clave">Contraseña</label>
    <input type="password" id="clave" name="clave" required>
    <label for="captcha">CAPTCHA: resuelva la operación</label>
    <div class="cap"><?= $a ?> + <?= $b ?> = ?</div>
    <input type="text" id="captcha" name="captcha" inputmode="numeric" required style="margin-top:8px">
    <button type="submit">Ingresar</button>
</form>
<?php pie(); ?>
