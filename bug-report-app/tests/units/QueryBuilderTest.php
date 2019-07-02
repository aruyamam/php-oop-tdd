<?php

namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Helpers\DbQueryBuilderFactory;

class QueryBuilderTest extends TestCase
{
   private $queryBuilder;

   public function setUp()
   {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_app_testing']);
      $this->queryBuilder->getConnection()->beginTransaction();
      parent::setUp();
   }

   public function testItCanCreateRecord()
   {
      $id = $this->insertIntoTable();
      self::assertNotNull($id);
   }

   public function testItCanPerformRawQuery()
   {
      $id = $this->insertIntoTable();
      $result = $this->queryBuilder->raw("SELECT * FROM reports;");
      self::assertNotNull($result);
   }

   public function testItCanPerformSelectQuery()
   {
      $id = $this->insertIntoTable();
      $result = $this->queryBuilder
         ->table('reports')
         ->select('*')
         ->where('id', $id)
         ->first();

      self::assertNotNull($result);
      self::assertSame($id, $result->id);
   }

   public function testItCanPerformSelectQueryMultipleWhereClause()
   {
      $id = $this->insertIntoTable();
      $result = $this->queryBuilder
         ->table('reports')
         ->select('*')
         ->where('id', $id)
         ->where('report_type', 'Report Type 1')
         ->first();
      self::assertNotNull($result);
      self::assertSame($id, $result->id);
      self::assertSame('Report Type 1', $result->report_type);
   }

   public function tearDown()
   {
      $this->queryBuilder->getConnection()->rollback();
      parent::tearDown();
   }

   private function insertIntoTable()
   {
      $data = [
         'report_type' => 'Report Type 1',
         'message' => 'This is a dummy message',
         'email' => 'support[devscreencast',
         'link' => 'https://link.com',
         'created_at' => date('Y-m-d H:i:s')
      ];
      $id = $this->queryBuilder->table('reports')->create($data);
      return $id;
   }
}
