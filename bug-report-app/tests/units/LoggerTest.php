<?php
namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Contracts\LoggerInterface;
use App\logger\Logger;
use App\Helpers\App;
use App\Logger\LogLevel;
use App\Exception\InvalidLogLevelArgument;

class LoggerTest extends TestCase
{
   private $logger;

   public function setUp()
   {
      $this->logger = new Logger();
      parent::setUp();
   }

   public function testItImplementsTheLoggerInterface()
   {
      self::assertInstanceOf(LoggerInterface::class, $this->logger);
   }

   public function testItCanCreateDifferentTypesOfLogLevel()
   {
      $this->logger->info('Testing Info logs');
      $this->logger->error('Testing Error logs');
      $this->logger->log(LogLevel::ALERT, 'Testing Alert logs');
      $app = new App();

      $fileName = sprintf(
         "%s/%s-%s.log",
         $app->getLogPath(),
         'test',
         date("j.n.Y")
      );
      self::assertFileExists($fileName);

      $contentOfLogFile = file_get_contents($fileName);
      self::assertStringContainsString('Testing Info logs', $contentOfLogFile);
      self::assertStringContainsString('Testing Error logs', $contentOfLogFile);
      self::assertStringContainsString(LogLevel::ALERT, $contentOfLogFile);
      unlink($fileName);
      self::assertFileNotExists($fileName);
   }

   public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLogLevel()
   {
      self::expectException(InvalidLogLevelArgument::class);
      $this->logger->log('invalid', 'Testing invalid log level');
   }
}
