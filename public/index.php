<?php
require_once '../vendor/autoload.php';

use Src\Database\DatabaseConnector;
use Src\Service\UserLoader;
use Src\Service\Messenger;

$dbConnector = new DatabaseConnector();
$userLoader = new UserLoader($dbConnector);
$userLoader->loadFromCSV('../data/users.csv');

$messenger = new Messenger($dbConnector);
$messenger->sendMessages();