import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['button', 'modalBody'];

    static values = {
        tm: String
    }

    initialize () {
        this.element;
    }

    connect() {
        let filterButton = this.buttonTarget;
        // this.filterModal = filterButton.getAttribute('data-bs-target');
        // console.log(this.filterModal);
        console.log('tmValue: ' + this.tmValue);
        filterButton.setAttribute('href', filterButton.getAttribute('data-href'));
        filterButton.removeAttribute('data-href');
        filterButton.classList.remove('disabled');
    }

    showModal() {
        const filterModal = this.buttonTarget.getAttribute('data-bs-target');
        console.log(filterModal);
        const filterModalBody = filterModal.querySelector('.modal-body');
        this.modalBodyTarget.innerHTML = '<div class="fa-3x px-3 py-3 text-muted text-center"><i class="fas fa-circle-notch fa-spin"></i></div>';
        // filterModalBody.innerHTML = '<div class="fa-3x px-3 py-3 text-muted text-center"><i class="fas fa-circle-notch fa-spin"></i></div>';

        fetch(this.buttonTarget.getAttribute('href'))
                .then((response) => { return response.text(); })
                .then((text) => {
                    filterModalBody.innerHTML = text;
                    console.log(text);
                    // this.#createAutoCompleteFields();
                    // this.#createFilterToggles();
                })
                .catch((error) => { console.error(error); });
    }
 }
