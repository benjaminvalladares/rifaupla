<?php
require __DIR__ . '/inc.php';
requerirLogin();
cabecera('Panel');
?>
<h1>Panel principal</h1>
<p>Bienvenido, <strong><?= e($_SESSION['usuario']) ?></strong>. Seleccione una función:</p>
<ul>
    <li><a href="rifa.php">Reservar números de la rifa</a></li>
    <li><a href="buscar.php">Buscar participantes</a></li>
    <li><a href="subir_comprobante.php">Subir comprobante</a></li>
    <li><a href="archivos.php">Ver archivos cargados</a></li>
    <li><a href="salir.php">Cerrar sesión</a></li>
</ul>
<?php pie(); ?>
