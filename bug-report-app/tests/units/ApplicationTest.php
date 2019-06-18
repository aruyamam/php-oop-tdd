<?php
namespace Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Helpers\App;

class ApplicationTest extends TestCase
{
   public function testItCanGetInstanceOfApplication()
   {
      self::assertInstanceOf(App::class, new App());
   }
}
