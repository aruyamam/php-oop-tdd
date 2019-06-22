<?php
namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use PDOException, PDO;
use App\Exception\DatabaseConnectionException;

class PDOConnection extends AbstractConnection implements DatabaseConnectionInterface
{
   const REQUIRED_CONNECTION_KEYS = [
      'driver',
      'host',
      'db_name',
      'db_username',
      'db_user_password',
      'default_fetch'
   ];

   public function connect(): PDOConnection
   {
      $crendentials = $this->parseCredentials($this->credentials);
      try {
         $this->connection = new PDO(...$crendentials);
         $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $this->connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            $this->credentials['default_fetch']
         );
      } catch (PDOException $exception) {
         throw new DatabaseConnectionException($exception->getMessage(), $this->credentials, 500);
      }

      return $this;
   }

   public function getConnection()
   {
      return $this->connection;
   }

   protected function parseCredentials(array $crendentials): array
   {
      $dsn = sprintf(
         '%s:host=%s;dbname=%s',
         $crendentials['driver'],
         $crendentials['host'],
         $crendentials['db_name']
      );

      return [$dsn, $crendentials['db_username'], $crendentials['db_user_password']];
   }
}
