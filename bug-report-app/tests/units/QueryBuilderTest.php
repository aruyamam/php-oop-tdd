<?php

namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Database\PDOConnection;
use App\Helpers\Config;
use App\Database\PDOQueryBuilder;

class QueryBuilderTest extends TestCase
{
   private $queryBuilder;

   public function setUp()
   {
      $credentials = array_merge(
         Config::get('database', 'pdo'),
         ['db_name' => 'bug_app_testing']
      );
      $pdo = new PDOConnection($credentials);
      $this->queryBuilder = new PDOQueryBuilder($pdo->connect());
      parent::setUp();
   }

   public function testItCanCreateRecord()
   {
      $data = [
         'report_type' => 'Report Type 1',
         'message' => 'This is a dummy message',
         'email' => 'support[devscreencast',
         'link' => 'https://link.com',
         'created_at' => date('Y-m-d H:i:s')
      ];
      $id = $this->queryBuilder->table('reports')->create($data);
      self::assertNotNull($id);
   }

   public function testItCanPerformRawQuery()
   {
      $result = $this->queryBuilder->raw("SELECT * FROM reports;");
      self::assertNotNull($result);
   }

   public function testItCanPerformSelectQuery()
   {
      $result = $this->queryBuilder
         ->table('reports')
         ->select('*')
         ->where('id', 1)
         ->first();

      self::assertNotNull($result);
      self::assertSame(1, (int) $result->id);
   }

   public function testItCanPerformSelectQueryMultipleWhereClause()
   {
      $result = $this->queryBuilder
         ->table('reports')
         ->select('*')
         ->where('id', 1)->where('report_type', '=', 'Report Type 1')
         ->first();
      self::assertNotNull($result);
      self::assertSame(1, (int) $result->id);
      self::assertSame('Report Type 1', $result->report_type);
   }
}
