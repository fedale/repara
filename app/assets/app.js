/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// Tabler ships its own Bootstrap, so we import Tabler instead of Bootstrap to
// avoid loading Bootstrap twice. Our own overrides stay last so they win.
import '@tabler/core/dist/css/tabler.min.css';
import './styles/app.css';

// Enable Bootstrap's data-api for the Tabler header: dropdowns (menu groups)
// and collapse (mobile navbar toggler). Import the package root (ESM bundle) so
// we share the single Bootstrap instance our controllers already use via
// `import { Modal } from 'bootstrap'`. Importing the per-component UMD subpaths
// instead pulls in a SECOND copy, whose duplicate data-api handlers open and
// then immediately close every dropdown on the same click.
import 'bootstrap';

// start the Stimulus application
import './bootstrap';

import '@hotwired/turbo';
