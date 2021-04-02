<?php 
require __DIR__.'/vendor/autoload.php';
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;
use Desafios\Src\Database;

header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include __DIR__.'/config/config.php';
include __DIR__.'/src/helpers.php';

new Database();

SimpleRouter::setDefaultNamespace('\Desafios\App\Http\Controllers');

include 'routes/routes.php';

try {
    SimpleRouter::start();
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(['message' => $e->getMessage()]);
}
