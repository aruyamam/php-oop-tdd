<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use App\Repository\BugReportRepository;
use App\Helpers\DbQueryBuilderFactory;
use App\Entity\BugReport;

class CrudTest extends TestCase
{
   private $queryBuilder;
   private $repository;
   private $client;

   public function setUp()
   {
      $this->queryBuilder = DbQueryBuilderFactory::make('database', 'pdo', ['db_name' => 'bug_app_testing']);
      $this->repository = new BugReportRepository($this->queryBuilder);
      $this->client = new HttpClient();
      parent::setUp();
   }

   public function testItCanCreateReportUsingPostRequest()
   {
      $postData = $this->getPostData(['add' => true]);
      $this->client->post("http://localhost/bug-report-app/src/add.php", $postData);

      $result = $this->reporsitory->findBy([
         ['report_type', '=', 'Audio'],
         ['link', '=', 'https//example.com'],
         ['email', '=', 'test@example.com'],
      ]);

      $bugReport = $result[0] ?? [];
      self::assertInstanceOf(BugReport::class, $bugReport);
      self::assertSame('Audio', $bugReport->getReportType());
      self::assertSame('https//example.com', $bugReport->getLink());
      self::assertSame('test@example.com', $bugReport->getEmail());

      return $bugReport;
   }

   private function getPostData(array $option = []): array
   {
      return array_merge([
         'reportType' => 'Audio',
         'message' => 'The video on xxx has issuess, please check and fix it',
         'email' => 'test@example.com',
         'link' => 'https//example.com',
      ], $option);
   }
}
