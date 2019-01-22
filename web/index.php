<?php

require '../bootstrap.php';

$config = require '../config/main.php';

$app = Application::getInstance();

$app->run($config);