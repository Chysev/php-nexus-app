<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/./lib/prisma.php';
require_once __DIR__ . '/./modules/routes/routes.php';
require_once __DIR__ . '/./modules/services/services.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$prisma = new Prisma(
    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}",
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);

service::init($prisma);
routes::handleRoutes();
