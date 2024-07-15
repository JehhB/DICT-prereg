<!DOCTYPE htmln>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="./assets/style.css">
  <script src="./assets/script.js"></script>
</head>

<body class="bg-light-subtle">
  <div class="container">
    <div class="row align-items-center justify-content-center" style="height: 100vh;">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card mt-5 shadow-sm">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Verify it's you</h3>
              <form action="#" method="post" class="row" novalidate>
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
                  <label for="birhtday">Birthday</label>
                  <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday" required @input="valid = $el.checkValidity()">

                  <?php if (flash_has('errors', 'birthday')): ?>
                    <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'birthday') ?></strong>
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
