<?php
require __DIR__ . '/inc.php';
requerirLogin();

if (!isset($_SESSION['numeros']) || !is_array($_SESSION['numeros'])) {
    $_SESSION['numeros'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $numero = trim($_POST['numero'] ?? '');

    if ($accion === 'agregar') {
        if ($numero === '' || !ctype_digit($numero) || (int)$numero <= 0) {
            $_SESSION['flash'] = ['error', 'Ingrese un número entero positivo (no se permiten negativos ni cero).'];
        } elseif (in_array((int)$numero, $_SESSION['numeros'], true)) {
            $_SESSION['flash'] = ['error', "El número $numero ya está reservado."];
        } else {
            $_SESSION['numeros'][] = (int)$numero;
            sort($_SESSION['numeros']);
            $_SESSION['flash'] = ['ok', "Número $numero reservado."];
        }
    } elseif ($accion === 'quitar') {
        $n = (int)$numero;
        $clave = array_search($n, $_SESSION['numeros'], true);
        if ($clave !== false) {
            unset($_SESSION['numeros'][$clave]);
            $_SESSION['numeros'] = array_values($_SESSION['numeros']);
            $_SESSION['flash'] = ['ok', "Número $n eliminado de la reserva."];
        } else {
            $_SESSION['flash'] = ['error', 'Ese número no está reservado.'];
        }
    }
    // Patrón Post/Redirect/Get: al presionar F5 no se reenvía el formulario
    header('Location: rifa.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$cantidad = count($_SESSION['numeros']);
$total = $cantidad * PRECIO_NUMERO;

cabecera('Reserva de números');
?>
<h1>Reserva de números</h1>
<?php if ($flash): ?><div class="<?= $flash[0] ?>"><?= e($flash[1]) ?></div><?php endif; ?>

<form method="POST" action="rifa.php">
    <input type="hidden" name="accion" value="agregar">
    <label for="numero">Número de rifa a reservar</label>
    <input type="number" id="numero" name="numero" min="1" step="1" required>
    <button type="submit">Agregar número</button>
</form>

<h2>Números reservados</h2>
<?php if ($cantidad === 0): ?>
    <p>No hay números reservados.</p>
<?php else: ?>
    <table>
        <tr><th>Número</th><th>Acción</th></tr>
        <?php foreach ($_SESSION['numeros'] as $n): ?>
            <tr>
                <td><?= (int)$n ?></td>
                <td>
                    <form method="POST" action="rifa.php" style="margin:0">
                        <input type="hidden" name="accion" value="quitar">
                        <input type="hidden" name="numero" value="<?= (int)$n ?>">
                        <button type="submit" class="rojo">Quitar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h2>Resumen</h2>
<p>Cantidad de números reservados: <strong><?= $cantidad ?></strong></p>
<p>Precio por número: <strong>$<?= number_format(PRECIO_NUMERO, 0, ',', '.') ?></strong></p>
<p>Total a pagar: <strong>$<?= number_format($total, 0, ',', '.') ?></strong></p>
<?php pie(); ?>
