<?php
require_once __DIR__ . '/src/setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (hash_equals($env['status_password'], $_POST['password'])) {
    $_SESSION['super_admin'] = true;
  } else {
    flash_set('errors', 'password', 'Incorrect password!');
  }

  redirect_response('./status.php');
}

if (isset($_GET['logout'])) {
  unset($_SESSION['super_admin']);
} else if (!isset($_SESSION['super_admin'])) {
  include_once __DIR__ . '/src/views/status_auth.php';
} else {
  include_once __DIR__ . '/src/views/status_info.php';
}
