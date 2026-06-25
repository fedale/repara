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
        const root = document.documentElement;
        // Bootstrap-native components key off data-bs-theme; Tabler (beta11)
        // keys its own dark styles off the .theme-dark class. Set both so the
        // whole page — including Tabler chrome like the navbar — follows.
        root.setAttribute('data-bs-theme', theme);
        root.classList.toggle('theme-dark', theme === 'dark');
        root.classList.toggle('theme-light', theme === 'light');
        localStorage.setItem(STORAGE_KEY, theme);
        if (this.hasIconTarget) {
            this.iconTarget.textContent = theme === 'dark' ? '☀' : '☽';
        }
    }
}
