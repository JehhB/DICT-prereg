<?php

require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/csrf.php';
require_once __DIR__ . '/lib/flash.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !validateCsrfToken()) {
  $_SESSION['fatal_error'] = ['code' => 403, 'message' => 'Error 403: Forbidden'];
  header('Location: /error.php');
  exit();
}
