<?php
require __DIR__ . '/vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/.env');
define('BASEURL', 'https://dtechsideprojects.online/');

require_once __DIR__ . '/lib/database.php';
require_once __DIR__ . '/lib/csrf.php';
require_once __DIR__ . '/lib/flash.php';
require_once __DIR__ . '/lib/email.php';

require_once __DIR__ . '/entity/Registration.php';
require_once __DIR__ . '/entity/BoothRegistration.php';
require_once __DIR__ . '/entity/Event.php';
require_once __DIR__ . '/entity/Booth.php';

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

function current_time()
{
  $currentTimePST = new DateTime('now', new DateTimeZone('Asia/Manila'));
  return $currentTimePST->format('Y-m-d H:i:s');
}
