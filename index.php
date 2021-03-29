<?php 
require __DIR__.'/vendor/autoload.php';
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;
use Desafios\Src\Database;

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
    //var_dump($e->getCode());
    echo $e->getMessage();
}
