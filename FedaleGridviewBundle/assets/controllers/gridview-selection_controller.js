import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['checkbox', 'headerCheckbox'];
    static values  = { gridId: String };

    connect() {
        this._restore();
        this._syncHeader();
    }

    get _key()    { return `gv-sel-${this.gridIdValue}`; }
    get _allKey() { return `gv-sel-${this.gridIdValue}-all`; }

    _isAllMode() { return sessionStorage.getItem(this._allKey) === '1'; }

    _load() {
        return new Set(JSON.parse(sessionStorage.getItem(this._key) ?? '[]'));
    }

    _save(set) {
        sessionStorage.setItem(this._key, JSON.stringify([...set]));
    }

    // Ripristina le checkbox della pagina corrente.
    // In all-mode tutte le righe sono selezionate a prescindere dal Set.
    _restore() {
        if (this._isAllMode()) {
            this.checkboxTargets.forEach(cb => { cb.checked = true; });
        } else {
            const sel = this._load();
            this.checkboxTargets.forEach(cb => { cb.checked = sel.has(cb.value); });
        }
    }

    // Checkbox singola riga — esce dall'all-mode (stile Gmail)
    toggle(event) {
        const wasAllMode = this._isAllMode();
        sessionStorage.removeItem(this._allKey);
        const sel = this._load();
        if (wasAllMode) {
            // Popola il Set con tutte le visibili già selezionate come punto di partenza
            this.checkboxTargets.forEach(cb => { if (cb.checked) sel.add(cb.value); });
        }
        event.target.checked ? sel.add(event.target.value) : sel.delete(event.target.value);
        this._save(sel);
        this._syncHeader();
    }

    // Checkbox header: seleziona/deseleziona tutte le righe visibili (esce dall'all-mode)
    togglePage(event) {
        sessionStorage.removeItem(this._allKey);
        const sel = this._load();
        this.checkboxTargets.forEach(cb => {
            cb.checked = event.target.checked;
            event.target.checked ? sel.add(cb.value) : sel.delete(cb.value);
        });
        this._save(sel);
        this._syncHeader();
    }

    // Caret → "Seleziona visibili": aggiunge la pagina corrente, esce dall'all-mode
    selectVisible() {
        sessionStorage.removeItem(this._allKey);
        const sel = this._load();
        this.checkboxTargets.forEach(cb => { sel.add(cb.value); cb.checked = true; });
        this._save(sel);
        this._syncHeader();
    }

    // Caret → "Seleziona tutti i record": all-mode — ogni pagina caricata mostra tutte le checkbox selezionate
    selectAll() {
        sessionStorage.setItem(this._allKey, '1');
        this.checkboxTargets.forEach(cb => { cb.checked = true; });
        this._syncHeader();
    }

    // Caret → "Deseleziona": azzera tutto
    deselectAll() {
        sessionStorage.removeItem(this._key);
        sessionStorage.removeItem(this._allKey);
        this.checkboxTargets.forEach(cb => { cb.checked = false; });
        this._syncHeader();
    }

    // Sincronizza la checkbox header
    _syncHeader() {
        if (!this.hasHeaderCheckboxTarget) return;
        const total   = this.checkboxTargets.length;
        const checked = this.checkboxTargets.filter(cb => cb.checked).length;
        this.headerCheckboxTarget.checked       = total > 0 && checked === total;
        this.headerCheckboxTarget.indeterminate = checked > 0 && checked < total;
    }
}
