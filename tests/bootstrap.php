<?php

// Error Reporting
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Setup Autoloader
$loader = require __DIR__."/../vendor/autoload.php";
$loader->add('Earley\\', __DIR__.'/../src');
