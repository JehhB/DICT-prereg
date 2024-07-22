<!DOCTYPE htmln>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>

  <?php include __DIR__ . '/assets.php' ?>
</head>

<body class="bg-light-subtle">
  <div class="container">
    <div class="row align-items-center justify-content-center" style="height: 100vh;">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card mt-5 shadow-sm">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Login</h3>
              <form action="#" method="post" class="row">
                <?= csrf_field() ?>
                <div class="form-group mb-3" x-data="{valid:false}">
                  <?php if (flash_has('errors', 'form')): ?>
                    <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'form') ?></strong>
                  <?php endif ?>

                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required @input="valid = $el.checkValidity()">

                  <?php if (flash_has('errors', 'email')): ?>
                    <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'email') ?></strong>
                  <?php endif ?>
                </div>
                <div class="form-group mb-3" x-data="{valid:false}">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required @input="valid = $el.checkValidity()">

                  <?php if (flash_has('errors', 'password')): ?>
                    <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'password') ?></strong>
                  <?php endif ?>
                </div>
                <input type="submit" name="login" class="mx-auto col-auto btn btn-primary btn-block px-5" value="Continue">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
