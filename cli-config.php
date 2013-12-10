<?php

require_once 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;

$logger = new Logger('sql-logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/log/sql.log', Logger::DEBUG));
$dbalLogger = new DbalLogger($logger);

$paths     = array(__DIR__ . '/src/joseahernandez/blogExercise/Entity');
$isDevMode = true;

$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'dbname'   => 'blog-exercise',
    'user'     => 'root',
    'password' => 'root',
    'host'     => '127.0.0.1',
    'port'     => '3306',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$config->setSQLLogger($dbalLogger);

$em = EntityManager::create($connectionOptions, $config);

$helpers = new HelperSet(
    array(
        'db' => new ConnectionHelper($em->getConnection()),
        'em' => new EntityManagerHelper($em)
    )
);
