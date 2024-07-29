<?php
foreach (array_keys($_SESSION) as $k) {
  if (str_starts_with($k, 'register_')) unset($_SESSION[$k]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>

  <?php include __DIR__ . '/assets.php' ?>

  <script>
    let first = true;
    $(document).ready(function() {
      window.scrollTo(0, 0);
    });

    $(document).on("click", async function() {
      if (!first) return;
      first = false;

      await sleep(500);

      cc('cursor');
      await sleep(500);

      $c = $('#cursor');

      await scrollToView($('#p2'));
      await sleep(500);

      $agree = $('[data-bs-dismiss="modal"]')
      await click($agree);
      cc('cursor');

      $evBtn = $('.ev-btn');
      await goto($evBtn.first());
      cc('pointer');
      await sleep(100);
      cc('cursor');
      await click($evBtn.last());

      await scrollToView($('#personal-info'))
      $name = $('#name');
      await type($name, "Juan Dela Cruz");
      $c.hide();

      await Promise.all([
        type($('#email'), 'juandelacruz@email.com'),
        type($('#contact_number'), '09123456789'),
      ]);
      $('#sex').val('M');
      $('#birthday').val('2000-01-01');
      $c.show();
      await click($('#is_indigenous'));
      cc('cursor');

      await scrollToView($('#professional-info'));

      $c.hide();
      await Promise.all([
        type($('#affiliation'), 'Isabela State University'),
        type($('#position'), '3rd Year'),
      ]);
      $c.show();
      await click($('#desc-1'));

      $next = $('button[type="submit"]');
      await goto($next);
      await click($next);

      $('#annotate').hide();
    });
  </script>

</head>

<body class="bg-light-subtle">
  <div style="z-index: 2000; position: fixed; inset: 0;" id="annotate">
    <div id="cursor">
      <svg id="cursor-i" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="24" height="24" style="position:absolute;display: none;"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M.1 29.3C-1.4 47 11.7 62.4 29.3 63.9l8 .7C70.5 67.3 96 95 96 128.3L96 224l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 95.7c0 33.3-25.5 61-58.7 63.8l-8 .7C11.7 449.6-1.4 465 .1 482.7s16.9 30.7 34.5 29.2l8-.7c34.1-2.8 64.2-18.9 85.4-42.9c21.2 24 51.2 40 85.4 42.9l8 .7c17.6 1.5 33.1-11.6 34.5-29.2s-11.6-33.1-29.2-34.5l-8-.7C185.5 444.7 160 417 160 383.7l0-95.7 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-95.7c0-33.3 25.5-61 58.7-63.8l8-.7c17.6-1.5 30.7-16.9 29.2-34.5S239-1.4 221.3 .1l-8 .7C179.2 3.6 149.2 19.7 128 43.7c-21.2-24-51.2-40-85.4-42.9l-8-.7C17-1.4 1.6 11.7 .1 29.3z" />
      </svg>
      <svg id="cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24" style="position: absolute;display:none"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M128 40c0-22.1 17.9-40 40-40s40 17.9 40 40l0 148.2c8.5-7.6 19.7-12.2 32-12.2c20.6 0 38.2 13 45 31.2c8.8-9.3 21.2-15.2 35-15.2c25.3 0 46 19.5 47.9 44.3c8.5-7.7 19.8-12.3 32.1-12.3c26.5 0 48 21.5 48 48l0 48 0 16 0 48c0 70.7-57.3 128-128 128l-16 0-64 0-.1 0-5.2 0c-5 0-9.9-.3-14.7-1c-55.3-5.6-106.2-34-140-79L8 336c-13.3-17.7-9.7-42.7 8-56s42.7-9.7 56 8l56 74.7L128 40zM240 304c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96zm48-16c-8.8 0-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96c0-8.8-7.2-16-16-16zm80 16c0-8.8-7.2-16-16-16s-16 7.2-16 16l0 96c0 8.8 7.2 16 16 16s16-7.2 16-16l0-96z" />
      </svg>
      <svg id="cursor-cursor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="24" height="24" style="position: absolute;"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path d="M0 55.2L0 426c0 12.2 9.9 22 22 22c6.3 0 12.4-2.7 16.6-7.5L121.2 346l58.1 116.3c7.9 15.8 27.1 22.2 42.9 14.3s22.2-27.1 14.3-42.9L179.8 320l118.1 0c12.2 0 22.1-9.9 22.1-22.1c0-6.3-2.7-12.3-7.4-16.5L38.6 37.9C34.3 34.1 28.9 32 23.2 32C10.4 32 0 42.4 0 55.2z" />
      </svg>
    </div>
  </div>

  <?php if (!isset($_SESSION['register_privacy']) || true): ?>
    <div class="modal modal-lg fade" tabindex="-1" data-bs-backdrop="static" x-data x-init="new bootstrap.Modal($el).show()">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Data Privacy Content</h5>
          </div>
          <div class="modal-body">
            <p>
              The DICT recognizes their responsibilities under the <strong>Republic Act No. 10173 (Act)</strong>, also
              known as the <strong>Data Privacy Act of 2012</strong>. The personal data obtained from this form is
              analyzed, entered, and stored within the Department’s authorized information and communications system and
              will only be accessed by the <strong>DICT</strong> authorized personnel. The <strong>DICT</strong>
              Team has instituted appropriate organizational, technical, and physical security
              measures to ensure the protection of the participants’ personal data.
            </p>
            <p id="p2">
              By pressing <strong>"I Agree,"</strong> I am providing consent to the <strong>DICT</strong> to gather and
              process my information for my participation in this training. <strong>My details will not be disclosed
                to any third-party organizations or affiliates of DICT and its partners</strong>. The information will be
              exclusively utilized for reporting quantitative data of attendees and sending invitations for participation
              in the specified activity.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="fetch('./?accept_data_privacy=true')">I Agree</button>
          </div>
        </div>
      </div>
    </div>
  <?php elseif (flash_has('errors', 'form')): ?>
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
      <form action="#" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-secondary">
            Event Registration Details
          </div>
          <div class="card-body">
            <div x-data="{valid:false}" class="mb-3">


              <label for="event_id" class="form-label">What event do you want to join?</label>
              <div class="row p-3 gap-3" x-data="{selected: <?= $_SESSION['register_event_id'] ?? 0 ?>}">
                <?php foreach (Event::get_events() as $ev): ?>
                  <button
                    type="button"
                    class="btn btn-outline-primary col py-5 d-flex flex-column align-items-center ev-btn"
                    :class="{'active': <?= $ev->id ?> == selected}"
                    @click="selected = <?= $ev->id ?>">
                    <span>
                      <?= $ev->event_name ?>
                    </span>
                    <em>
                      @ <?= $ev->event_venue ?>
                    </em>
                  </button>
                <?php endforeach ?>
                <input type="hidden" name="event_id" :value="selected">
              </div>

              <?php if (flash_has('errors', 'event_id')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'event_id') ?></strong>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="card mb-4 shadow-sm" id="personal-info">
          <div class="card-header bg-secondary">
            Personal Information
          </div>
          <div class="card-body">
            <div x-data="{valid:false}" class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required
                value="<?= htmlspecialchars($_SESSION['register_name'] ?? '') ?>"
                @input="$el.checkValidity()">
              <?php if (flash_has('errors', 'name')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'name') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="sex" class="form-label">Sex</label>
              <select class="form-control" id="sex" name="sex" required>
                <option>-- Please choose your sex --</option>
                <option value="M" <?= isset($_SESSION['register_sex']) && $_SESSION['register_sex'] === 'M' ? 'selected' : '' ?>>Male</option>
                <option value="F" <?= isset($_SESSION['register_sex']) && $_SESSION['register_sex'] === 'F' ? 'selected' : '' ?>>Female</option>
                <option value="OTHER" <?= isset($_SESSION['register_sex']) && $_SESSION['register_sex'] === 'OTHER' ? 'selected' : '' ?>>Others</option>
                <option value="BLANK" <?= isset($_SESSION['register_sex']) && $_SESSION['register_sex'] === 'BLANK' ? 'selected' : '' ?>>Prefer not to mention</option>
              </select>
              <?php if (flash_has('errors', 'sex')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'sex') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="birthday" class="form-label">Birthday</label>
              <input
                type="date"
                class="form-control"
                id="birthday"
                name="birthday"
                required
                value="<?= htmlspecialchars($_SESSION['register_birthday'] ?? '') ?>"
                @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'birthday')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'birthday') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                value="<?= htmlspecialchars($_SESSION['register_email'] ?? '') ?>"
                @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'email')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'email') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="contact_number" class="form-label">Contact Number</label>
              <input
                type="text"
                class="form-control"
                id="contact_number"
                name="contact_number"
                required
                value="<?= htmlspecialchars($_SESSION['register_contact_number'] ?? '') ?>"
                @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'contact_number')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'contact_number') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="is_indigenous" class="form-label">Are you a member of an indigenous group?</label>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  id="is_indigenous"
                  name="is_indigenous"
                  value="no"
                  <?= isset($_SESSION['register_is_indigenous']) && !$_SESSION['register_is_indigenous'] ? 'checked' : '' ?>
                  required>
                <label class="form-check-label" for="is_indigenous">
                  No
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  id="is_indigenous"
                  name="is_indigenous"
                  <?= isset($_SESSION['register_is_indigenous']) && $_SESSION['register_is_indigenous'] ? 'checked' : '' ?>
                  value="yes"
                  required>
                <label class="form-check-label" for="is_indigenous">
                  Yes
                </label>
              </div>
              <?php if (flash_has('errors', 'is_indigenous')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'is_indigenous') ?></strong>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="card mb-4 shadow-sm" id="professional-info">
          <div class="card-header bg-secondary">
            Professional Information
          </div>
          <div class="card-body">
            <div x-data="{valid:false}" class="mb-3">
              <label for="affiliation" class="form-label">Affiliation</label>
              <input
                type="text"
                class="form-control"
                id="affiliation"
                name="affiliation"
                required
                value="<?= htmlspecialchars($_SESSION['register_affiliation'] ?? '') ?>"
                @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'affiliation')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'affiliation') ?></strong>
              <?php endif ?>
            </div>
            <div x-data="{valid:false}" class="mb-3">
              <label for="position" class="form-label">Position</label>
              <input
                type="text"
                class="form-control"
                id="position"
                name="position"
                required
                value="<?= htmlspecialchars($_SESSION['register_position'] ?? '') ?>"
                @input="valid=$el.checkValidity()">
              <?php if (flash_has('errors', 'position')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'position') ?></strong>
              <?php endif ?>
            </div>
            <div
              class="mb-3"
              <?php if (isset($_SESSION['register_type'])): ?>
              x-data="description('<?= htmlspecialchars(str_replace("'", "", $_SESSION['register_type'])) ?>')"
              <?php else: ?>
              x-data="description()"
              <?php endif ?>>
              <label for="type" class="form-label">Description</label>
              <input
                type="hidden"
                class="form-control"
                name="type"
                :value="value">

              <template x-for="(option, i) in options">
                <div class="form-check" x-data="{id: $id('desc')}">
                  <input class="form-check-input" type="checkbox" :id="id" x-bind="input" :checked="selected.includes(option)" :data-desc-value="option">
                  <label class="form-check-label text-capitalize" :for="id" x-text="option">
                  </label>
                </div>
              </template>

              <input
                type="text"
                class="form-control"
                id="type"
                x-model="others"
                placeholder="Other (e.g. employer)">

              <?php if (flash_has('errors', 'type')): ?>
                <strong x-transition x-show.important="value.length == 0" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'type') ?></strong>
              <?php endif ?>
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
