<?php

include __DIR__ . '/src/Framework/Database.php';
require __DIR__ . '/vendor/autoload.php';

use Framework\Database;
use App\Config\Paths;
use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(Paths::ROOT);
$dotEnv->load();

$db = new Database(
    $_ENV['DB_DRIVER'],
    [
        "host" => $_ENV['DB_HOST'],
        "port" => $_ENV['DB_PORT'],
        "dbname" => $_ENV['DB_NAME']
    ],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

$sqlFile = file_get_contents("./database.sql");
$db->query($sqlFile);
