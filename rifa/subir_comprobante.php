<?php
require __DIR__ . '/inc.php';
requerirLogin();

$carpeta = __DIR__ . '/comprobantes';
if (!is_dir($carpeta)) {
    mkdir($carpeta, 0755, true);
}

$mensaje = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['comprobante']) || $_FILES['comprobante']['error'] === UPLOAD_ERR_NO_FILE) {
        $mensaje = ['error', 'Debe seleccionar un archivo.'];
    } elseif ($_FILES['comprobante']['error'] !== UPLOAD_ERR_OK) {
        $mensaje = ['error', 'Error al subir el archivo (código ' . (int)$_FILES['comprobante']['error'] . ').'];
    } else {
        $original = basename($_FILES['comprobante']['name']);
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $permitidas = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];

        if (!in_array($ext, $permitidas, true)) {
            $mensaje = ['error', 'Tipo de archivo no permitido. Use: ' . implode(', ', $permitidas) . '.'];
        } elseif ($_FILES['comprobante']['size'] > 5 * 1024 * 1024) {
            $mensaje = ['error', 'El archivo supera el máximo de 5 MB.'];
        } else {
            // Nombre seguro y único
            $base = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($original, PATHINFO_FILENAME));
            $destino = $carpeta . '/' . date('Ymd_His') . '_' . $base . '.' . $ext;
            if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $destino)) {
                $mensaje = ['ok', 'Archivo cargado correctamente: ' . basename($destino)];
            } else {
                $mensaje = ['error', 'No se pudo guardar el archivo en el servidor.'];
            }
        }
    }
}

cabecera('Subir comprobante');
?>
<h1>Subir comprobante</h1>
<?php if ($mensaje): ?><div class="<?= $mensaje[0] ?>"><?= e($mensaje[1]) ?></div><?php endif; ?>
<form method="POST" action="subir_comprobante.php" enctype="multipart/form-data">
    <label for="comprobante">Archivo (pdf, jpg, png, gif, txt - máx. 5 MB)</label>
    <input type="file" id="comprobante" name="comprobante" required>
    <button type="submit">Subir</button>
</form>
<p><a href="archivos.php">Ver archivos cargados</a></p>
<?php pie(); ?>
