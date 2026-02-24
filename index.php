<?php
require_once 'config/config.php';
require_once 'config/conexion.php';

$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');

switch($url) {
    case 'home':
    case '':
        include 'views/home/index.php';
        break;
    case 'armenia':
        include 'views/ciudades/armenia.php';
        break;
    case 'pereira':
        include 'views/ciudades/pereira.php';
        break;
    case 'manizales':
        include 'views/ciudades/manizales.php';
        break;
    case 'about':
        include 'views/about.html';
        break;
    case 'cotizar':                                          // ← agregar esto
        include BASE_PATH . '/views/cotizar/index.php';
        break;
    
    default:
        http_response_code(404);
        include 'views/404.php';
}