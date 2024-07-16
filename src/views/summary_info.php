<?php
$reg = Registration::find($_GET['s']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php include __DIR__ . '/assets.php' ?>
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
