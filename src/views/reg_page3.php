<!DOCTYPE html>
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

  <main class="container my-3 my-sm-4">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto">
      <div class="card mb-3 shadow-sm">
        <img src="https://placehold.co/970x250.png?text=Banner+Image" class="card-img-top" alt="Banner">
      </div>

      <h1>
        DICT Event Preregistration
      </h1>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            Registration Summary
          </div>
          <div class="card-body">
            <p class="alert alert-info">
              Please review your registration details carefully. You are not allowed to modify it afterwards.
            </p>

            <h5 class="mb-3">Personal Info</h5>
            <dl class="row">
              <dt class="col-5 col-sm-4 col-md-3">Name</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_name'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Email</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_email'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Birthday</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_birthday'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Sex</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= isset($_SESSION['register_sex']) ? ($_SESSION['register_sex'] === 'M' ? 'Male' : 'Female') : '' ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Contact Number</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_contact_number'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Belong to indigenous group</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= isset($_SESSION['register_is_indigenous']) && $_SESSION['register_is_indigenous'] ? 'Yes' : 'No' ?></dd>
            </dl>

            <h5 class="mb-3">Professional Info</h5>
            <dl class="row">
              <dt class="col-5 col-sm-4 col-md-3">Organization</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_organization'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Position</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_position'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Type</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_type'] ?? '') ?></dd>
            </dl>

            <h5 class="mb-3">Event Registration Details</h5>
            <dl class="row">
              <dt class="col-5 col-sm-4 col-md-3">Event Name</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['event_name'] ?? '') ?></dd>
              <dt class="col-5 col-sm-4 col-md-3">Event Venue</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['event_venue'] ?? '') ?></dd>
            </dl>

            <h5 class="mb-3">Booth schedule</h5>
            <dl class="row">
              <?php
              $timeslots = execute('SELECT timeslot_id as id, timestart, timeend FROM Timeslots')->fetchAll();
              $timeslots = array_map(function ($v) {
                return array_merge($v, [
                  'start' => (new DateTime($v['timestart']))->format('H:i'),
                  'end' => (new DateTime($v['timeend']))->format('H:i'),
                ]);
              }, $timeslots);

              foreach ($timeslots as $t):
              ?>
                <dt class="col-5 col-sm-4 col-md-3"><?= $t['start'] ?>-<?= $t['end'] ?></dt>
                <dd class="col-7 col-sm-8 col-md-9">
                  <?php
                  $id = $_SESSION['register_booths'][$t['id']];
                  $args = [':id' => $_SESSION['register_booths'][$t['id']]];
                  $stmt = execute('SELECT topic FROM Booths WHERE booth_id = :id', $args);
                  echo $stmt->fetchColumn();
                  ?>
                </dd>
              <?php endforeach ?>
            </dl>
          </div>
        </div>

        <div class="row px-3">
          <input type="submit" name="prev" class="btn btn-primary col-auto" value="Prev">
          <button type="button" class="ms-auto btn btn-success col-auto" data-bs-toggle="modal" data-bs-target="#confirmationModal">
            Submit
          </button>
        </div>
      </form>
    </div>
  </main>

  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalTitle">Continue registration</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>
            You have verified that the information provided were correct and want to continue registering
          </p>
        </div>
        <div class="modal-footer">
          <form action="#" method="post">
            <?= csrf_field() ?>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
