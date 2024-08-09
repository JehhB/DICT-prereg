<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
  <?php include __DIR__ . '/assets.php'; ?>
  <script src="/assets/cdn/signature_pad.umd.min.js"></script>
  <script src="/assets/cdn/html5-qrcode.min.js"></script>
</head>

<body x-data="qrCode">

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


  <div class="modal fade" tabindex="-1" x-ref="modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Privacy Notice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
          <div id="scanner" style="width: 250px; height: 250px;" class="d-flex align-items-stretch justify-content-stretch mx-auto"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" id="privacy">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Privacy Notice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>
            (R.A. 10173): We need your personal data to provide verifiable evidence in support of this event and that you participated therein. We will include your data in our printed and electronic reports that we will send through secured channels.
          </p>
          <p>
            By signing herein, we will continuously keep your data under lock and key, and will limit their use to authorized staff. If you do not agree, please inform us and we will permanently destroy your data after we have sent our reports.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <main class="container my-3 my-sm-4" x-data="attendance">
    <div class="col col-md-11 col-lg-9 col-xl-8 col-xxl-7 mx-auto">
      <div class="card mb-3 shadow-sm">
        <div class="card-header bg-secondary d-flex">
          Attendance
        </div>
        <form action="./attendance-na.php" class="card-body" method="POST">
          <?= csrf_field() ?>
          <div class="row g-3">
            <div class="col-12">
              <label for="email" class="form-label d-flex">
                <span>Email</span>
                <div class="spinner-border spinner-border-sm ms-auto" role="status" x-show="isLoading">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </label>
              <div class="input-group has-validation">
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  x-ref="email"
                  :class="error.email && 'is-invalid'"
                  @input.debounce.1000ms="fetchEmail($el.value)"
                  autocomplete="off">
                <button class="btn btn-primary" type="button" @click="scanning=true" @scan.window="fetchSlug($event.detail)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                    <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z" />
                    <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z" />
                    <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z" />
                    <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z" />
                    <path d="M12 9h2V8h-2z" />
                  </svg>
                </button>
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  Email doesn't exist. Please register first
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" readonly :value="data?.name">
            </div>

            <div class="col-md-6">
              <label for="id" class="form-label">ID</label>
              <input type="text" class="form-control" id="id" readonly :value="data?.slug">
            </div>

            <div class="col-md-6">
              <label for="contact" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="contact" readonly :value="data?.contact_number">
            </div>

            <div class="col-md-6">
              <label for="affiliation" class="form-label">Affiliation</label>
              <input type="text" class="form-control" id="affiliation" readonly :value="data?.affiliation">
            </div>

            <div class="col-md-6">
              <label for="position" class="form-label">Position</label>
              <input type="text" class="form-control" id="position" readonly :value="data?.position">
            </div>

            <div class="col-12 mb-3">
              <input type="hidden" name="id" :value="data?.id">
              <input type="hidden" name="signature" :value="signature">
              <label for="signature-pad" class="form-label">Signature</label>
              <div class="ratio ratio-2x1 mb-3">
                <canvas x-ref="canvas" id="signature-pad" class="form-control w-full h-full"></canvas>
              </div>
              <button type="button" class="btn btn-sm btn-secondary" @click="clear">Clear signature</button>
            </div>


            <small class="mb-3">
              By submitting this form, I agree to the collection and processing of my data stated in this
              <a role="button" class="btn-link" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#privacy">Privacy Notice</a>
            </small>

            <div class="col-12">
              <button type="submit" class="w-100 btn btn-primary" :disabled="signature == null || data?.id == null">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
  </main>
</body>

</html>
