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
      <form action="/?p=3" method="post">
        <?= csrf_field() ?>

        <?php
        $timeslot_titles = ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th", "10th"];
        $timeslots = execute('SELECT timeslot_id FROM Timeslots')->fetchAll(PDO::FETCH_COLUMN);

        $booths = execute('SELECT booth_id, topic from Booths')->fetchAll();

        foreach ($timeslots as $i => $timeslot_id):
        ?>
          <div class="card mb-4 shadow-sm">
            <div class="card-header">
              <?= $timeslot_titles[$i] ?> Timeslot
            </div>
            <div class="card-body">
              <?php foreach ($booths as $j => $b): ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="booths[<?= $timeslot_id ?>]" id="r_<?= $timeslot_id ?>_<?= $b['booth_id'] ?>" value="<?= $b['booth_id'] ?>" required>
                  <label class="form-check-label" for="r_<?= $timeslot_id ?>_<?= $b['booth_id'] ?>">
                    <?= $b['topic'] ?>
                  </label>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        <?php endforeach ?>

        <div class="row px-3 gap-2">
          <button type="submit" class="btn btn-primary col-auto">Prev</button>
          <button type="button" class="btn btn-primary col-auto">Next</button>
        </div>

      </form>
    </div>
  </main>
</body>

</html>
