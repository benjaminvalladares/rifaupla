<?php
require __DIR__ . '/inc.php';

// Participantes definidos previamente
$participantes = [
    ['nombre' => 'Universidad', 'apellido' => 'Playa Ancha', 'ciudad' => 'Valparaiso', 'categoria' => 'Grupo A'],
    ['nombre' => 'Camila',      'apellido' => 'Rojas',       'ciudad' => 'Santiago',    'categoria' => 'Grupo B'],
    ['nombre' => 'Matias',      'apellido' => 'Soto',        'ciudad' => 'Vina del Mar','categoria' => 'Grupo A'],
    ['nombre' => 'Valentina',   'apellido' => 'Munoz',       'ciudad' => 'Concepcion',  'categoria' => 'Grupo C'],
];

function norm(string $s): string
{
    return mb_strtolower(trim($s), 'UTF-8');
}

$nombre = $apellido = $ciudad = $categoria = '';
$resultado = null;

if (isset($_GET['nombre'], $_GET['apellido'], $_GET['ciudad'], $_GET['categoria'])) {
    $nombre    = trim($_GET['nombre']);
    $apellido  = trim($_GET['apellido']);
    $ciudad    = trim($_GET['ciudad']);
    $categoria = trim($_GET['categoria']);

    $resultado = false;
    foreach ($participantes as $p) {
        // Deben cumplirse todas las condiciones
        if (norm($p['nombre']) === norm($nombre)
            && norm($p['apellido']) === norm($apellido)
            && norm($p['ciudad']) === norm($ciudad)
            && norm($p['categoria']) === norm($categoria)) {
            $resultado = true;
            break;
        }
    }
}

cabecera('Buscar participantes', !empty($_SESSION['autenticado']));
?>
<h1>Búsqueda de participantes</h1>
<form method="GET" action="buscar.php">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?= e($nombre) ?>" required>
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" value="<?= e($apellido) ?>" required>
    <label for="ciudad">Ciudad</label>
    <input type="text" id="ciudad" name="ciudad" value="<?= e($ciudad) ?>" required>
    <label for="categoria">Categoría</label>
    <input type="text" id="categoria" name="categoria" value="<?= e($categoria) ?>" required>
    <button type="submit">Buscar</button>
</form>

<?php if ($resultado === true): ?>
    <div class="ok"><strong>Participante encontrado</strong></div>
<?php elseif ($resultado === false): ?>
    <div class="error"><strong>Participante no encontrado</strong></div>
<?php endif; ?>
<?php pie(); ?>
