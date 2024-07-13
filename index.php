<?php

require_once __DIR__ . '/src/setup.php';

$page = $_GET['p'] ?? 1;

function bad_request()
{
  http_response_code(400);
  exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($page == 2) {
    // sanitize and validate input
    $sanitize_filters = [
      'email' => FILTER_SANITIZE_EMAIL,
      'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'organization' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'position' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $validate_filters = [
      'email' => FILTER_VALIDATE_EMAIL,
      'name' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
      'organization' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
      'position' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
    ];

    $input = filter_var_array($_POST, $sanitize_filters);
    $input = filter_var_array($input, $validate_filters);
    $input = array_intersect_key($input, $validate_filters);

    $error_message = [
      'email' => 'This is not a valid email address',
      'name' => 'Name must be provided',
      'organization' => 'Organization name must be provided',
      'position' => 'Position must be provided',
    ];

    // Redirect to first page if invalid input
    $has_error = false;
    foreach ($input as $k => $v) {
      if (!$v) {
        flash_set('errors', $k, $error_message[$k]);
        $has_error = true;
      }
    }
    if ($has_error) {
      header('Location: ./?p=1');
      exit();
    }

    foreach ($input as $k => $v) {
      $_SESSION['register_' . $k] = $v;
    }
  } else if ($page == 3) {
    // Check if there is valid personal info
    if (!isset($_SESSION['_PASSED_1'])) {
      flash_set('errors', 'form', 'No personal data provided');
      header('Location: ./?p=1');
      exit();
    }

    // Check if there is valid booth selection is given
    if (!isset($_POST['booths'])) bad_request();
    $booths = array_unique($_POST['booths']);
    $countTimeslots = execute("SELECT COUNT(*) FROM Timeslots")->fetchColumn();
    if (!is_array($booths) or count($booths) != $countTimeslots) bad_request();


    $validBoothIds = execute("SELECT booth_id FROM Booths")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($booths as $id) {
      // should only be allowed to pass booth id
      if (!array_search($id, $validBoothIds)) bad_request();
    }
    $_SESSION['register_booths'] = $booths;
  };


  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit();
}

if ($page == 2) {
  include __DIR__ . '/src/slots.php';
} else {
  include __DIR__ . '/src/personal_info.php';
}
