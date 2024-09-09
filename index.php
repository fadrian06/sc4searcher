<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'routes.php';

Flight::set('db', new SQLite3('sc4searcher.db'));
$sql = file_get_contents('init.sqlite.sql');
$queries = array_filter(explode(';', $sql));

foreach ($queries as $query) {
  if (trim($query)) {
    Flight::get('db')->exec($query);
  }
}

Flight::get('db')->exec('PRAGMA foreign_keys = ON');
Flight::start();
