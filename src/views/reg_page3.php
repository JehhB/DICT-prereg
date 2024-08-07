<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>
  <?php include __DIR__ . '/assets.php' ?>
  <script src="/assets/cdn/signature_pad.umd.min.js"></script>
</head>

<body class="bg-light-subtle" x-data="attendance">

  <?php if (flash_has('errors', 'form')): ?>
    <div class="modal fade" tabindex="-1" x-data x-init="new bootstrap.Modal($el).show()">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><?= flash_get('errors', 'form') ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <div class="modal fade" tabindex="-1" id="privacy">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Privacy Notice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>
            (R.A. 10173): We need your personal data to provide verifiable evidence in support of this event and that you participated therein. We will include your data in our printed and electronic reports that we will send through secured channels.
          </p>
          <p>
            By signing herein, we will continuously keep your data under lock and key, and will limit their use to authorized staff. If you do not agree, please inform us and we will permanently destroy your data after we have sent our reports.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <main class="container my-3 my-sm-4">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto">
      <div class="card mb-3 shadow-sm" style="max-height: 250px;">
        <video autoplay loop muted playsinline>
          <source src="./assets/banner.mp4" type="video/mp4">
          Join DICT Career and Job Fair
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
              $timeslot_ids = array_keys($_SESSION['register_booths']);
              $placeholder = placeholder($timeslot_ids);

              $timeslots = execute("SELECT timeslot_id as id, timestart, timeend FROM Timeslots WHERE timeslot_id IN ($placeholder)", $timeslot_ids)->fetchAll();
              $timeslots = array_map(function ($v) {
                return array_merge($v, [
                  'start' => (new DateTime($v['timestart']))->format('H:i'),
                  'end' => (new DateTime($v['timeend']))->format('H:i'),
                ]);
              }, $timeslots);

              foreach ($timeslots as $t):
                $id = $_SESSION['register_booths'][$t['id']];
                $args = [':id' => $_SESSION['register_booths'][$t['id']]];
                $b = execute('SELECT * FROM Booths WHERE booth_id = :id', $args)->fetch();
                if (!$b) continue;
              ?>
                <dt class="col-5 col-sm-4 col-md-3"><?= $t['start'] ?>-<?= $t['end'] ?></dt>
                <dd class="col-7 col-sm-8 col-md-9">
                  <img src="<?= $b['logo'] ?>" alt="<?= htmlspecialchars($b['topic']) ?>" height="20px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?= htmlspecialchars($b['topic']) ?>">
                </dd>
              <?php endforeach ?>
            </dl>
          </div>

          <div class="row px-3">
            <div class="col-12 mb-3">
              <input type="hidden" name="signature" :value="signature">
              <label for="signature-pad" class="form-label">Signature</label>
              <div class="ratio ratio-2x1 mb-3">
                <canvas x-ref="canvas" id="signature-pad" class="form-control w-full h-full"></canvas>
              </div>
              <button type="button" class="btn btn-sm btn-secondary" @click="clear">Clear signature</button>
            </div>


            <small class="mb-3">
              By submitting this form, I agree to the collection and processing of my data stated in this
              <a role="button" class="btn-link" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#privacy">Privacy Notice</a>
            </small>
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
            <input type="hidden" name="signature" :value="signature">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
