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
      <form action="#" method="post" x-data="{sel:[]}">
        <?= csrf_field() ?>

        <?php
        $timeslot_titles = ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th", "10th"];
        $timeslots = execute('SELECT timeslot_id as id, timestart, timeend FROM Timeslots')->fetchAll();
        $timeslots = array_map(function ($v) {
          return array_merge($v, [
            'start' => (new DateTime($v['timestart']))->format('M d h:ia'),
            'end' => (new DateTime($v['timeend']))->format('h:ia'),
          ]);
        }, $timeslots);

        $booths = execute('SELECT booth_id as id, topic from Booths')->fetchAll();

        foreach ($timeslots as $i => $t):
        ?>
          <div id="c_<?= $i ?>" class="card mb-4 shadow-sm" x-data="radio('c_<?= $i + 1 ?>')" x-modelable="opt" x-model="sel[<?= $i ?>]">
            <div class="card-header d-flex align-items-center">
              <span>
                <?= $timeslot_titles[$i] ?> Timeslot <em>(<?= $t['start'] ?> - <?= $t['end'] ?>)</em>
              </span>
              <button type="button" x-cloak :class="opt==null && 'opacity-0'" :tabindex="opt==null ? -1 : 0" @click="opt=null" class="btn btn-sm btn-outline-primary ms-auto">Clear</button>
            </div>
            <div class="card-body">
              <?php foreach ($booths as $j => $b): ?>
                <div class="form-check">
                  <input x-bind="input" x-model="opt" class="form-check-input" type="radio" name="booths[<?= $t['id'] ?>]" id="r_<?= $t['id'] ?>_<?= $b['id'] ?>" value="<?= $b['id'] ?>" required>
                  <label class="form-check-label" for="r_<?= $t['id'] ?>_<?= $b['id'] ?>">
                    <?= $b['topic'] ?>
                  </label>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        <?php endforeach ?>

        <div id="c_<?= count($timeslots) ?>" class="row px-3 gap-2">
          <button type="button" class="btn btn-primary col-auto">Prev</button>
          <button type="submit" class="btn btn-primary col-auto">Next</button>
          <button type="button" class="btn btn-outline-primary col-auto ms-auto" @click="sel=[]">Clear selection</button>
        </div>

      </form>
    </div>
  </main>

  <script>
  </script>
</body>

</html>
