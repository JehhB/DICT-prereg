<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preregistration</title>

  <?php include __DIR__ . '/assets.php' ?>

</head>

<body class="bg-light-subtle">

  <?php if (!isset($_SESSION['register_privacy'])): ?>
    <div class="modal modal-lg fade" tabindex="-1" data-bs-backdrop="static" x-data x-init="new bootstrap.Modal($el).show()">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Data Privacy Context</h5>
          </div>
          <div class="modal-body">
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
              By pressing <strong>"I Agree,"</strong> I am providing consent to the <strong>DICT</strong> and
              <strong>*DICT UNIT NAME*</strong> to gather and process my information for my participation in this
              training. <strong>My details will not be disclosed to any third-party organizations or affiliates of
                DICT and its partners</strong>. The information will be exclusively utilized for reporting
              quantitative data of attendees and sending invitations for participation in the specified activity.
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
      <div class="card mb-3 shadow-sm">
        <img src="https://placehold.co/970x250.png?text=Banner+Image" class="card-img-top" alt="Banner">
      </div>

      <h1>
        DICT Event Preregistration
      </h1>
      <form action="#" method="post">
        <?= csrf_field() ?>

        <div class="card mb-4 shadow-sm">
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

        <div class="card mb-4 shadow-sm">
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
                id="type"
                name="type"
                :value="value">

              <template x-for="(option, i) in options">
                <div class="form-check" x-data="{id: $id('desc')}">
                  <input class="form-check-input" type="checkbox" :id="id" x-bind="input" :checked="selected.has(option)" :data-desc-value="option">
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
                <strong x-transition x-show.important="value.length > 0" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'type') ?></strong>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-secondary">
            Event Registration Details
          </div>
          <div class="card-body">
            <div x-data="{valid:false}" class="mb-3">


              <label for="event_id" class="form-label">What event do you want to join?</label>

              <?php foreach (Event::get_events() as $ev) : ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    id="ev_<?= $ev->id ?>"
                    name="event_id"
                    value="<?= $ev->id ?>"
                    @input="valid=$el.checkValidity()"
                    <?php if ($ev->id == ($_SESSION['register_event_id'] ?? 0)) : ?> checked <?php endif ?>
                    required>
                  <label class="form-check-label" for="ev_<?= $ev->id ?>">
                    <?= $ev->event_name ?> <em>@<?= $ev->event_venue ?></em>
                  </label>
                </div>
              <?php endforeach ?>

              <?php if (flash_has('errors', 'event_id')): ?>
                <strong x-transition x-show.important="!valid" class="alert alert-danger d-block py-1 px-3 mt-2"><?= flash_get('errors', 'event_id') ?></strong>
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
