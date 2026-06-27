import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

import GridviewI18nController from '../../FedaleGridviewBundle/assets/controllers/gridview-i18n_controller.js';
app.register('gridview-i18n', GridviewI18nController);

import GridviewLocaleSwitcherController from '../../FedaleGridviewBundle/assets/controllers/gridview-locale-switcher_controller.js';
app.register('gridview-locale-switcher', GridviewLocaleSwitcherController);

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

import GridviewInlineEditController from '../../FedaleGridviewBundle/assets/controllers/gridview-inline-edit_controller.js';
app.register('gridview-inline-edit', GridviewInlineEditController);

import GridviewSavedSearchController from '../../FedaleGridviewBundle/assets/controllers/gridview-saved-search_controller.js';
app.register('gridview-saved-search', GridviewSavedSearchController);

import GridviewColumnOrderController from '../../FedaleGridviewBundle/assets/controllers/gridview-column-order_controller.js';
app.register('gridview-column-order', GridviewColumnOrderController);

import GridviewMercureController from '../../FedaleGridviewBundle/assets/controllers/gridview-mercure_controller.js';
app.register('gridview-mercure', GridviewMercureController);

import GridviewResponsiveController from '../../FedaleGridviewBundle/assets/controllers/gridview-responsive_controller.js';
app.register('gridview-responsive', GridviewResponsiveController);

import GridviewInfiniteScrollController from '../../FedaleGridviewBundle/assets/controllers/gridview-infinite-scroll_controller.js';
app.register('gridview-infinite-scroll', GridviewInfiniteScrollController);

import GridviewDropdownController from '../../FedaleGridviewBundle/assets/controllers/gridview-dropdown_controller.js';
app.register('gridview-dropdown', GridviewDropdownController);
