let alreadySelected = [];

document.addEventListener('DOMContentLoaded', function() {
  const el = document.getElementById('alreadySelected');
  if (el) {
    alreadySelected = JSON.parse(el.textContent);
  }
});

function form(init_data_id, exclude = null) {
  return {
    sel: [],
    slots: {},

    init() {
      const el = document.getElementById(init_data_id);
      this.slots = JSON.parse(el.textContent);
    },

    count(s, timeslotId, boothId) {
      return (s[timeslotId] && s[timeslotId][boothId]) || 0;
    },

    format(timeslotId, boothId) {
      let c = this.count(this.slots, timeslotId, boothId);
      return `${c}/${this.slots['_MAX_SLOTS']}`;
    },

    isFull(timeslotId, boothId) {
      return this.count(this.slots, timeslotId, boothId) >= this.slots['_MAX_SLOTS'];
    }
  };
}

function radio(next_target, init) {

  return {
    opt: null,

    init() {
      const timeslotId = this.$root.dataset.radioTimeslot;
      setTimeout(() => this.opt = init, 10);
      this.$watch('slots', (s) => {
        if (this.count(s, timeslotId, this.opt) >= s['_MAX_SLOTS']) {
          setTimeout(() => this.opt = null, 0);
        }
      })
    },

    input: {
      ['@change']() {
        document.getElementById(next_target).scrollIntoView({
          behavior: 'smooth'
        });
      },
      [':disabled']() {
        if (this.$el.dataset.radioDisabled) return true;
        const timeslotId = this.$root.dataset.radioTimeslot;
        const boothId = this.$el.dataset.radioBooth;

        if (this.isFull(timeslotId, boothId)) return true;
        if (this.opt == this.$el.value) return false;

        return this.sel.includes(this.$el.value) || alreadySelected.includes(this.$el.value);
      }
    },
  };
}

function description(init = '') {
  const _options = ['student', 'job seeker', 'out of school youth', 'fresh graduate'];

  return {
    selected: [],
    options: _options,
    others: '',

    init() {
      const options = new Set(_options);
      const other = new Set(init.split(',').map(x => x.trim()).filter(x => x.length > 0)).difference(options);

      this.others = Array.from(other).join(', ');
      this.selected = init.split(',').map(x => x.trim()).filter(x => _options.includes(x));
    },

    value() {
      return [...this.selected.map(x => x.toLowerCase()), this.others].join(',');
    },

    input: {
      ['@change']() {
        const value = this.$el.dataset.descValue;
        if (this.$el.checked) {
          if (!this.selected.includes(value)) this.selected.push(value);
        } else {
          this.selected = this.selected.filter(v => v != value);
        }
      },
    },
  };
}

function attendance() {
  return {
    data: null,
    isLoading: false,
    error: {
      email: false,
      qr: false,
    },

    signaturePad: null,
    signature: null,

    init() {
      const canvas = this.$refs.canvas;
      this.signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
      });

      const resizeCanvas = () => {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        this.signaturePad.fromData(this.signaturePad.toData());
      }

      this.signaturePad.addEventListener('endStroke', () => {
        this.signature = this.signaturePad.isEmpty() ? null : this.signaturePad.toDataURL('image/jpeg');
      });

      window.addEventListener("resize", resizeCanvas);
      this.signature = null;
      resizeCanvas();
    },

    clear() {
      this.signaturePad.clear();
      this.signature = null;
    },

    clearData() {
      this.data = null;
      this.clear();
      this.$refs.email.value = '';
      this.error = {
        email: false,
        qr: false,
      };
    },

    fetchSlug(url) {
      const urlObject = new URL(url);
      const queryParams = new URLSearchParams(urlObject.search);
      const slug = queryParams.get('s');

      this.isLoading = true;
      this.error = {
        email: false,
        qr: false,
      };

      fetch('./attendance.php?slug=' + slug)
        .then((resp) => {
          this.isLoading = false;
          if (resp.status != 200) {
            this.error.email = "Invalid qr code";
            return null;
          } else {
            return resp.json();
          }
        }).then((data) => {
          this.data = data;
        }).catch(() => {
          this.isLoading = false;
          this.error.email = "Failed to connect to server";
        });
    },

    fetchEmail(email) {
      this.isLoading = true;
      this.error = {
        email: false,
        qr: false,
      };

      fetch('./attendance.php?email=' + email)
        .then((resp) => {
          this.isLoading = false;
          if (resp.status != 200) {
            this.error.email = "Invalid email. Please register first";
            return null;
          } else {
            return resp.json();
          }
        }).then((data) => {
          this.data = data;
        }).catch(() => {
          this.isLoading = false;
          this.error.email = "Failed to connect to server";
        });
    }
  };
}

function qrCode() {
  const config = { fps: 30, qrbox: { width: '250px', height: '250px' } };
  const camera = { facingMode: "environment" };

  return {
    scanning: false,
    modal: null,
    scanner: null,

    init() {
      this.modal = new bootstrap.Modal(this.$refs.modal);
      this.scanner = new Html5Qrcode('scanner');

      this.$watch('scanning', (s) => {
        if (s) {
          this.modal.show();
          this.scanner.start(camera, config, (t) => {
            this.$dispatch('scan', t);
            this.scanning = false;
          });
        } else {
          this.modal.hide();
          this.scanner.stop();
        }
      });

      this.$refs.modal.addEventListener('hide.bs.modal', () => {
        this.scanning = false;
      });
    },
  };
}



document.addEventListener('alpine:init', () => {
  Alpine.data('radio', radio);
  Alpine.data('form', form);
  Alpine.data('description', description);
  Alpine.data('attendance', attendance);
  Alpine.data('qrCode', qrCode);
})

document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  [...tooltipTriggerList].forEach(tooltipTriggerEl => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
