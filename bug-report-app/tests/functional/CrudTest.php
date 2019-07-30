<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use App\Repository\BugReportRepository;
use App\Helpers\DbQueryBuilderFactory;

class CrudTest extends TestCase
{
   private $queryBuilder;
   private $repository;

   public function setUp()
   {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_app_testing']);
      $this->queryBuilder->beginTransaction();
      $this->repository = new BugReportRepository($this->queryBuilder);
      parent::setUp();
   }

   public function tearDown()
   {
      $this->queryBuilder->rollback();
      parent::tearDown();
   }
}
