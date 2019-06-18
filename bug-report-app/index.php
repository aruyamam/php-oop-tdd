<?php
declare (strict_types = 1);

use App\Helpers\App;
use App\Helpers\Config;
use App\Logger\Logger;
use App\Logger\LogLevel;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/exception/exception.php';

$logger = new Logger();
$logger->log(LogLevel::EMERGENCY, 'There is an emergency', ['exception' => 'exception occured']);
$logger->info('User account created successfully', ['id' => 5]);
