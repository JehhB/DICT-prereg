<?php

$pdo = getDB();

$stmtTopics = $pdo->prepare("SELECT DISTINCT topic FROM Booths ORDER BY topic ASC");
$stmtTopics->execute();
$topics = $stmtTopics->fetchAll(PDO::FETCH_COLUMN);

$stmtBooth = $pdo->prepare("SELECT booth_id FROM Booths WHERE topic = ?");
$params = [$_GET['report'] ?? ''];
$stmtBooth->execute($params);
$boothId = $stmtBooth->fetchAll(PDO::FETCH_COLUMN);

if (count($boothId) <= 0) {
  error_response(404, 'Not found');
}

// Get timeslots for this booth
$stmtTimeslots = $pdo->prepare("
        SELECT DISTINCT t.timeslot_id, t.timestart, t.timeend
        FROM Timeslots t
        ORDER BY t.timestart
    ");
$stmtTimeslots->execute();
$timeslots = $stmtTimeslots->fetchAll();

if (count($timeslots) <= 0) {
  error_response(404, 'Not found');
}

$timeslotId = $_GET['t'] ?? $timeslots[0]['timeslot_id'];

$sql = "
        SELECT r.*, br.timeslot_id
        FROM Registrations r
        JOIN BoothRegistration br ON r.registration_id = br.registration_id
        WHERE br.booth_id IN (" . placeholder($boothId) . ")  AND br.timeslot_id = ?
        ORDER BY r.registration_date
    ";
$params = array_merge($boothId, [$timeslotId]);
$stmtRegistrations = $pdo->prepare($sql);
$stmtRegistrations->execute($params);

?>
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
    <div class="row my-4 align-items-center">
      <h1 class="col">
        <?= $_GET['report'] ?> report
      </h1>

      <div class="dropdown ms-auto col-auto">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Select other booths
        </button>
        <ul class="dropdown-menu">
          <?php foreach ($topics as $t): ?>
            <li><a class="dropdown-item <?php if ($_GET['report'] == $t) echo 'active'; ?>" href="./status.php?report=<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <a href="./status.php?xlsx=<?= $_GET['report'] ?>" class="col-auto ms-3 btn btn-primary">Save spreadsheet</a>
    </div>

    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs flex-nowrap overflow-x-scroll overflow-y-hidden">
          <?php foreach ($timeslots as $t): ?>
            <li class="nav-item">
              <a class="nav-link no-wrap <?php if ($t['timeslot_id'] == $timeslotId) {
                                            echo 'active';
                                          } ?>" href="./status.php?report=<?= $_GET['report'] ?>&t=<?= $t['timeslot_id'] ?>">
                <small>
                  <?= (new DateTime($t['timestart']))->format('M d h:ia') ?>-<?= (new DateTime($t['timeend']))->format('h:ia') ?>
                </small>
              </a>
            </li>
          <?php endforeach ?>
        </ul>

        <div class="table-responsive no-wrap mt-5">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Birthday</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Affilation</th>
                <th>Position</th>
                <th>Description</th>
                <th>QR Code</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($reg = $stmtRegistrations->fetch()): ?>
                <tr>
                  <td><?= htmlspecialchars($reg['name']) ?></td>
                  <td>
                    <?= match ($reg['sex']) {
                      'M' => 'Male',
                      'F' => 'Female',
                      'OTHER' => 'Others',
                      'BLANK' => 'Prefer not to mention',
                    } ?>
                  </td>
                  <td><?= htmlspecialchars($reg['birthday']) ?></td>
                  <td><?= htmlspecialchars($reg['email']) ?></td>
                  <td><?= htmlspecialchars($reg['contact_number']) ?></td>
                  <td><?= htmlspecialchars($reg['affiliation']) ?></td>
                  <td><?= htmlspecialchars($reg['position']) ?></td>
                  <td><?= htmlspecialchars($reg['type']) ?></td>
                  <td>
                    <img width="48" height="48" src="<?= $reg['qr_code'] ?>">
                  </td>
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
