<?php
namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Database\PDOConnection;
use App\Exception\MissingArgumentException;
use App\Helpers\Config;
use App\Contracts\DatabaseConnectionInterface;

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
      $credentials = $this->getCredentials('pdo');
      $pdoHandler = (new PDOConnection($credentials))->connect();
      self::assertInstanceOf(DatabaseConnectionInterface::class, $pdoHandler);
      return $pdoHandler;
   }

   /** @depends testItCanConnectToDatabaseWithPdoApi */
   public function testItIsValidPdoConnection(DatabaseConnectionInterface $handler)
   {
      self::assertInstanceOf(\PDO::class, $handler->getConnection());
   }

   private function getCredentials(string $type)
   {
      return array_merge(
         Config::get('database', $type),
         ['db_name' => 'bug_app_testing']
      );
   }
}
