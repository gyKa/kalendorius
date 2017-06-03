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
    $sql = 'SELECT * FROM events';

    $events = $app['db']->fetchAll($sql);

    return $app['twig']->render('index.twig', ['events' => $events]);
});

$app->run();
