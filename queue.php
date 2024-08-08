<?php

require_once __DIR__ . '/src/setup.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $page = urlencode($_GET['p'] ?? '1');
  $search = urlencode($_GET['s'] ?? '');

  if (isset($_GET['logout'])) {
    unset($_SESSION['auth_admin']);
    redirect_response('./queue.php');
  } else if (!isset($_SESSION['auth_admin'])) {
    include __DIR__ . '/src/views/admin_auth.php';
  } else if (isset($_GET['done'])) {
    $id = $_GET['done'];
    BoothRegistration::mark_done($id);
    redirect_response("./queue.php?p=$page&s=$search");
  } else if (isset($_GET['skip'])) {
    $id = $_GET['skip'];
    BoothRegistration::mark_skipped($id);
    redirect_response("./queue.php?p=$page&s=$search");
  } else if (isset($_GET['undo'])) {
    $id = $_GET['undo'];
    BoothRegistration::undo($id);
    redirect_response("./queue.php?p=$page&s=$search");
  } else if (isset($_GET['table'])) {
    include __DIR__ . '/src/views/queue-table.php';
  } else {
    include __DIR__ . '/src/views/queue.php';
  }
  exit();
}


if (isset($_POST['login'])) {
  $validate_filters = [
    'email' => FILTER_DEFAULT,
    'password' => FILTER_DEFAULT,
  ];

  $input = filter_var_array($_POST, $validate_filters);
  $input = array_intersect_key($input, $validate_filters);

  $has_error = false;
  $booth = Booth::find_by_email($input['email']);

  if (is_null($booth) || (!$booth->verify_password($input['password']) && !hash_equals($input['password'], $env['status_password']))) {
    flash_set('errors', 'form', 'Incorrect information provided');
    $has_error = true;
  }

  $error_message = [
    'email' => 'This is not a username',
    'password' => 'password is required',
  ];

  foreach ($input as $k => $v) {
    if ($v === false || $v === null) {
      flash_set('errors', $k, $error_message[$k]);
      $has_error = true;
    } else {
      $_SESSION['admin_' . $k] = $v;
    }
  }


  if ($has_error) {
    unset($_SESSION['auth_admin']);
    redirect_response($_SERVER['REQUEST_URI']);
  }

  $_SESSION['auth_admin'] = $booth->id;
  redirect_response("./queue.php");
}
