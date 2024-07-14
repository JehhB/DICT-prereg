<?php

require_once __DIR__ . '/src/setup.php';

define('MAX_SLOTS', 2);

$page = $_GET['p'] ?? 1;

function bad_request()
{
  http_response_code(400);
  echo "<strong>Error 400: Bad request</strong>";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($page == 1) {
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
      } else {
        $_SESSION['register_' . $k] = $v;
      }
    }

    $stmt = execute('SELECT * FROM Registrations WHERE email = ?', [$input['email']]);
    if ($stmt->fetch() !== false) {
      flash_set('errors', 'email', 'Email is already registered');
      $has_error = true;
    }

    if ($has_error) {
      unset($_SESSION['_PASSED_1']);
      header('Location: ./?p=1');
      exit();
    }

    $_SESSION['_PASSED_1'] = true;
    header('Location: ./?p=2');
    exit();
  } else if ($page == 2) {
    // Check if there is valid personal info
    if (!isset($_SESSION['_PASSED_1'])) {
      flash_set('errors', 'form', 'No personal data provided');
      header('Location: ./?p=1');
      exit();
    }

    if (isset($_POST['booths'])) {
      $booths = array_unique($_POST['booths']);
    } else {
      $booths = [];
    }

    // Check if there is valid booth selection is given
    $timeslots = execute("SELECT timeslot_id FROM Timeslots")->fetchAll(PDO::FETCH_COLUMN);
    $_SESSION['register_booths'] = $booths;

    $has_error = false;
    if (!is_array($booths) or count($booths) != count($timeslots)) {
      $has_error = true;
      $missing_keys = array_diff($timeslots, array_keys($booths));
      foreach ($missing_keys as $k) {
        flash_set('errors', $k, 'You must select a booth');
      }
    }


    $validBoothIds = execute("SELECT booth_id FROM Booths")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($booths as $k => $id) {
      if (array_search((int)$id, $validBoothIds) === false) {
        $has_error = true;
        flash_set('errors', $k, 'Unknown booth selected');
      }
    }

    if ($has_error) {
      unset($_SESSION['_PASSED_2']);
    } else {
      $_SESSION['_PASSED_2'] = true;
    }

    if (isset($_POST['prev'])) header('Location: ./?p=1');
    else if ($has_error) header('Location: ./?p=2');
    else header('Location: ./?p=3');
    exit();
  } else if ($page == 3) {
    if (isset($_POST['prev'])) {
      header('Location: ./?p=2');
      exit();
    }
    if (!isset($_SESSION['_PASSED_1'])) {
      header('Location: ./?p=1');
      exit();
    }
    if (!isset($_SESSION['_PASSED_2'])) {
      header('Location: ./?p=2');
      exit();
    }


    // Stop other operation in the database to avoid exceeding the limit
    execute("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    $db = getDB();
    try {
      $db->beginTransaction();

      execute(
        "INSERT INTO Registrations (name, email, organization, position) VALUES (?, ?, ?, ?)",
        [$_SESSION['register_name'], $_SESSION['register_email'], $_SESSION['register_organization'], $_SESSION['register_position']]
      );
      $registration_id = $db->lastInsertId();

      $count_stmt = $db->prepare("
              SELECT COUNT(*) as count 
              FROM BoothRegistration 
              WHERE timeslot_id = :timeslot_id AND booth_id = :booth_id
      ");
      $insert_stmt = $db->prepare("
          INSERT INTO BoothRegistration (registration_id, timeslot_id, booth_id)
          VALUES (:registration_id, :timeslot_id, :booth_id);
      ");

      $has_errors = false;
      foreach ($_SESSION['register_booths'] as $timeslot_id => $booth_id) {
        $args = [
          ':timeslot_id' => $timeslot_id,
          ':booth_id' => $booth_id,
        ];
        $count_stmt->execute($args);

        if ($count_stmt->fetchColumn() < MAX_SLOTS) {
          $args[':registration_id'] = $registration_id;
          $insert_stmt->execute($args);
        } else {
          flash_set('errors', $timeslot_id, 'Please choose another booth, no slots left');
          unset($_SESSION['register_booths'][$timeslot_id]);
          $has_errors = true;
        }
      }

      if ($has_errors) {
        $db->rollBack();
        unset($_SESSION['_PASSED_2']);
        header('Location: ./?p=2');
        exit();
      }

      $db->commit();

      foreach (array_keys($_SESSION) as $k) {
        if (str_starts_with($k, 'register_')) unset($_SESSION[$k]);
      }
      unset($_SESSION['_PASSED_1']);
      unset($_SESSION['_PASSED_2']);

      header('Location: ./?p=1');
      exit();
    } catch (Exception $e) {
      $db->rollBack();
      $_SESSION['fatal_error'] = ['code' => 500, 'message' => $e->getMessage()];
      header('Location: /error.php');
      exit();
    }


    var_dump($_SESSION);
    exit();
  }

  bad_request();
}

if ($page == 1) {
  include __DIR__ . '/src/views/reg_page1.php';
  exit();
}

if (!isset($_SESSION['_PASSED_1'])) {
  flash_set('errors', 'form', 'No personal data provided');
  header('Location: ./?p=1');
  exit();
}

if ($page == 2) {
  include __DIR__ . '/src/views/reg_page2.php';
  exit();
}

if (!isset($_SESSION['_PASSED_2'])) {
  flash_set('errors', 'form', 'Please choose your schedule');
  header('Location: ./?p=2');
  exit();
}

if ($page == 3) {
  include __DIR__ . '/src/views/reg_page3.php';
  exit();
}

header('Location: ./?p=3');
