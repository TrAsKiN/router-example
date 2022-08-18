<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new \App\App();
echo $app->run();
