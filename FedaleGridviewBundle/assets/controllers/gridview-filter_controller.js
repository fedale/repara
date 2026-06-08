import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { delay: { type: Number, default: 300 } };

    connect() {
        this._timer = null;

        // After a Turbo frame replaces the form, restore focus to the last active input.
        const frame = this.element.closest('turbo-frame');
        if (frame?.dataset.lastFocusedId) {
            const el = document.getElementById(frame.dataset.lastFocusedId);
            if (el) {
                el.focus();
                const len = el.value.length;
                el.setSelectionRange(len, len);
            }
        }

        // Intercept every form submission: URL-size guard + loading state
        this._onSubmit = e => this._beforeSubmit(e);
        this.element.addEventListener('submit', this._onSubmit);

        // Turbo events: hide loading and surface errors after the request settles
        this._onSubmitEnd = e => {
            if (e.target !== this.element) return;
            this._hideLoading();
            // Show error for server failures (5xx); ignore 4xx (e.g. validation)
            const status = e.detail?.fetchResponse?.statusCode;
            if (e.detail?.success === false && (!status || status >= 500)) {
                this._showError();
            }
        };
        // Network-level errors (connection closed, timeout, etc.)
        this._onFetchError = e => {
            const frame = this.element.closest('turbo-frame');
            if (e.target !== this.element && e.target !== frame) return;
            this._hideLoading();
            this._showError();
        };
        document.addEventListener('turbo:submit-end', this._onSubmitEnd);
        document.addEventListener('turbo:fetch-request-error', this._onFetchError);

        this._applyHighlights();
        this._updateHeaderIcons();
    }

    disconnect() {
        clearTimeout(this._timer);
        this.element.removeEventListener('submit', this._onSubmit);
        document.removeEventListener('turbo:submit-end', this._onSubmitEnd);
        document.removeEventListener('turbo:fetch-request-error', this._onFetchError);
    }

    // ── Actions ────────────────────────────────────────────────────────

    input(event) {
        // If there is no enclosing <turbo-frame> (useTurbo: false), skip auto-submit.
        const frame = this.element.closest('turbo-frame');
        if (!frame) return;

        frame.dataset.lastFocusedId = event.target.id;

        clearTimeout(this._timer);
        this._timer = setTimeout(() => {
            this._updateHeaderIcons();
            this.element.requestSubmit();
        }, this.delayValue);
    }

    filterBarInput(event) {
        const frame = this.element.closest('turbo-frame');
        if (!frame) return;

        frame.dataset.lastFocusedId = event.target.id;

        const attr = event.target.dataset.gvFbAttr;
        if (attr) {
            this.element.querySelectorAll(`[data-gv-mirror-attr="${attr}"]`)
                .forEach(el => { el.value = event.target.value; });
        }

        clearTimeout(this._timer);
        this._timer = setTimeout(() => {
            this._updateHeaderIcons();
            this.element.requestSubmit();
        }, this.delayValue);
    }

    mirrorInput(event) {
        const attr = event.target.dataset.gvMirrorAttr;
        if (!attr) return;

        const frame = this.element.closest('turbo-frame');
        if (!frame) return;

        frame.dataset.lastFocusedId = event.target.id;

        const realInput = this.element.querySelector(`[data-gv-fb-attr="${attr}"]`);
        if (realInput) realInput.value = event.target.value;

        clearTimeout(this._timer);
        this._timer = setTimeout(() => {
            this._updateHeaderIcons();
            this.element.requestSubmit();
        }, this.delayValue);
    }

    toggleFilter(event) {
        const field  = event.params.field;
        const inputs = this._findFilterInputs(field);
        const active = inputs.some(el => this._hasValue(el));

        if (active) {
            inputs.forEach(el => this._clearInput(el));
            this._updateHeaderIcons();
            this.element.requestSubmit();
        } else {
            const first = inputs[0];
            if (first) {
                first.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                first.focus();
            }
        }
    }

    clearFilter(event) {
        const field = event.params.field;
        this._findFilterInputs(field).forEach(el => this._clearInput(el));
        this._updateHeaderIcons();
        this.element.requestSubmit();
    }

    resetAll() {
        this.element.reset();
        this.element.querySelectorAll('[data-gv-mirror-attr]').forEach(el => { el.value = ''; });
        this._updateHeaderIcons();
        this.element.requestSubmit();
    }

    // ── Submit guard ───────────────────────────────────────────────────

    _beforeSubmit(event) {
        // Block GET submissions whose query string would exceed the server's URL limit.
        // Configurable via data-gv-max-query-length on the [data-gridview] container.
        if (this.element.method.toLowerCase() === 'get') {
            const fd    = new FormData(this.element);
            const qs    = new URLSearchParams(fd).toString();
            const limit = Number(this._gv()?.dataset.gvMaxQueryLength ?? 4000);
            if (qs.length > limit) {
                event.preventDefault();
                // Identify which array fields are contributing most (e.g. multi-select)
                const fieldCounts = {};
                for (const key of new URLSearchParams(fd).keys()) {
                    const m = key.match(/\[([^\]]+)\]\[\]$/);
                    if (m) fieldCounts[m[1]] = (fieldCounts[m[1]] || 0) + 1;
                }
                const heavy = Object.entries(fieldCounts)
                    .filter(([, n]) => n > 5)
                    .sort(([, a], [, b]) => b - a)
                    .map(([name, n]) => `"${name}" (${n} valori)`);
                let msg = `La query URL supera il limite consentito (${qs.length} / ${limit} byte).`;
                msg += heavy.length > 0
                    ? ` Riduci la selezione in: ${heavy.join(', ')}.`
                    : ' Riduci il numero di valori selezionati nei filtri e riprova.';
                this._showError(msg);
                return;
            }
        }
        this._clearError();
        this._showLoading();
    }

    // ── Loading & error feedback ───────────────────────────────────────

    _gv() { return this.element.closest('[data-gridview]'); }

    _showLoading() {
        const gv = this._gv();
        if (!gv || gv.querySelector('.gv-loading-overlay')) return;
        const overlay = document.createElement('div');
        overlay.className = 'gv-loading-overlay';
        overlay.setAttribute('aria-hidden', 'true');
        const spinner = document.createElement('div');
        spinner.className = 'gv-spinner';
        overlay.appendChild(spinner);
        gv.appendChild(overlay);
    }

    _hideLoading() {
        this._gv()?.querySelector('.gv-loading-overlay')?.remove();
    }

    _showError(message) {
        const gv = this._gv();
        if (!gv) return;
        const msg = message
            ?? gv.dataset.gvErrorMessage
            ?? 'Si è verificato un errore di comunicazione con il server. Riprova.';

        let banner = gv.querySelector(':scope > .gv-error-banner');
        if (!banner) {
            banner = document.createElement('div');
            banner.className = 'gv-error-banner';
            // Close button
            const close = document.createElement('button');
            close.type = 'button';
            close.className = 'gv-error-banner__close';
            close.textContent = '✕';
            close.addEventListener('click', () => this._clearError());
            banner.appendChild(close);
            gv.prepend(banner);
        }
        // Update message text node (keep close button)
        const close = banner.querySelector('.gv-error-banner__close');
        banner.childNodes.forEach(n => { if (n !== close) n.remove(); });
        banner.prepend(document.createTextNode(msg));
        banner.hidden = false;
        this._hideLoading();
    }

    _clearError() {
        const banner = this._gv()?.querySelector(':scope > .gv-error-banner');
        if (banner) banner.hidden = true;
    }

    // ── Header icon state ──────────────────────────────────────────────

    _updateHeaderIcons() {
        this.element.querySelectorAll('[data-gridview-filter-field-param]').forEach(btn => {
            const field  = btn.dataset.gridviewFilterFieldParam;
            const inputs = this._findFilterInputs(field);
            const active = inputs.some(el => this._hasValue(el));
            btn.classList.toggle('gv-filter-icon--active', active);
        });
    }

    // ── Helpers ────────────────────────────────────────────────────────

    _findFilterInputs(field) {
        return [
            ...this.element.querySelectorAll(
                `[name*="[${field}]"], [name="${field}"]`
            ),
        ];
    }

    _hasValue(el) {
        if (el.tagName === 'SELECT') {
            return [...el.options].some(o => o.selected && o.value !== '');
        }
        return el.value !== '' && el.value !== null;
    }

    _clearInput(el) {
        if (el.tagName === 'SELECT') {
            [...el.options].forEach(o => { o.selected = false; });
        } else {
            el.value = '';
        }
    }

    // ── Highlight ──────────────────────────────────────────────────────

    _applyHighlights() {
        const term = this._searchTerm();
        if (!term) return;
        const tbody = this.element.querySelector('tbody');
        if (!tbody) return;
        this._walk(tbody, term);
    }

    _searchTerm() {
        const input = this.element.querySelector('[name$="[_q]"]');
        return input?.value?.trim() ?? '';
    }

    _walk(node, term) {
        if (node.nodeType === Node.TEXT_NODE) {
            this._highlightTextNode(node, term);
        } else if (
            node.nodeType === Node.ELEMENT_NODE &&
            node.tagName !== 'MARK' &&
            node.tagName !== 'SCRIPT' &&
            node.tagName !== 'STYLE'
        ) {
            [...node.childNodes].forEach(child => this._walk(child, term));
        }
    }

    _highlightTextNode(node, term) {
        const text   = node.textContent;
        const lower  = text.toLowerCase();
        const needle = term.toLowerCase();

        if (!lower.includes(needle)) return;

        const parts = [];
        let lastIdx = 0;
        let idx = lower.indexOf(needle, 0);

        while (idx !== -1) {
            if (idx > lastIdx) parts.push(document.createTextNode(text.slice(lastIdx, idx)));
            const mark = document.createElement('mark');
            mark.className = 'gv-highlight';
            mark.textContent = text.slice(idx, idx + term.length);
            parts.push(mark);
            lastIdx = idx + term.length;
            idx = lower.indexOf(needle, lastIdx);
        }

        if (lastIdx < text.length) parts.push(document.createTextNode(text.slice(lastIdx)));
        node.replaceWith(...parts);
    }
}
