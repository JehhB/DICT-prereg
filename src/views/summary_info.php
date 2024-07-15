<?php
$reg = Registration::find($_GET['s']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

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

<body>
  <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto my-4">

    <h1>
      Registration Summary
    </h1>

    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        Personal Info
      </div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-5 col-sm-4 col-md-3">Name</dt>
          <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($reg->name) ?></dd>

          <dt class="col-5 col-sm-4 col-md-3">Affiliation</dt>
          <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($reg->affiliation) ?></dd>

          <dt class="col-5 col-sm-4 col-md-3">Position</dt>
          <dd class="col-7 col-sm-8 col-md-9"><?= htmlspecialchars($reg->position) ?></dd>
        </dl>
      </div>
    </div>


    <div class="card mb-4 shadow-sm">
      <div class="card-header">
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
      <div class="card-header d-flex">
        <span>
          Booth schedule
        </span>
        <a href="<?= $_SERVER['REQUEST_URI'] ?>&edit" class="btn btn-sm btn-primary ms-auto">
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
              <?= $b['topic'] ?>
            </dd>
          <?php endforeach ?>
        </dl>
      </div>
    </div>
  </div>

</body>

</html>
