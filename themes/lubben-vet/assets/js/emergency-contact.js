/**
 * After-hours emergency contact — mobile tel: link, desktop modal (number not in HTML).
 */
(function () {
  var config = window.lubbenVetEmergency || {};
  var payload = config.payload || [];
  var modal = document.getElementById('lubben-emergency-modal');

  if (!payload.length || !modal) {
    return;
  }

  var backdrop = modal.querySelector('.emergency-modal__backdrop');
  var closeButtons = modal.querySelectorAll('[data-emergency-close]');
  var numberEl = modal.querySelector('[data-emergency-number]');
  var callEl = modal.querySelector('[data-emergency-call]');
  var triggers = document.querySelectorAll('[data-emergency-trigger]');
  var lastTrigger = null;
  var decoded = null;

  function decodePhone() {
    if (decoded) {
      return decoded;
    }

    decoded = payload
      .map(function (code) {
        return String.fromCharCode(code - 17);
      })
      .join('');

    return decoded;
  }

  function formatDisplay(digits) {
    if (digits.length === 10) {
      return digits.slice(0, 3) + '.' + digits.slice(3, 6) + '.' + digits.slice(6);
    }

    return digits;
  }

  function prefersDirectCall() {
    return window.matchMedia('(max-width: 767px), (hover: none) and (pointer: coarse)').matches;
  }

  function populateModal() {
    var digits = decodePhone();
    var display = formatDisplay(digits);

    if (numberEl) {
      numberEl.textContent = display;
      numberEl.hidden = false;
    }

    if (callEl) {
      callEl.href = 'tel:' + digits;
      callEl.hidden = false;
    }
  }

  function openModal() {
    populateModal();
    modal.hidden = false;
    document.body.classList.add('emergency-modal-open');

    var focusTarget = closeButtons[0] || callEl;
    if (focusTarget) {
      focusTarget.focus();
    }
  }

  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove('emergency-modal-open');

    if (lastTrigger) {
      lastTrigger.focus();
      lastTrigger = null;
    }
  }

  function handleTriggerClick(event) {
    lastTrigger = event.currentTarget;

    if (prefersDirectCall()) {
      window.location.href = 'tel:' + decodePhone();
      return;
    }

    openModal();
  }

  triggers.forEach(function (trigger) {
    trigger.addEventListener('click', handleTriggerClick);
  });

  closeButtons.forEach(function (button) {
    button.addEventListener('click', closeModal);
  });

  if (backdrop) {
    backdrop.addEventListener('click', closeModal);
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !modal.hidden) {
      event.preventDefault();
      closeModal();
    }
  });
})();
