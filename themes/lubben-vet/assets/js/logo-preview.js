/**
 * Temporary fixed control — cycles client logo preview states (localStorage).
 */
(function () {
	var KEY = 'lubbenVetLogoPreview';

	function getCfg() {
		return window.lubbenVetLogoPreview;
	}

	function getStoredState() {
		try {
			var v = localStorage.getItem(KEY);
			return v === 'b' ? 'b' : 'a';
		} catch (e) {
			return 'a';
		}
	}

	function setStoredState(s) {
		try {
			localStorage.setItem(KEY, s);
		} catch (e) {}
	}

	function applyState(state) {
		var cfg = getCfg();
		if (!cfg) {
			return;
		}
		var slot = state === 'b' ? cfg.b : cfg.a;
		var headerImg = document.querySelector('.site-header__logo');
		var footerImg = document.querySelector('.site-footer__logo');
		if (headerImg && slot.header) {
			headerImg.src = slot.header;
		}
		if (footerImg && slot.footer) {
			footerImg.src = slot.footer;
		}
		setStoredState(state);
	}

	function labelFor(state) {
		var l10n = window.lubbenVetLogoPreviewL10n || {};
		return state === 'b' ? l10n.stateB || 'State B' : l10n.stateA || 'State A';
	}

	function mount() {
		var cfg = getCfg();
		if (!cfg) {
			return;
		}

		var initial = getStoredState();
		applyState(initial);

		var l10n = window.lubbenVetLogoPreviewL10n || {};
		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'lubben-vet-logo-preview-toggle';
		btn.setAttribute('aria-label', l10n.title || 'Switch logo options');
		btn.title = l10n.title || '';

		function syncLabel(state) {
			btn.textContent = labelFor(state);
			btn.setAttribute('aria-pressed', state === 'b' ? 'true' : 'false');
		}

		syncLabel(initial);

		btn.addEventListener('click', function () {
			var next = getStoredState() === 'a' ? 'b' : 'a';
			applyState(next);
			syncLabel(next);
		});

		document.body.appendChild(btn);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', mount);
	} else {
		mount();
	}
})();
