<?php
$reg = Registration::find($_SESSION['auth_summary']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>
  <?php include __DIR__ . '/assets.php' ?>
</head>

<body>
  <div class="container">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto my-4">
      <div class="row">
        <h1>
          Registration Summary
        </h1>
      </div>

      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary d-flex">
          Personal Info
          <a href="./summary.php?logout=logout" class="ms-auto col-auto btn btn-primary btn-sm">Logout</a>
        </div>
        <div class="card-body">
          <div class="row">
            <img src="<?= $reg->qr_code ?>" alt="QrCode for your id number <?= $reg->slug ?>" class="col-6 mx-auto mb-4 col-sm-5 col-md-3 col-lg-3 mb-md-0">
            <dl class="row mb-0 col-12 col-md-9">
              <dt class="col-5 col-sm-4">Name</dt>
              <dd class="col-7 col-sm-8"><?= htmlspecialchars($reg->name) ?></dd>

              <dt class="col-5 col-sm-4">Registration ID</dt>
              <dd class="col-7 col-sm-8"><?= htmlspecialchars($reg->slug) ?></dd>

              <dt class="col-5 col-sm-4">Affiliation</dt>
              <dd class="col-7 col-sm-8"><?= htmlspecialchars($reg->affiliation) ?></dd>

              <dt class="col-5 col-sm-4">Position</dt>
              <dd class="col-7 col-sm-8"><?= htmlspecialchars($reg->position) ?></dd>
            </dl>
          </div>
        </div>
      </div>


      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary">
          Event Registration Details
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <?php $event =  Event::find($reg->event_id) ?>
            <dt class="col-5 col-sm-4 col-md-3">Event Name</dt>
            <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($event->event_name) ?></dd>

            <dt class="col-5 col-sm-4 col-md-3">Event Venue</dt>
            <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($event->event_venue) ?></dd>
          </dl>
        </div>
      </div>

      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary d-flex">
          <span>
            Booth schedule
          </span>
          <a href="./summary.php?edit" class="btn btn-sm btn-primary ms-auto">
            Edit
          </a>
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <?php
            $booths = $reg->get_registered_booths();
            $booths = array_map(function ($v) {
              return array_merge($v, [
                'start' => (new DateTime($v['timestart']))->format('H:i'),
                'end' => (new DateTime($v['timeend']))->format('H:i'),
              ]);
            }, $booths);

            foreach ($booths as $b):
            ?>
              <dt class="col-5 col-sm-4 col-md-3"><?= $b['start'] ?>-<?= $b['end'] ?></dt>
              <dd class="col-7 col-sm-8 col-md-9">
                <img src="<?= $b['logo'] ?>" alt="<?= htmlspecialchars($b['topic']) ?>" height="20px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?= htmlspecialchars($b['topic']) ?>">
              </dd>
            <?php endforeach ?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
