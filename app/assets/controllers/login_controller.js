import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ['input'];

    static values = {
        visible: Boolean
    }

    connect() {
    }

    toggle(event) {
        this.visibleValue = !this.visibleValue;
        let a = event.currentTarget;
        let i = a.firstElementChild;

        let input = this.inputTarget;
        if (this.visibleValue) {
            input.type = 'text';
            a.title = 'Hide password';
            i.className = 'fa-solid fa-eye';
        } else {
            input.type = 'password';
            a.title = 'Show password';
            i.className = 'fa-solid fa-eye-slash';
        }
    }

    visibleValueChanged(event) {
       
        
        
    }

 }