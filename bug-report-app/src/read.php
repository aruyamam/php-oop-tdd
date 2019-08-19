<?php

declare(strict_types=1);

use App\Helpers\DbQueryBuilderFactory;
use App\Repository\BugReportRepository;

$queryBuilder = DbQueryBuilderFactory::make();
$repository = new BugReportRepository();

$bugReport = $repository->findAll();
