<?php
namespace App\Exception;

use App\Helpers\App;
use Throwable;

class ExceptionHanlder
{
   public function handle(Throwable $exception): void
   {
      $application = new App;

      if ($application->isDebugMode()) {
         var_dump($exception);
      } else {
         echo "This should no have happened, please try again";
      }
      exit;
   }
}
