<?php
namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;

class DatabaseConnectionTest extends TestCase
{
   public function testItThrowMissingArgumentExceptionWithWrongCredentialKeys()
   {
      self::expectException(MissingArgumentException::class);
      $credentials = [];
      $pdoHandler = new PDOConnection($credentials);
   }

   public function testItCanConnectToDatabaseWithPdoApi()
   {
      $credentials = [];
      $pdoHandler = (new PDOConnection($credentials))->connect();
      self::assertNotNull($pdoHandler);
   }
}
