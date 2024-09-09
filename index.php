<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'routes.php';

$sql = file_get_contents('init.sqlite.sql');
$queries = array_filter(explode(';', $sql));

foreach ($queries as $query) {
  if (trim($query)) {
    db()->exec($query);
  }
}

db()->exec('PRAGMA foreign_keys = ON');
session_start();
Flight::start();
