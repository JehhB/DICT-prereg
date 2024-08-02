<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistics</title>
  <?php include __DIR__ . '/assets.php' ?>
</head>

<body>
  <div class="container">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto my-4">
      <div class="row">
        <h1>
          Registration Statistics
        </h1>
      </div>

      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary d-flex">
          Event statistics
          <a href="./status.php?logout=logout" class="ms-auto col-auto btn btn-primary btn-sm">Logout</a>
        </div>
        <div class="card-body">
          <div class="row">
            <dl class="row mb-0 col-12 col-md-9">
              <?php
              $sql = 'SELECT 
                          e.event_name,
                          COUNT(r.registration_id) AS registration_count
                      FROM 
                          Event e
                      LEFT JOIN 
                          Registrations r ON e.event_id = r.event_id
                      GROUP BY 
                          e.event_name';

              $event_count = execute($sql)->fetchAll();
              foreach ($event_count as $c):
              ?>
                <dt class="col-8 col-sm-9"><?= htmlspecialchars($c['event_name']) ?></dt>
                <dd class="col-4 col-sm-3"><?= $c['registration_count'] ?>/<?= MAX_SLOTS ?> </dd>
              <?php endforeach ?>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
