<?php

require_once __DIR__ . '/src/setup.php';

$page = $_GET['p'] ?? 1;

function bad_request()
{
  http_response_code(400);
  exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // store values into session

  if ($page == 2) {
  } else if ($page == 3) {
    // validate_choices
    if (!isset($_POST['booths'])) bad_request();
    $booths  = $_POST['booths'];

    $countTimeslots = execute("SELECT COUNT(*) FROM Timeslots")->fetchColumn();
    if (!is_array($booths) and count($booths) != $countTimeslots) bad_request();

    $validBoothIds = execute("SELECT booth_id FROM Booths")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($booths as $id) {
      if (!array_search($id, $validBoothIds)) bad_request();
    }
    $_SESSION['booths'] = $booths;
  };

  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit();
}

if ($page == 2) {
  include __DIR__ . '/src/slots.php';
} else {
  include __DIR__ . '/src/personal_info.php';
}
