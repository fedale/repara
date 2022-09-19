import { Controller } from '@hotwired/stimulus';
import { Tooltip } from 'bootstrap';

export default class extends Controller {

    static targets = ['tooltip'];

    connect() {
       let tooltips = this.tooltipTargets;
       tooltips.map(function (tooltipTriggerEl) {
             let options = {
                 delay: {show: 50, hide: 50},
                 html: tooltipTriggerEl.getAttribute("data-bs-html") === "true" ?? false,
                 placement: tooltipTriggerEl.getAttribute('data-bs-placement') ?? 'auto'
             };
             return new Tooltip(tooltipTriggerEl, options);
        });
    }
 }