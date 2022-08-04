import { Controller } from '@hotwired/stimulus';


export default class extends Controller {

    static values = {
        select: String,
    }

    static targets = ['input', 'counterAll', 'counterSelected', 'counterNotSelected'];

    initialize () {
        this.update = this.update.bind(this);
    }

    connect() {
        this.update();
    }

    select(event) {
        event.preventDefault();
        
        const value = event.target.dataset.selectValue;
        switch (value) {
            case 'none':
                this.inputTargets.forEach( checkbox => {
                    checkbox.checked = false;
                });
            break;
            case 'inverse':
                this.inputTargets.forEach( checkbox => {
                    checkbox.checked = !checkbox.checked;
                });
            break;
            default:
            case 'all':
                this.inputTargets.forEach( checkbox => {
                    checkbox.checked = true;
                });
            break;
        }

        this.update();
    }

    selectGender(event) {
        event.preventDefault();
        const value = event.target.dataset.selectValue;
        this.inputTargets.forEach( checkbox => {
            console.log(checkbox.dataset.profileGender, value);
            if (checkbox.dataset.profileGender == value) {
                checkbox.checked = true;
            }  
        })

        this.update();
    }

    selectStatus(event) {
        event.preventDefault();
        const value = event.target.dataset.selectValue;
    }

    selectGroup(event) {
        event.preventDefault();
        const value = event.target.dataset.selectValue;
        
        this.inputTargets.forEach( checkbox => {
            const groups = JSON.parse(checkbox.dataset.groups.toLowerCase());
            if (groups.includes(value)) {
                checkbox.checked = true;
            }
            // With 'none' selected return checkbox with no groups
            if (value == 'none' && groups.length <= 0) {
                checkbox.checked = true;
            }
        })

        this.update();
    }

    view(event) {
        event.preventDefault();
        const value = event.target.dataset.selectValue;
        switch (value) {
            case 'selected':
                this.inputTargets.forEach( checkbox => {
                    checkbox.parentElement.style.display = 'none';
                    if (checkbox.checked) {
                        checkbox.parentElement.style.display = 'inline-block';
                    }
                });
            break;
            case 'not-selected':
                this.inputTargets.forEach( checkbox => {
                    checkbox.parentElement.style.display = 'none';
                    if (!checkbox.checked) {
                        checkbox.parentElement.style.display = 'inline-block';
                    }
                });
            break;
            default:
            case 'all':
                this.inputTargets.forEach( checkbox => {
                    checkbox.parentElement.style.display = 'inline-block';
                });
            break;
        }
    }

    search(event) {
        event.preventDefault();

        const needle = event.target.value;
        
        this.inputTargets.forEach( checkbox => {
            const haystack = checkbox.nextElementSibling.textContent;
            checkbox.parentElement.style.display = 'none';
            if (haystack.toLowerCase().includes(needle.toLowerCase())) {
                checkbox.parentElement.style.display = 'inline-block';
            }
        })
    }

    update() {
        this.counterAllTarget.innerHTML = this.countAll.toString();
        this.counterSelectedTarget.innerHTML = this.countSelected.toString();
        this.counterNotSelectedTarget.innerHTML = this.countNotSelected.toString();
    } 

    get countAll() {
        return this.inputTargets.length;
    }

    get countSelected() {
        let selected = 0;
        this.inputTargets.forEach( checkbox => {
            if (checkbox.checked) {
                selected++;
            }
        });

        return selected;
    }

    get countNotSelected() {
        let notSelected = 0;
        this.inputTargets.forEach( checkbox => {
            if (!checkbox.checked) {
                notSelected++;
            }
        });

        return notSelected;
    }
 }
