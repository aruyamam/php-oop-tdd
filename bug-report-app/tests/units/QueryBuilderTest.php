<?php
namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Database\PDOConnection;
use App\Helpers\Config;
use App\Database\QueryBuilder;

class QueryBuilderTest extends TestCase
{
   private $queryBuilder;

   public function setUp()
   {
      $pdo = new PDOConnection(
         array_merge(
            Config::get('database', 'pdo'),
            ['db_name' => 'bug_app_testing']
         )
      );
      $this->queryBuilder = new QueryBuilder($pdo->connect());
      parent::setUp();
   }

   public function testItCanCreateRecord()
   {
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
         ->where('id', 1);

      var_dump($result->query);
      exit;

      self::assertNotNull($result);
      self::assertSame(1, (int)$result->id);
   }

   public function testItCanPerformSelectQueryMultipleWhereClause()
   {
      $result = $this->queryBuilder
         ->table('reports')
         ->select('*')
         ->where('id', 1)->where('report_type', '=', 'Report Type 1')
         ->first();
      self::assertNotNull($result);
      self::assertSame(1, (int)$result->id);
      self::assertSame('Report Type 1', $result->report_type);
   }
}
