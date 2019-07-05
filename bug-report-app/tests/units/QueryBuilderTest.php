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

   public function testItCanFindById()
   {
      $id = $this->insertIntoTable();
      $result = $this->queryBuilder->select('*')->find($id);
      self::assertNotNull($result);
      self::assertSame($id, $result->id);
      self::assertSame('Report Type 1', $result->report_type);
   }

   public function testItCanFindOneByGivenValue()
   {
      $id = $this->insertIntoTable();
      $result = $this->queryBuilder->select('*')->findOneBy('report_type', 'Report Type 1');
      self::assertNotNull($result);
      self::assertSame($id, $result->id);
      self::assertSame('Report Type 1', $result->report_type);
   }

   public function testItCanUpdateGivenRecord()
   {
      $id = $this->insertIntoTable();
      $count = $this->queryBuilder->table('reports')->update([
         'report_type' => 'Report Type 1 updated'
      ])->where('id', $id)->count();

      self::assertEquals(1, $count);
      $result = $this->queryBuilder->select('*')->find($id);
      self::assertNotNull($result);
      self::assertSame($id, $result->id);
      self::assertSame('Report Type 1 updated', $result->report_type);
   }

   public function testItCanDeleteGivenId()
   {
      $id = $this->insertIntoTable();
      $count = $this->queryBuilder->table('reports')->delete()->where('id', $id)->count();

      self::assertEquals(1, $count);
      $result = $this->queryBuilder->select('*')->find($id);
      self::assertNull($result);
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
