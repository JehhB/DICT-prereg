<?php
require_once __DIR__ . '/src/setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (hash_equals($env['status_password'], $_POST['password'])) {
    $_SESSION['super_admin'] = true;
  } else {
    flash_set('errors', 'password', 'Incorrect password!');
  }

  redirect_response('./attendance.php');
}

if (isset($_GET['logout'])) {
  unset($_SESSION['super_admin']);
  redirect_response('./attendance.php');
} else if (!isset($_SESSION['super_admin'])) {
  include_once __DIR__ . '/src/views/status_auth.php';
} else if (isset($_GET['email'])) {
  $email = $_GET['email'];
  $reg = Registration::find_by_email($email);

  if (is_null($reg)) {
    http_response_code(404);
    exit();
  }

  header('Content-Type: application/json');
  echo json_encode($reg);
  exit();
} else if (isset($_GET['slug'])) {
  $slug = $_GET['slug'];
  $reg = Registration::find($slug);

  if (is_null($reg)) {
    http_response_code(404);
    exit();
  }

  header('Content-Type: application/json');
  echo json_encode($reg);
  exit();
} else if (isset($_GET['report'])) {
  include_once __DIR__ . '/src/views/attendance_report.php';
} else {
  include_once __DIR__ . '/src/views/attendance_desktop.php';
}
