<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();
$dotenv->required('DEBUG')->notEmpty();

$app = new Silex\Application();
$app['debug'] = getenv('DEBUG') === 'true'? true: false;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => dirname(__DIR__) . '/views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig');
});

$app->run();