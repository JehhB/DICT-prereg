<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>
  <?php include __DIR__ . '/assets.php' ?>
  <script>
    $(document).ready(async function() {
      window.scrollTo(0, 0);
      $c = $('#cursor');
      cc('cursor');
      await sleep(1000);
      $modal = $('[data-bs-toggle="modal"]')
      await scrollToView($modal)
      await click($modal);
      await sleep(500);
      await click($('input[type="submit"][name="submit"]'));

      $('#annotate').hide();
    });
  </script>
</head>

<body class="bg-light-subtle">
  <div style="z-index: 2000; position: fixed; inset: 0; " id="annotate">
    <div id="cursor">
      <svg id="cursor-i" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="24" height="24" style="position:absolute"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M.1 29.3C-1.4 47 11.7 62.4 29.3 63.9l8 .7C70.5 67.3 96 95 96 128.3L96 224l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 95.7c0 33.3-25.5 61-58.7 63.8l-8 .7C11.7 449.6-1.4 465 .1 482.7s16.9 30.7 34.5 29.2l8-.7c34.1-2.8 64.2-18.9 85.4-42.9c21.2 24 51.2 40 85.4 42.9l8 .7c17.6 1.5 33.1-11.6 34.5-29.2s-11.6-33.1-29.2-34.5l-8-.7C185.5 444.7 160 417 160 383.7l0-95.7 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-95.7c0-33.3 25.5-61 58.7-63.8l8-.7c17.6-1.5 30.7-16.9 29.2-34.5S239-1.4 221.3 .1l-8 .7C179.2 3.6 149.2 19.7 128 43.7c-21.2-24-51.2-40-85.4-42.9l-8-.7C17-1.4 1.6 11.7 .1 29.3z" />
      </svg>
      <svg id="cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24" style="position: absolute"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M128 40c0-22.1 17.9-40 40-40s40 17.9 40 40l0 148.2c8.5-7.6 19.7-12.2 32-12.2c20.6 0 38.2 13 45 31.2c8.8-9.3 21.2-15.2 35-15.2c25.3 0 46 19.5 47.9 44.3c8.5-7.7 19.8-12.3 32.1-12.3c26.5 0 48 21.5 48 48l0 48 0 16 0 48c0 70.7-57.3 128-128 128l-16 0-64 0-.1 0-5.2 0c-5 0-9.9-.3-14.7-1c-55.3-5.6-106.2-34-140-79L8 336c-13.3-17.7-9.7-42.7 8-56s42.7-9.7 56 8l56 74.7L128 40zM240 304c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96zm48-16c-8.8 0-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96c0-8.8-7.2-16-16-16zm80 16c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96z" />
      </svg>
      <svg id="cursor-cursor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="24" height="24" style="position: absolute;"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M0 55.2L0 426c0 12.2 9.9 22 22 22c6.3 0 12.4-2.7 16.6-7.5L121.2 346l58.1 116.3c7.9 15.8 27.1 22.2 42.9 14.3s22.2-27.1 14.3-42.9L179.8 320l118.1 0c12.2 0 22.1-9.9 22.1-22.1c0-6.3-2.7-12.3-7.4-16.5L38.6 37.9C34.3 34.1 28.9 32 23.2 32C10.4 32 0 42.4 0 55.2z" />
      </svg>
    </div>
  </div>

  <main class="container my-3 my-sm-4">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto">
      <div class="card mb-3 shadow-sm" style="max-height: 250px;">
        <video autoplay loop muted playsinline>
          <source src="./assets/banner.mp4" type="video/mp4">
          Join DICT HIMS Career and Job Fair
        </video>
      </div>

      <h1>
        DICT Event Preregistration
      </h1>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-secondary">
            Registration Summary
          </div>
          <div class="card-body">
            <p class="alert alert-info">
              Please review your registration details carefully. You are not allowed to modify your personal details afterwards.
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
              <dt class="col-5 col-sm-4 col-md-3">Affiliation</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_affiliation'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Position</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_position'] ?? '') ?></dd>

              <dt class="col-5 col-sm-4 col-md-3">Type</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($_SESSION['register_type'] ?? '') ?></dd>
            </dl>

            <h5 class="mb-3">Event Registration Details</h5>
            <dl class="row">
              <?php $event =  Event::find($_SESSION['register_event_id']) ?>
              <dt class="col-5 col-sm-4 col-md-3">Event Name</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($event->event_name) ?></dd>
              <dt class="col-5 col-sm-4 col-md-3">Event Venue</dt>
              <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($event->event_venue) ?></dd>
            </dl>

            <h5 class="mb-3">Booth schedule</h5>
            <dl class="row">
              <?php
              $timeslots = execute('SELECT timeslot_id as id, timestart, timeend FROM Timeslots WHERE event_id = ?', [
                $_SESSION['register_event_id']
              ])->fetchAll();
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
