<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();
$dotenv->required('DEBUG')->notEmpty();

$app = new Silex\Application();
$app['debug'] = getenv('DEBUG') === 'true'? true: false;

$app->get('/', function () {
    return 'Hello World!';
});

$app->run();