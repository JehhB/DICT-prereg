<?php

require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/csrf.php';
require_once __DIR__ . '/lib/flash.php';

require_once __DIR__ . '/entity/Registration.php';
require_once __DIR__ . '/entity/BoothRegistration.php';
require_once __DIR__ . '/entity/Event.php';

session_start();

function redirect_response(string $target)
{
  header("Location: $target");
  exit();
}

function error_response(int $code = 200, string $message = 'Error 200: Bad request')
{
  $_SESSION['fatal_error'] = ['code' => $code, 'message' => $message];
  header('Location: /error.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !validateCsrfToken()) {
  error_response(403, 'Error 403: Forbidden');
}
