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
  <title>Oops!</title>
  <?php include __DIR__ . '/src/views/assets.php' ?>
  <style>
    .error-template {
      padding: 40px 15px;
      text-align: center;
    }

    .error-actions {
      margin-top: 15px;
      margin-bottom: 15px;
    }

    .error-actions .btn {
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="error-template">
          <h1>
            Oops!</h1>
          <h2>Error <?= $err_code ?></h2>
          <div class="error-details">
            <?php
            echo $_SESSION['fatal_error']['message'] ?? 'Error 500: Internal server error';
            unset($_SESSION['fatal_error']);
            ?>
          </div>
          <div class="error-actions">
            <a href="./" class="btn btn-primary btn-lg"> Take Me Home </a>
            <a href="https://www.facebook.com/DICTCagayanValley" class="btn btn-outline-primary btn-lg"> Contact Support </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
