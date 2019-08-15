<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;
use App\Repository\BugReportRepository;
use App\Helpers\DbQueryBuilderFactory;
use App\Entity\BugReport;
use App\Helpers\HttpClient;

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
      $response = $this->client->post("http://localhost:8080/src/add.php", $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['statusCode']);

      $result = $this->repository->findBy([
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

   /** @depends testItCanCreateReportUsingPostRequest */
   public function testItCanUpdateReportUsingPostRequest(BugReport $bugReport)
   {
      $postData = $this->getPostData([
         'update' => true,
         'message' => 'The video on PHP OOP has issuess, please check and fix it',
         'link' => 'https//updated.com',
         'reportId' => $bugReport->getId()
      ]);
      $response = $this->client->post("http://localhost/bug-report-app/src/update.php", $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['statusCode']);

      $result = $this->reporsitory->find($bugReport->getId());

      self::assertInstanceOf(BugReport::class, $result);
      self::assertSame(
         'The video on PHP OOP has issuess, please check and fix it',
         $bugReport->getMessage()
      );
      self::assertSame('https//updated.com', $bugReport->getLink());

      return $bugReport;
   }

   /** @depends testItCanUpdateReportUsingPostRequest */
   public function testItCanDeleteReportUsingPostRequest(BugReport $bugReport)
   {
      $postData = [
         'delete' => true,
         'reportId' => $bugReport->getId()
      ];
      $response = $this->client->post("http://localhost/bug-report-app/src/delete.php", $postData);
      $response = json_decode($response, true);
      self::assertEquals(200, $response['statusCode']);

      $result = $this->reporsitory->find($bugReport->getId());
      self::assertNull($bugReport);
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
