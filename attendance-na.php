<?php
require_once __DIR__ . '/src/setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $slug = null;

  try {
    execute('INSERT INTO Attendances (registration_id, signature) VALUES (?,?)', [
      $_POST['id'],
      $_POST['signature'],
    ]);
    $slug = execute('SELECT slug FROM Registrations WHERE registration_id = ?', [$_POST['id']])->fetchColumn();
    $_SESSION['auth_summary'] = $slug;
    redirect_response('./summary.php');
  } catch (Exception $e) {
    flash_set('errors', 'form', 'An attendance is already recorded for this registration');
    redirect_response('./attendance-na.php');
  }
}

if (isset($_GET['email'])) {
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
} else if (isset($_GET['conf'])) {
  include_once __DIR__ . '/src/views/attendance_confirmation.php';
} else {
  include_once __DIR__ . '/src/views/attendance_na.php';
}
