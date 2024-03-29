import { Controller } from '@hotwired/stimulus';


export default class extends Controller {

    static targets = ['checkbox'];

    connect() {
        console.log('Filter-form');
        this.checkboxTargets.forEach(filterCheckbox => {
            filterCheckbox.addEventListener('change', () => {
                const filterToggleLink = filterCheckbox.nextElementSibling;
                const filterExpandedAttribute = filterCheckbox.nextElementSibling.getAttribute('aria-expanded');

                if ((filterCheckbox.checked && 'false' === filterExpandedAttribute) || (!filterCheckbox.checked && 'true' === filterExpandedAttribute)) {
                    filterToggleLink.click();
                }
            });
        });
    }
}