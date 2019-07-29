<?php

namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Entity\BugReport;
use App\Helpers\DbQueryBuilderFactory;
use App\Repository\BugReportRepository;

class RepositoryTest extends TestCase
{
   private $queryBuilder;
   private $bugReportRespository;

   public function setUp()
   {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_app_testing']);
      $this->queryBuilder->beginTransaction();

      $this->bugReportRespository = new BugReportRepository($this->queryBuilder);
      parent::setUp();
   }

   public function testItCanCreateRecordWithEntity()
   {
      $newbugReport = $this->createBugReport();
      self::assertInstanceOf(Bugreport::class, $newbugReport);
      self::assertSame('Type 2', $newbugReport->getReportType());
      self::assertSame('https://testing-link.com', $newbugReport->getLink());
      self::assertSame('This is a dummy message', $newbugReport->getMessage());
      self::assertSame('email@test.com', $newbugReport->getEmail());
   }

   public function testItCanUpdateAGivenEntity()
   {
      $newbugReport = $this->createBugReport();
      $bugReport = $this->bugReportRespository->find($newbugReport->getId());
      $bugReport->setMessage('This is from update method')
         ->setLink('https://newlink.com/image.png');
      $updatedReport = $this->bugReportRespository->update($bugReport);

      self::assertInstanceOf(Bugreport::class, $updatedReport);
      self::assertSame('https://newlink.com/image.png', $updatedReport->getLink());
      self::assertSame('This is from update method', $updatedReport->getMessage());
      self::assertSame('email@test.com', $updatedReport->getEmail());
   }

   public function testItCanDeleteAGivenEntity()
   {
      $newbugReport = $this->createBugReport();
      $this->bugReportRespository->delete($newbugReport);
      $bugReport = $this->bugReportRespository->find($newbugReport->getId());
      self::assertNull($bugReport);
   }

   public function testItCanFindByCriteria()
   {
      $this->createBugReport();
      $report = $this->bugReportRespository->findBy([
         ['report_type', '=', 'Type 2'],
         ['email', 'email@test.com'],
      ]);
      self::assertIsArray($report);

      $bugReport = $report[0];
      self::assertSame('Type 2', $bugReport->getReportType());
      self::assertSame('email@test.com', $bugReport->getEmail());
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
