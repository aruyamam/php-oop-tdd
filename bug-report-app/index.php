<?php
declare (strict_types = 1);

use App\Helpers\App;
use App\Exception\ExceptionHanlder;
use App\Helpers\Config;

require_once __DIR__ . '/vendor/autoload.php';

set_exception_handler([new ExceptionHanlder(), 'handle']);

$config = Config::getFileContent('dklsfj');
var_dump($config);

$application = new App();
echo $application->getServerTime()->format('Y-m-d H:i:s') . PHP_EOL;
echo $application->getLogPath() . PHP_EOL;
echo $application->getEnvironment() . PHP_EOL;
echo $application->isDebugMode() . PHP_EOL;

if ($application->isRunningFromConsole()) {
   echo 'from console';
} else {
   echo 'from browser';
}
