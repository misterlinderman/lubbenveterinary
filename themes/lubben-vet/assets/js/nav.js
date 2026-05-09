/**
 * Mobile navigation — toggle, Esc to close, basic focus trap (no jQuery).
 */
(function () {
  var toggle = document.getElementById('site-nav-toggle');
  var panel = document.getElementById('primary-menu-panel');
  var backdrop = document.getElementById('site-nav-backdrop');
  var closeBtn = document.getElementById('site-nav-close');

  if (!toggle || !panel || !backdrop) {
    return;
  }

  function focusableSelectors() {
    return panel.querySelectorAll('a[href], button:not([disabled])');
  }

  function openMenu() {
    panel.hidden = false;
    backdrop.hidden = false;
    panel.classList.add('is-open');
    backdrop.classList.add('is-open');
    document.body.classList.add('site-nav-open');
    toggle.setAttribute('aria-expanded', 'true');

    var focusables = focusableSelectors();
    var preferred = closeBtn ? closeBtn : focusables[0];
    if (preferred) {
      preferred.focus();
    }
  }

  function closeMenu() {
    panel.classList.remove('is-open');
    backdrop.classList.remove('is-open');
    panel.hidden = true;
    backdrop.hidden = true;
    document.body.classList.remove('site-nav-open');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.focus();
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeMenu);
  }

  toggle.addEventListener('click', function () {
    if (panel.hidden) {
      openMenu();
    } else {
      closeMenu();
    }
  });

  backdrop.addEventListener('click', closeMenu);

  document.addEventListener('keydown', function (evt) {
    if (evt.key === 'Escape' && !panel.hidden) {
      evt.preventDefault();
      closeMenu();
    }
  });

  panel.addEventListener('keydown', function (evt) {
    if (evt.key !== 'Tab' || panel.hidden) {
      return;
    }

    var items = Array.prototype.slice.call(focusableSelectors());
    if (!items.length) {
      return;
    }

    var first = items[0];
    var last = items[items.length - 1];

    if (evt.shiftKey && document.activeElement === first) {
      evt.preventDefault();
      last.focus();
    } else if (!evt.shiftKey && document.activeElement === last) {
      evt.preventDefault();
      first.focus();
    }
  });
})();
