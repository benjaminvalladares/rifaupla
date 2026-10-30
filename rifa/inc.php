<?php
// Archivo incluido por las páginas del sistema web
session_start();

const WEB_USUARIO = 'userupla';
const WEB_CLAVE   = 'upla123';
const PRECIO_NUMERO = 2000;

function requerirLogin(): void
{
    if (empty($_SESSION['autenticado'])) {
        header('Location: index.php');
        exit;
    }
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function cabecera(string $titulo, bool $menu = true): void
{
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . e($titulo) . '</title>';
    echo '<style>
        body{font-family:system-ui,Arial,sans-serif;background:#f4f6f9;margin:0;color:#222}
        nav{background:#0b3c6f;padding:12px 24px}
        nav a{color:#fff;margin-right:18px;text-decoration:none;font-weight:600}
        nav a:hover{text-decoration:underline}
        main{max-width:640px;margin:32px auto;background:#fff;padding:28px;border-radius:10px;box-shadow:0 2px 8px #0002}
        h1{margin-top:0;color:#0b3c6f}
        label{display:block;margin:14px 0 4px;font-weight:600}
        input{width:100%;padding:9px;border:1px solid #bbb;border-radius:6px;box-sizing:border-box}
        button{margin-top:16px;padding:10px 18px;background:#0b3c6f;color:#fff;border:0;border-radius:6px;cursor:pointer}
        button.rojo{background:#b3261e;margin:0;padding:4px 10px}
        .ok{background:#e3f6e8;color:#1b6b34;padding:10px;border-radius:6px;margin:12px 0}
        .error{background:#fde7e7;color:#a11;padding:10px;border-radius:6px;margin:12px 0}
        table{width:100%;border-collapse:collapse;margin-top:14px}
        td,th{border-bottom:1px solid #ddd;padding:8px;text-align:left}
        .cap{font-size:1.4em;font-weight:700;background:#eef2f7;padding:8px 12px;border-radius:6px;display:inline-block}
    </style></head><body>';
    if ($menu) {
        echo '<nav><a href="panel.php">Panel</a><a href="rifa.php">Rifa</a><a href="buscar.php">Buscar</a>'
           . '<a href="subir_comprobante.php">Subir comprobante</a><a href="archivos.php">Archivos</a>'
           . '<a href="salir.php">Salir</a></nav>';
    }
    echo '<main>';
}

function pie(): void
{
    echo '</main></body></html>';
}
