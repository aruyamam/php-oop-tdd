<?php

namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Helpers\DbQueryBuilderFactory;

class RepositoryTest extends TestCase
{
   private $queryBuilder;
   private $bugReportRespository;

   public function setUp()
   {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_app_testing']);
      $this->queryBuilder->beginTransaction();

      $bugReportRespository = new BugReportRepository($this->queryBuilder);
      parent::setUp();
   }

   public function testItCanCreateRecordWithEntity()
   {
      $newbugReport = $this->createBugReport();
      self::assertInstanceOf(Bugreport::class, $newbugReport);
      self::assertSame('Type 2', $newbugReport->getReportType());
      self::assertSame('https://testing-link.com', $newbugReport->getLink());
      self::assertSame('This is a dummy message', $newbugReport->getMessage());
      self::assertSame('email@test.com', $newbugReport->getEamil());
   }

   public function testItCanUpdateAGivenEntity()
   {
      $newbugReport = $this->createBugReport();
      $bugReport = $this->bugReportRespository->find($newbugReport->getId());
      $bugReport->setMessage('This is from update method')
         ->setLink('https://newlink.com/image.png');
      $updatedReport = $this->bugReportRespository->update($bugReport);

      self::assertInstanceOf(Bugreport::class, $newbugReport);
      self::assertSame('https://newlink.com/image.png', $newbugReport->getLink());
      self::assertSame('This is from update method', $newbugReport->getMessage());
      self::assertSame('email@test.com', $newbugReport->getEamil());
   }

   public function testItCanDeleteAGivenEntity()
   {
      $newbugReport = $this->createBugReport();
      $this->bugReportRespository->delete($newbugReport);
      $bugReport = $this->bugReportRespository->find($newbugReport->getId());
      self::assertNull($bugReport);
   }

   private function createBugReport(): BugReport
   {
      $bugReport = new BugReport();
      $bugReport->setReportType('Type 2')
         ->setLink('https://testing-link.com')
         ->setMessage('This is a dummy message')
         ->setEmail('email@test.com');

      return $this->bugReportRespository->create($bugReport);
   }

   public function tearDown()
   {
      $this->queryBuilder->rollback();
      parent::tearDown();
   }
}
