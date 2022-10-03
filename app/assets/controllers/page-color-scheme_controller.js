import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        scheme: String,
    }

    static targets = ['schemeSelector']

    initialize() {
        this.colorSchemeLocalStorageKey = 'ea/colorScheme';
    }

    connect() {
        const selectedColorScheme = localStorage.getItem(this.colorSchemeLocalStorageKey) || 'auto';
        this.setColorScheme(selectedColorScheme);
        this.schemeSelectorTargets.forEach(element => {
            element.classList.remove('active');
            if (element.getAttribute('data-ea-color-scheme') == selectedColorScheme ) {
                element.classList.add('active');
            }
        });
    }

    changeScheme(event) {
        this.currentScheme = event.currentTarget.getAttribute('data-ea-color-scheme');
        this.schemeSelectorTargets.forEach(element => {
            element.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
        this.setColorScheme(this.currentScheme);
    }

    updateColorScheme() {
        const selectedColorScheme = localStorage.getItem(this.colorSchemeLocalStorageKey) || 'auto';
        this.setColorScheme(selectedColorScheme);
    }

    setColorScheme(colorScheme) {
        if ('false' === document.body.getAttribute('data-ea-dark-scheme-is-enabled')) {
            return;
        }

        const resolvedColorScheme = 'auto' === colorScheme
            ? matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            : colorScheme;

        document.body.classList.remove('ea-light-scheme', 'ea-dark-scheme');
        document.body.classList.add('light' === resolvedColorScheme ? 'ea-light-scheme' : 'ea-dark-scheme');
        localStorage.setItem(this.colorSchemeLocalStorageKey, colorScheme);
        document.body.style.colorScheme = resolvedColorScheme;
    }

 }
