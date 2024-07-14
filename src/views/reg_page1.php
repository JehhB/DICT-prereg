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

  <?php if (flash_has('errors', 'form')): ?>
    <div class="modal fade" tabindex="-1" x-data x-init="new bootstrap.Modal($el).show()">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
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
      <div class="card mb-3 shadow-sm">
        <img src="https://placehold.co/970x250.png?text=Banner+Image" class="card-img-top" alt="Banner">
      </div>

      <h1>
        DICT Event Preregistration
      </h1>
      <form action="#" method="post">
        <?= csrf_field() ?>
        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            Personal Details
          </div>
          <div class="card-body">
            <div x-data="{valid:false}" class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" required @input="$el.checkValidity()">
              <?php if (flash_has('errors', 'name')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'name') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'email')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'email') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="organization" class="form-label">Organization</label>
              <input type="text" class="form-control" id="organization" name="organization" required @input="valid=$el.checkValidity()" autocomplete="off">
              <?php if (flash_has('errors', 'organization')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'organization') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}">
              <label for="position" class="form-label">Position</label>
              <input type="text" class="form-control" id="position" name="position" required @input="valid=$el.checkValidity()" autocomplete="off">
              <?php if (flash_has('errors', 'position')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'position') ?></strong>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-header">
            Data Privacy Context
          </div>
          <div class="card-body">
            <p>
              DATA PRIVACY CONTENT
              The DICT recognizes their responsibilities under the <strong>Republic Act No. 10173 (Act)</strong>, also
              known as the <strong>Data Privacy Act of 2012</strong>. The personal data obtained from this form is
              analyzed, entered, and stored within the Department’s authorized information and communications system and
              will only be accessed by the <strong>*DICT UNIT NAME*</strong> authorized personnel. The <strong>*DICT
                UNIT NAME*</strong> Team has instituted appropriate organizational, technical, and physical security
              measures to ensure the protection of the participants’ personal data.
            </p>
            <p>
              By selecting <strong>"I Agree,"</strong> I am providing consent to the <strong>DICT</strong> and
              <strong>*DICT UNIT NAME*</strong> to gather and process my information for my participation in this
              training. <strong>My details will not be disclosed to any third-party organizations or affiliates of
                DICT and its partners</strong>. The information will be exclusively utilized for reporting
              quantitative data of attendees and sending invitations for participation in the specified activity.
            </p>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="privacyAgree" required>
              <label class="form-check-label" for="privacyAgree">
                I Agree
              </label>
            </div>
          </div>
        </div>

        <div class="row px-3">
          <button type="submit" class="btn btn-primary col-auto">Next</button>
        </div>

      </form>
    </div>
  </main>
</body>

</html>
