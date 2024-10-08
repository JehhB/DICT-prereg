<?php
$timeslots = execute(<<<SQL
    SELECT timeslot_id as id, timestart, timeend
    FROM Timeslots 
    WHERE event_id = ?
      AND DATE_ADD(timestart, INTERVAL 6 MINUTE) > ?
  SQL, [
  $_SESSION['register_event_id'],
  current_time(),
])->fetchAll();

if (count($timeslots) == 0) {
  flash_set('errors', 'form', 'No available timeslots');
  redirect_response('./?p=1');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>

  <?php include __DIR__ . '/assets.php' ?>

  <script id="init-data" type="application/json">
    <?php
    $count = BoothRegistration::count_summary();
    $count['_MAX_SLOTS'] = MAX_SLOTS;
    echo json_encode($count);
    ?>
  </script>
</head>

<body class="bg-light-subtle">

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
      <form action="#" method="post" x-data="form('init-data')">
        <?= csrf_field() ?>

        <?php
        $timeslot_titles = ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th", "10th"];

        $timeslots = array_map(function ($v) {
          return array_merge($v, [
            'start' => (new DateTime($v['timestart']))->format('M d h:ia'),
            'end' => (new DateTime($v['timeend']))->format('h:ia'),
          ]);
        }, $timeslots);

        $booths = execute('SELECT booth_id as id, topic, logo from Booths WHERE event_id = ? ORDER BY topic ASC', [
          $_SESSION['register_event_id']
        ])->fetchAll();
        $count = BoothRegistration::count_summary();


        foreach ($timeslots as $i => $t):
        ?>
          <div
            data-radio-timeslot="<?= $t['id'] ?>"
            id="c_<?= $i ?>"
            class="card mb-4 shadow-sm"
            <?php if (isset($_SESSION['register_booths'][$t['id']])) : ?>
            x-data="radio('c_<?= $i + 1 ?>', '<?= $_SESSION['register_booths'][$t['id']] ?>')"
            <?php else: ?>
            x-data="radio('c_<?= $i + 1 ?>')"
            <?php endif ?>
            x-modelable="opt"
            x-model="sel[<?= $i ?>]">
            <div class="card-header bg-secondary d-flex align-items-center">
              <span>
                <?= $timeslot_titles[$i] ?> Timeslot <em>(<?= $t['start'] ?> - <?= $t['end'] ?>)</em>
              </span>
              <button type="button" x-cloak :class="opt==null && 'opacity-0'" :tabindex="opt == null ? -1 : 0" @click="opt=null" class="btn btn-sm btn-outline-primary ms-auto">Clear</button>
            </div>
            <div class="card-body">
              <?php foreach ($booths as $j => $b):
              ?>
                <div class="form-check d-flex mb-2 align-items-center">
                  <input
                    data-radio-booth="<?= $b['id'] ?>"
                    x-bind="input"
                    x-model.fill="opt"
                    class="form-check-input"
                    type="radio"
                    name="booths[<?= $t['id'] ?>]" id="r_<?= $t['id'] ?>_<?= $b['id'] ?>"
                    value="<?= $b['id'] ?>"
                    required>
                  <label class="ms-2 form-check-label d-block" for="r_<?= $t['id'] ?>_<?= $b['id'] ?>">
                    <img src="<?= $b['logo'] ?>" alt="<?= htmlspecialchars($b['topic']) ?>" height="20px" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="<?= htmlspecialchars($b['topic']) ?>">
                  </label>
                  <small class="ms-auto" x-text="format('<?= $t['id'] ?>', '<?= $b['id'] ?>')">
                  </small>
                </div>
              <?php endforeach ?>
              <?php if (flash_has('errors', $t['id'])): ?>
                <strong x-transition x-show.important="opt==null" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', $t['id']) ?></strong>
              <?php endif ?>
            </div>
          </div>
        <?php endforeach ?>

        <div id="c_<?= count($timeslots) ?>" class="row px-3 gap-2">
          <input type="submit" @click="$root.noValidate = true" name="prev" class="btn btn-primary col-auto" value="Prev">
          <input type="submit" @click="$root.noValidate = false" name="next" class="btn btn-primary col-auto" value="Next">
          <button type="button" class="btn btn-outline-primary col-auto ms-auto" @click="sel=[]">Clear selection</button>
        </div>

      </form>
    </div>
  </main>

  <script>
  </script>
</body>

</html>
