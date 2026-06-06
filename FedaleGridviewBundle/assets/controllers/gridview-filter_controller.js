import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { delay: { type: Number, default: 300 } };

    connect() {
        this._timer = null;

        // After a Turbo frame replaces the form, restore focus to the last active input.
        // The <turbo-frame> element itself is NOT replaced (only its children are), so
        // data-last-focused-id set on it before the swap is still readable here.
        const frame = this.element.closest('turbo-frame');
        if (frame?.dataset.lastFocusedId) {
            const el = document.getElementById(frame.dataset.lastFocusedId);
            if (el) {
                el.focus();
                const len = el.value.length;
                el.setSelectionRange(len, len);
            }
        }

        this._applyHighlights();
    }

    input(event) {
        // If there is no enclosing <turbo-frame> (useTurbo: false), skip auto-submit.
        // The user can still submit manually via the Save button.
        const frame = this.element.closest('turbo-frame');
        if (!frame) return;

        // Persist the focused element ID on the frame (survives the content swap).
        frame.dataset.lastFocusedId = event.target.id;

        clearTimeout(this._timer);
        this._timer = setTimeout(() => this.element.requestSubmit(), this.delayValue);
    }

    disconnect() {
        clearTimeout(this._timer);
    }

    // --- highlight ---

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
            // snapshot childNodes: the list changes as we replace text nodes
            [...node.childNodes].forEach(child => this._walk(child, term));
        }
    }

    _highlightTextNode(node, term) {
        const text  = node.textContent;
        const lower = text.toLowerCase();
        const needle = term.toLowerCase();

        if (!lower.includes(needle)) return;

        const parts = [];
        let lastIdx = 0;
        let idx = lower.indexOf(needle, 0);

        while (idx !== -1) {
            if (idx > lastIdx) {
                parts.push(document.createTextNode(text.slice(lastIdx, idx)));
            }
            const mark = document.createElement('mark');
            mark.className = 'gv-highlight';
            mark.textContent = text.slice(idx, idx + term.length);
            parts.push(mark);
            lastIdx = idx + term.length;
            idx = lower.indexOf(needle, lastIdx);
        }

        if (lastIdx < text.length) {
            parts.push(document.createTextNode(text.slice(lastIdx)));
        }

        node.replaceWith(...parts);
    }
}
