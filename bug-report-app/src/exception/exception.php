<?php
declare (strict_types = 1);

use App\Exception\ExceptionHanlder;

set_error_handler([new ExceptionHanlder(), 'convertWarningsAndNoticesToException']);
set_exception_handler([new ExceptionHanlder(), 'handle']);
