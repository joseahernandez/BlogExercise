<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/cli-config.php';

use Symfony\Component\Console\Application;
use joseahernandez\blogExercise\Command\Author\AuthorCreateCommand;
use joseahernandez\blogExercise\Command\Author\AuthorSearchCommand;
use joseahernandez\blogExercise\Command\Author\AuthorUpdateCommand;
use joseahernandez\blogExercise\Command\Author\AuthorDeleteCommand;
use joseahernandez\blogExercise\Command\Tag\TagCreateCommand;

$console = new Application();
$console->add(new AuthorCreateCommand($em, new \joseahernandez\blogExercise\Author\AuthorCreator($em)));
$console->add(new AuthorSearchCommand($em));
$console->add(new AuthorUpdateCommand($em, new \joseahernandez\blogExercise\Author\AuthorModificator($em)));
$console->add(new AuthorDeleteCommand($em));

$console->add(new TagCreateCommand($em, new \joseahernandez\blogExercise\Tag\TagCreator($em)));

$console->run();