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

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'kalendorius',
        'user'      => 'kalendorius',
        'password'  => 'kalendorius',
        'charset'   => 'utf8',
    ),
));

$app->get('/', function () use ($app) {
    $events = $app['db']->fetchAll('SELECT * FROM events');
    $labels = $app['db']->fetchAll('SELECT * FROM labels');
    $categories = $app['db']->fetchAll('SELECT * FROM categories');

    return $app['twig']->render(
        'index.twig',
        [
            'events' => $events,
            'labels' => $labels,
            'categories' => $categories,
        ]
    );
});

$app->run();
