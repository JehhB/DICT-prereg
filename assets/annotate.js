function cc(s) {
  $('#cursor-cursor').hide();
  $('#cursor-i').hide();
  $('#cursor-pointer').hide();
  $('#cursor-' + s).show();
}


function sleep(s) {
  return new Promise(resolve => setTimeout(resolve, s));
}

function pos($element) {
  const rect = $element[0].getBoundingClientRect();

  const x = rect.left + rect.width / 2;
  const y = rect.top + rect.height / 2;

  return {
    x,
    y
  };
}

async function goto($el, m = 500) {
  $c = $('#cursor');
  await gsap.to($c, {
    ...pos($el),
    duration: m / 1000,
    ease: "power1.inOut"
  });
}

async function click($el, m = 500, idle = 250) {
  $c = $('#cursor');
  cc('cursor');

  await goto($el, m);
  cc('pointer');
  await sleep(idle);
  await gsap.to($c, {
    duration: 0.150,
    scale: 0.8,
    yoyo: true,
    repeat: 1,
    ease: "power2.inOut",
    transformOrigin: "0 0"
  });
  $el.click();
}

async function type($el, text, m = 500, typing = 250) {
  $c = $('#cursor');
  cc('cursor');
  await goto($el, m);
  cc('i');
  await gsap.to($c, {
    duration: 0.150,
    scale: 0.8,
    yoyo: true,
    repeat: 1,
    ease: "power2.inOut",
    transformOrigin: "0 0"
  });
  await gsap.to($el, {
    text: text,
    duration: typing / 1000,
    ease: "none",
    onUpdate: function() {
      $el.val(this.targets()[0].textContent);
    }
  });
}

async function scrollToView($el) {
  $el[0].scrollIntoView({
    behavior: 'smooth'
  });
  await sleep(500);
}



