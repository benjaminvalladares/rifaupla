<?php
// Funciones compartidas por todos los servicios de la API
session_start();
header('Content-Type: application/json; charset=utf-8');

const API_USUARIO = 'userupla';
const API_CLAVE   = 'upla123';

// Permite recibir datos tanto por form-data/x-www-form-urlencoded como por JSON (Postman)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'
    && stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
    $json = json_decode(file_get_contents('php://input'), true);
    if (is_array($json)) {
        $_POST = $json;
    }
}

function responder(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function requerirMetodo(string $metodo): void
{
    if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        responder(405, ['ok' => false, 'mensaje' => "Método no permitido. Use $metodo."]);
    }
}

function requerirSesion(): void
{
    if (empty($_SESSION['api_autenticado'])) {
        responder(401, ['ok' => false, 'mensaje' => 'No autorizado. Debe iniciar sesión primero.']);
    }
}

function leerJson(string $archivo): array
{
    $ruta = __DIR__ . '/data/' . $archivo;
    if (!file_exists($ruta)) {
        return [];
    }
    $datos = json_decode(file_get_contents($ruta), true);
    return is_array($datos) ? $datos : [];
}

function guardarJson(string $archivo, array $datos): void
{
    $ruta = __DIR__ . '/data/' . $archivo;
    file_put_contents(
        $ruta,
        json_encode(array_values($datos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    );
}

function texto(array $origen, string $clave): string
{
    return trim((string)($origen[$clave] ?? ''));
}
