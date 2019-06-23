<?php
namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use mysqli, mysqli_driver;
use App\Exception\DatabaseConnectionException;
use Throwable;

class MySQLiConnection extends AbstractConnection implements DatabaseConnectionInterface
{
   const REQUIRED_CONNECTION_KEYS = [
      'host',
      'db_name',
      'db_username',
      'db_user_password',
      'default_fetch'
   ];

   protected function parseCredentials(array $crendentials): array
   {
      return [
         $crendentials['host'],
         $crendentials['db_username'],
         $crendentials['db_user_password'],
         $crendentials['db_name'],
      ];
   }

   public function connect(): MySQLiConnection
   {
      $driver = new mysqli_driver;
      $driver->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;
      $crendentials = $this->parseCredentials($this->credentials);
      try {
         $this->connection = new mysqli(...$crendentials);
      } catch (Throwable $exception) {
         throw new DatabaseConnectionException(
            $exception->getMessage(),
            $this->credentials,
            500
         );
      }
      return $this;
   }

   public function getConnection(): mysqli
   {
      return $this->connection;
   }
}
