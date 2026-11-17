<?php
require_once __DIR__ . '/vendor/autoload.php';
header('Content-Type: text/html; charset=UTF-8');

use App\Data\DataGenerator;
use App\Exceptions\MaterialNoDisponibleException;

session_start();
if (($_GET['page'] ?? 'inici') === 'reset') {
    session_destroy();
    header('Location: index.php');
    exit;
}
if (!isset($_SESSION['biblioteca'])) $_SESSION['biblioteca'] = DataGenerator::crear();
$biblioteca = $_SESSION['biblioteca'];
$page = $_GET['page'] ?? 'inici';
try {
    $vista = match ($page) {
        'inici' => 'views/inici.php',
        'materials' => 'views/materials.php',
        'material' => 'views/material.php',
        'usuaris' => 'views/usuaris.php',
        'usuari' => 'views/usuari.php',
        'prestecs' => 'views/prestecs.php',
        'prestec' => 'views/prestec.php',
        'retorn' => 'views/retorn.php',
        'reserves' => 'views/reserves.php',
        'reserva' => 'views/reserva.php',
        'estadistiques' => 'views/estadistiques.php',
        'auditoria' => 'views/auditoria.php',
        'demo_magic' => 'views/demo_magic.php',
        'demo_serialization' => 'views/demo_serialization.php',
        'demo_exceptions' => 'views/demo_exceptions.php',
        'demo_autoload' => 'views/demo_autoload.php',
        default => 'views/404.php',
    };
    require __DIR__ . '/' . $vista;
    $_SESSION['biblioteca'] = $biblioteca;
} catch (MaterialNoDisponibleException $e) {
    $_SESSION['biblioteca'] = $biblioteca;
    $error = (string)$e;
    require __DIR__ . '/views/error.php';
} catch (\Exception $e) {
    $_SESSION['biblioteca'] = $biblioteca;
    $error = $e->getMessage();
    require __DIR__ . '/views/error.php';
}
