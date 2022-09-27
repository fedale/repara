import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

export default class extends Controller {

    static targets = ['button', 'modal', 'modalBody', 'filterField'];

    static values = {
        url: String
    }

    connect () {
        let filterButton = this.buttonTarget;
        filterButton.setAttribute('href', filterButton.getAttribute('data-href'));
        filterButton.removeAttribute('data-href');
        filterButton.classList.remove('disabled');
    }

    openModal(event) {
        this.modalBodyTarget.innerHTML = '<div class="fa-3x px-3 py-3 text-muted text-center"><i class="fas fa-circle-notch fa-spin"></i></div>';
        const modal = new Modal(this.modalTarget);
        modal.show();

        fetch(this.buttonTarget.getAttribute('href'))
                .then((response) => { return response.text(); })
                .then((text) => {
                    this.modalBodyTarget.innerHTML = text;
                    // this.#createAutoCompleteFields();
                    // this.#createFilterToggles();
                })
                .catch((error) => { console.error(error); });
        event.preventDefault();
    }

    submitForm(event) {
        const form = this.modalBodyTarget.getElementsByTagName('form')[0];
        form.submit();
    }

    clearForm(event) {
        this.filterFieldTargets.forEach( (filterField) => {
            console.log(filterField);
            filterField.closest('form').querySelectorAll(`input[name^="filters[${filterField.dataset.filterProperty}]"]`).forEach((filterFieldInput) => {
                filterFieldInput.remove();
            });
        
            filterField.remove();
        });
        const form = this.modalBodyTarget.getElementsByTagName('form')[0];
        form.submit();
    }

 }

 const removeFilter = (filterField) => {
    filterField.closest('form').querySelectorAll(`input[name^="filters[${filterField.dataset.filterProperty}]"]`).forEach((filterFieldInput) => {
        filterFieldInput.remove();
    });

    filterField.remove();
};