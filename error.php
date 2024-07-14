<?php
require_once __DIR__ . '/src/setup.php';

$err_code = $_SESSION['fatal_error']['code'] ?? 500;
http_response_code($err_code);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div>
    <strong>
      <?php
      echo $_SESSION['fatal_error']['message'] ?? 'Error 500: Internal server error';
      unset($_SESSION['fatal_error']);
      ?>
    </strong>
  </div>
  <a href="/">Return home</a>
</body>

</html>
