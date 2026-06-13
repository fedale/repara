import { Controller } from '@hotwired/stimulus';

/**
 * Inline cell editing. An editable cell (.gv-editable with data-gv-field/data-gv-id)
 * fetches a single-field editor from `${base}/${id}/${field}` on click/dblclick,
 * submits it via fetch (server-side validation is authoritative), and swaps the
 * cell with the new display value. Enter saves, Escape cancels, one cell at a time.
 */
export default class extends Controller {
    static values = { base: String };

    connect() {
        this._editing = null; // { cell, original }
    }

    edit(event) {
        const cell = event.currentTarget;
        if (this._editing && this._editing.cell === cell) return;
        this._cancelActive();

        const id = cell.dataset.gvId;
        const field = cell.dataset.gvField;
        if (!id || !field) return;

        this._editing = { cell, original: cell.innerHTML };
        cell.classList.add('gv-editing');
        cell.innerHTML = '<span class="gv-inline-spinner"></span>';

        fetch(`${this.baseValue}/${id}/${field}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then((r) => r.text())
            .then((html) => {
                cell.innerHTML = html;
                this._focus(cell);
            })
            .catch(() => this._cancelActive());
    }

    submit(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        const cell = this._editing && this._editing.cell;
        if (!form || !cell) return;

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
        })
            .then(async (response) => {
                const text = await response.text();
                if (response.ok) {
                    cell.innerHTML = text;          // new display value
                    cell.classList.remove('gv-editing');
                    this._editing = null;
                } else {
                    cell.innerHTML = text;          // editor re-rendered with errors
                    this._focus(cell);
                }
            })
            .catch(() => this._cancelActive());
    }

    key(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this._cancelActive();
        } else if (event.key === 'Enter' && event.target.tagName !== 'TEXTAREA') {
            event.preventDefault();
            event.target.closest('form')?.requestSubmit();
        }
    }

    _focus(cell) {
        const input = cell.querySelector('[data-gridview-inline-edit-target="input"]');
        if (input) {
            input.focus();
            if (typeof input.select === 'function') {
                try { input.select(); } catch (_) { /* type without text selection */ }
            }
        }
    }

    _cancelActive() {
        if (!this._editing) return;
        this._editing.cell.innerHTML = this._editing.original;
        this._editing.cell.classList.remove('gv-editing');
        this._editing = null;
    }
}
