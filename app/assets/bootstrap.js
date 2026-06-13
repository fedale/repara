import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

import GridviewFilterController from '../../FedaleGridviewBundle/assets/controllers/gridview-filter_controller.js';
app.register('gridview-filter', GridviewFilterController);

import GridviewSelectionController from '../../FedaleGridviewBundle/assets/controllers/gridview-selection_controller.js';
app.register('gridview-selection', GridviewSelectionController);

import GridviewVisibilityController from '../../FedaleGridviewBundle/assets/controllers/gridview-visibility_controller.js';
app.register('gridview-visibility', GridviewVisibilityController);

import GridviewRelationFilterController from '../../FedaleGridviewBundle/assets/controllers/gridview-relation-filter_controller.js';
app.register('gridview-relation-filter', GridviewRelationFilterController);

import GridviewDateFilterController from '../../FedaleGridviewBundle/assets/controllers/gridview-date-filter_controller.js';
app.register('gridview-date-filter', GridviewDateFilterController);

import GridviewCrudController from '../../FedaleGridviewBundle/assets/controllers/gridview-crud_controller.js';
app.register('gridview-crud', GridviewCrudController);

import GridviewFormValidateController from '../../FedaleGridviewBundle/assets/controllers/gridview-form-validate_controller.js';
app.register('gridview-form-validate', GridviewFormValidateController);
