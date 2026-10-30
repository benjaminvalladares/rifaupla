<?php
require __DIR__ . '/inc.php';
requerirLogin();

$carpeta = __DIR__ . '/comprobantes';
$archivos = [];
if (is_dir($carpeta)) {
    foreach (scandir($carpeta) as $f) {
        if ($f !== '.' && $f !== '..' && $f !== '.gitkeep' && is_file($carpeta . '/' . $f)) {
            $archivos[] = $f;
        }
    }
}

cabecera('Archivos cargados');
?>
<h1>Archivos cargados</h1>
<?php if (!$archivos): ?>
    <p>Aún no hay comprobantes cargados.</p>
<?php else: ?>
    <table>
        <tr><th>Nombre del archivo</th><th>Tamaño</th></tr>
        <?php foreach ($archivos as $f): ?>
            <tr>
                <td><a href="comprobantes/<?= rawurlencode($f) ?>" target="_blank"><?= e($f) ?></a></td>
                <td><?= number_format(filesize($carpeta . '/' . $f) / 1024, 1, ',', '.') ?> KB</td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<p><a href="subir_comprobante.php">Subir otro comprobante</a></p>
<?php pie(); ?>
