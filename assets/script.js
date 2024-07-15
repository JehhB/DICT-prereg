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
})

