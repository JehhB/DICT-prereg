<?php

require_once __DIR__ . '/src/setup.php';

if (isset($_GET['accept_data_privacy'])) {
  $_SESSION['register_privacy'] = true;
  http_response_code(200);
  exit();
}

$page = $_GET['p'] ?? 1;

function clear_registration()
{
  foreach (array_keys($_SESSION) as $k) {
    if (str_starts_with($k, 'register_')) unset($_SESSION[$k]);
  }
  unset($_SESSION['_PASSED_1']);
  unset($_SESSION['_PASSED_2']);
}

function handle_page_1()
{
  $sanitize_filters = [
    'email' => FILTER_SANITIZE_EMAIL,
    'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'position' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'sex' => FILTER_DEFAULT,
    'birthday' => FILTER_DEFAULT,
    'contact_number' => FILTER_DEFAULT,
    'affiliation' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'type' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'event_id' => FILTER_SANITIZE_NUMBER_INT,
    'is_indigenous' => FILTER_DEFAULT,
  ];

  $validate_filters = [
    'email' => FILTER_VALIDATE_EMAIL,
    'name' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
    'position' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
    'sex' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^(M|F|BLANK|OTHER)$/']],
    'birthday' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^\d{4}-\d{2}-\d{2}$/']],
    'contact_number' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^\d{10,}$/']],
    'affiliation' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
    'type' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/\S+/']],
    'event_id' => FILTER_VALIDATE_INT,
    'is_indigenous' => FILTER_VALIDATE_BOOLEAN,
  ];

  $input = filter_var_array($_POST, $sanitize_filters);
  $input = filter_var_array($input, $validate_filters);
  $input = array_intersect_key($input, $validate_filters);

  $error_message = [
    'email' => 'This is not a valid email address',
    'name' => 'Name must be provided',
    'position' => 'Position must be provided',
    'sex' => 'Invalid sex value',
    'birthday' => 'Invalid birthday',
    'contact_number' => 'Invalid contact number',
    'affiliation' => 'Affiliation must be provided',
    'type' => 'Description must be provided',
    'event_id' => 'Choose a valid event',
    'is_indigenous' => 'Choose a valid value',
  ];

  $has_error = false;
  foreach ($input as $k => $v) {
    if (($k !== "is_indigenous" && $v === false) || $v === null) {
      flash_set('errors', $k, $error_message[$k]);
      $has_error = true;
    } else {
      $_SESSION['register_' . $k] = $v;
    }
  }

  if (Registration::email_exist($input['email'])) {
    flash_set('errors', 'email', 'Email is already registered');
    $has_error = true;
  }

  if (is_null(Event::findValid($input['event_id']))) {
    flash_set('errors', 'event_id', "Event_doesn't exist");
    $has_error = true;
  }

  if ($has_error) {
    unset($_SESSION['_PASSED_1']);
    header('Location: ./?p=1');
    exit();
  }

  $_SESSION['_PASSED_1'] = true;
  redirect_response('./?p=2');
}

function handle_page_2()
{
  if (!isset($_SESSION['_PASSED_1'])) {
    flash_set('errors', 'form', 'No personal data provided');
    redirect_response('./?p=1');
  }

  if (isset($_POST['booths'])) {
    $booths = array_unique($_POST['booths']);
  } else {
    $booths = [];
  }

  $timeslots = execute(<<<SQL
      SELECT timeslot_id
      FROM Timeslots 
      WHERE event_id = ?
        AND DATE_ADD(timestart, INTERVAL 6 MINUTE) > ?
    SQL, [
    $_SESSION['register_event_id'],
    current_time(),
  ])->fetchAll(PDO::FETCH_COLUMN);
  $_SESSION['register_booths'] = $booths;

  $has_error = false;
  if (!is_array($booths) or count($booths) != count($timeslots)) {
    $has_error = true;
    $missing_keys = array_diff($timeslots, array_keys($booths));
    foreach ($missing_keys as $k) {
      flash_set('errors', $k, 'You must select a booth');
    }
  }

  $validBoothIds = execute("SELECT booth_id FROM Booths WHERE event_id = ?", [
    $_SESSION['register_event_id']
  ])->fetchAll(PDO::FETCH_COLUMN);
  foreach ($booths as $k => $id) {
    if (array_search((int)$id, $validBoothIds) === false) {
      $has_error = true;
      unset($_SESSION['register_booths'][$k]);
      flash_set('errors', $k, 'Unknown booth selected');
    }
  }

  $count = BoothRegistration::count($booths);
  foreach ($count as $k => $v) {
    if ($v >= MAX_SLOTS) {
      $has_error = true;
      unset($_SESSION['register_booths'][$k]);
      flash_set('errors', $k, 'Please choose another booth, no slots left');
    }
  }


  if ($has_error) {
    unset($_SESSION['_PASSED_2']);
  } else {
    $_SESSION['_PASSED_2'] = true;
  }

  if (isset($_POST['prev'])) redirect_response('./?p=1');
  if ($has_error) redirect_response('./?p=2');
  redirect_response('./?p=3');
}

function handle_page_3()
{

  if (isset($_POST['prev'])) redirect_response('./?p=2');
  if (!isset($_SESSION['_PASSED_1'])) redirect_response('./?p=1');
  if (!isset($_SESSION['_PASSED_2'])) redirect_response('./?p=2');

  if (!isset($_POST['signature']) or strlen($_POST['signature']) == 0) {
    flash_set('errors', 'form', 'You must affix your signature');
    redirect_response('./?p=3');
  }

  // Stop other operation in the database to avoid exceeding the limit
  execute("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
  $db = getDB();
  try {
    $db->beginTransaction();

    $reg = Registration::insert(
      $_SESSION['register_name'],
      $_SESSION['register_email'],
      $_SESSION['register_position'],
      $_SESSION['register_sex'],
      $_SESSION['register_birthday'],
      $_SESSION['register_contact_number'],
      $_SESSION['register_affiliation'],
      $_SESSION['register_type'],
      $_SESSION['register_event_id'],
      $_SESSION['register_is_indigenous']
    );

    execute('INSERT INTO Attendances (registration_id, signature, is_walkin) VALUES (?,?, TRUE)', [
      $reg->id,
      $_POST['signature'],
    ]);

    $reg->register_booths($_SESSION['register_booths']);
    $db->commit();

    async_send_email($reg->slug);
    clear_registration();
    $_SESSION['auth_summary'] = $reg->slug;
    redirect_response('./summary.php?s=' . $reg->slug);
  } catch (Exception $e) {
    $db->rollBack();
    $_SESSION['fatal_error'] = ['code' => 500, 'message' => $e->getMessage()];
    echo $e->getMessage();
    exit();
    redirect_response('./error.php');
  }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($page == 1) {
    handle_page_1();
  } else if ($page == 2) {
    handle_page_2();
  } else if ($page == 3) {
    handle_page_3();
  }

  error_response(400, "Error 400: Bad request");
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
