<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/App.php';

session_start();

$app = new App();
$app->run();
