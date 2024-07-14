function radio(next_target) {
  return {
    opt: null,

    input: {
      [':disabled']() {
        return this.opt != this.$el.value && this.sel.includes(this.$el.value);
      },
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
})

