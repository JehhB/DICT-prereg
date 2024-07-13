<?php

require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/csrf.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !validateCsrfToken()) {
  header('HTTP/1.1 403 Forbidden');
  echo '<strong>Error 403: Forbidden</strong>';
  exit();
}
