function form(init_data_id) {
  return {
    sel: [],
    slots: {},

    async refetch() {
      while (true) {
        await fetch('./count.php')
          .then(resp => resp.json())
          .then(data => {
            this.slots = data;
          }).then(() => new Promise((resolve) => {
            setTimeout(resolve, 1000);
          }))
      }
    },

    init() {
      const el = document.getElementById(init_data_id);
      this.slots = JSON.parse(el.textContent);

      this.refetch();
    },

    count(timeslotId, boothId) {
      return (this.slots[timeslotId] && this.slots[timeslotId][boothId]) || 0;
    },

    format(timeslotId, boothId) {
      let c = this.count(timeslotId, boothId);
      return `${c}/${this.slots['_MAX_SLOTS']}`;
    },

    isFull(timeslotId, boothId) {
      return this.count(timeslotId, boothId) >= this.slots['_MAX_SLOTS'];
    }
  };
}

function radio(next_target) {
  return {
    opt: null,

    input: {
      ['@change']() {
        document.getElementById(next_target).scrollIntoView({
          behavior: 'smooth'
        });
      },
    },
  };
}

document.addEventListener('alpine:init', () => {
  Alpine.data('radio', radio);
  Alpine.data('form', form);
})

