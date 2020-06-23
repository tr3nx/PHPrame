<?php

// production
// error_reporting(0);
// ini_set('display_errors', 0);

// development
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('APP_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../core/Support/helpers.php';

$config = require __DIR__ . '/../config.php';

exit((new \Core\App($config))->execute());
