import { Controller } from '@hotwired/stimulus';

const STORAGE_KEY = 'color-theme';

export default class extends Controller {
    static targets = ['icon'];

    connect() {
        const saved = localStorage.getItem(STORAGE_KEY) || 'dark';
        this._apply(saved);
    }

    toggle() {
        const current = document.documentElement.getAttribute('data-bs-theme') || 'dark';
        this._apply(current === 'dark' ? 'light' : 'dark');
    }

    _apply(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem(STORAGE_KEY, theme);
        if (this.hasIconTarget) {
            this.iconTarget.textContent = theme === 'dark' ? '☀' : '☽';
        }
    }
}
