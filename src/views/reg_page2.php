<?php
unset($_SESSION['register_booths']);
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
  <script>
    $(document).ready(async function() {

      window.scrollTo(0, 0);
      $c = $('#cursor');
      cc('cursor');
      await sleep(500);

      $l1 = $('label[for="r_8_8"]');
      await goto($l1);
      await gsap.to($c, {
        duration: 0.250,
        x: "+=50",
        yoyo: true,
        repeat: 1,
        transformOrigin: "0 0"
      });
      await goto($l1.next());
      await sleep(500);

      await click($('#r_8_9'));
      await sleep(500);

      $l2 = $('label[for="r_9_9"]');
      await goto($l2);
      await gsap.to($c, {
        duration: 0.250,
        x: "+=50",
        yoyo: true,
        repeat: 1,
        transformOrigin: "0 0"
      });
      await sleep(500);

      await click($('#r_9_10'));
      $c1 = $('#c_1')
      await sleep(720);
      await scrollToView($c1);
      await click($c1.find('button'));
      await sleep(500)
      await click($('#r_9_8'));
      await sleep(500)

      await click($('#r_10_13'), 250);
      await sleep(500)
      await click($('#r_11_14'), 250);
      await sleep(500)
      await click($('#r_12_11'), 250);
      await sleep(500)
      await click($('#r_13_10'), 250);
      await sleep(500)
      await click($('#r_14_12'), 250);
      await sleep(500)
      await click($('input[type="submit"][name="next"]'));

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
        $timeslots = execute('SELECT timeslot_id as id, timestart, timeend FROM Timeslots WHERE event_id = ?', [
          $_SESSION['register_event_id']
        ])->fetchAll();

        $timeslots = array_map(function ($v) {
          return array_merge($v, [
            'start' => (new DateTime($v['timestart']))->format('M d h:ia'),
            'end' => (new DateTime($v['timeend']))->format('h:ia'),
          ]);
        }, $timeslots);

        $booths = execute('SELECT booth_id as id, topic, logo from Booths WHERE event_id = ?', [
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
