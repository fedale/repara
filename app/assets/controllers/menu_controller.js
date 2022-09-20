import { Controller } from '@hotwired/stimulus';


export default class extends Controller {

    static targets = ['dropdown'];

    connect() {
       let dropdowns = this.dropdownTargets;
       dropdowns.map( (dropdown) => {
            for (const child of dropdown.children) {
                if (child.classList.contains('active')) {
                    dropdown.parentElement.classList.add('active')  ;
                }
            }
        })
    }

 }
