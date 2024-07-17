<?php
require_once __DIR__ . '/src/setup.php';

if (!isset($_GET['s'])) {
  error_get_last(404, 'You are lost, do you want to register');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!isset($_SESSION['auth_summary']) || $_SESSION['auth_summary'] != $_GET['s']) {
    include_once __DIR__ . '/src/views/summary_auth.php';
  } else if (isset($_GET['edit'])) {
    include_once __DIR__ . '/src/views/summary_edit.php';
  } else {
    include_once __DIR__ . '/src/views/summary_info.php';
    $reg = Registration::find($_GET['s']);
    execute('DELETE FROM Registrations WHERE registration_id = ?', [$reg->id]);
  }
  exit();
}


if (isset($_POST['login'])) {
  $reg = Registration::find($_GET['s']);

  $sanitize_filters = [
    'email' => FILTER_SANITIZE_EMAIL,
    'birthday' => FILTER_DEFAULT,
  ];

  $validate_filters = [
    'email' => FILTER_VALIDATE_EMAIL,
    'birthday' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']],
  ];

  $input = filter_var_array($_POST, $sanitize_filters);
  $input = filter_var_array($input, $validate_filters);
  $input = array_intersect_key($input, $validate_filters);

  $has_error = false;
  if ($reg->email != $input['email'] || $reg->birthday != $input['birthday']) {
    flash_set('errors', 'form', 'Incorrect information provided');
    $has_error = true;
  }

  $error_message = [
    'email' => 'This is not a valid email address',
    'birthday' => 'Invalid birthday',
  ];

  foreach ($input as $k => $v) {
    if ($v === false || $v === null) {
      flash_set('errors', $k, $error_message[$k]);
      $has_error = true;
    } else {
      $_SESSION['verify_' . $k] = $v;
    }
  }


  if ($has_error) {
    unset($_SESSION['auth_summary']);
    redirect_response($_SERVER['REQUEST_URI']);
  }

  $_SESSION['auth_summary'] = $_GET['s'];
  redirect_response($_SERVER['REQUEST_URI']);
}

if (isset($_POST['cancel'])) {
  redirect_response('./summary.php?s=' . $_GET['s']);
}

if (isset($_POST['save'])) {
  execute("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
  $db = getDB();

  try {
    $reg = Registration::find($_GET['s']);
    $current = $reg->get_registered_booths();

    $db->beginTransaction();

    $booths = [];
    foreach ($current as $b) {
      $booths[$b['timeslot_id']] = $_POST["booths"][$b['booth_registration_id']] ?? 0;
    }
    $count = BoothRegistration::count($booths);

    $has_errors = false;
    foreach ($count as $timeslot_id => $count) {
      if ($count >= 300) {
        $has_errors = true;
        flash_set('errors', $timeslot_id, 'Please choose another booth, no slots left');
      } else {
        $booth_registration = array_filter($current, function ($b) use ($timeslot_id) {
          return $b['timeslot_id'] == $timeslot_id;
        });
        if (count($booth_registration) == 0) continue;

        $id = array_pop($booth_registration)['booth_registration_id'];
        if (!isset($_POST["booths"][$id])) continue;

        execute('UPDATE BoothRegistration SET booth_id = ? WHERE registration_id = ? AND  timeslot_id = ?', [
          $_POST["booths"][$id],
          $reg->id,
          $timeslot_id
        ]);
      }
    }

    if ($has_errors) {
      $db->rollBack();
      redirect_response('./summary.php?s=' . $reg->slug . '&edit');
    }

    $db->commit();
    redirect_response('./summary.php?s=' . $reg->slug);
  } catch (Exception $e) {
    $db->rollBack();
    $_SESSION['fatal_error'] = ['code' => 500, 'message' => $e->getMessage()];
    redirect_response('./error.php');
  }

  redirect_response('./summary.php?s=' . $_GET['s']);
}

error_response();
