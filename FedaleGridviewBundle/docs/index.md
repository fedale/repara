# FedaleGridviewBundle — Documentation

A Symfony bundle for rendering configurable data grids, inspired by the Yii 2 GridView widget.
The grid is not automagic: you configure a data source and a column list, the bundle does the rest.

---

## Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Data Provider](#data-provider)
4. [Columns](#columns)
5. [Sorting](#sorting)
6. [Pagination](#pagination)
7. [Filtering & Search](#filtering--search)
8. [Layout System](#layout-system)
9. [Attributes & Styling](#attributes--styling)
10. [YAML Configuration](#yaml-configuration)
11. [JavaScript Controllers](#javascript-controllers)
12. [Extending the Bundle](#extending-the-bundle)

---

## Overview

FedaleGridviewBundle renders paginated, sortable, filterable HTML tables inside a Symfony application.
It integrates with:

- **Doctrine ORM** (entity-based data providers)
- **Symfony Forms** (filter forms via `SearchModel`)
- **Turbo / Hotwired** (frame-based partial reloads, zero full-page refreshes by default)
- **Stimulus** (JS controllers for filters, row selection, column visibility)

The entry point is always a `GridviewBuilder` chain called from a controller action.

---

## Quick Start

### 1. Inject the builder factory

```php
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;

class CustomerController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
    ) {}

    private function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
```

### 2. Build the grid in a controller action

```php
#[Route('/customers', name: 'customer_list', methods: ['GET'])]
public function list(Request $request): Response
{
    $dataProvider = [
        'models'     => Customer::class,
        'pagination' => ['defaultPageSize' => 25],
        'sort'       => [
            'name' => ['asc' => ['c.name'], 'desc' => ['c.name'], 'default' => 'asc'],
            'email' => ['asc' => ['c.email'], 'desc' => ['c.email'], 'default' => 'asc'],
        ],
    ];

    $columns = [
        'id',
        'name',
        'email',
    ];

    $gridview = $this->createGridviewBuilder()
        ->setDataProvider($dataProvider)
        ->setColumns($columns)
        ->renderGridview();

    return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);
}
```

### 3. The Twig template

The bundle ships with a default layout template. Your page template only needs to include it:

```twig
{# templates/customer/list.html.twig #}
{% extends 'base.html.twig' %}

{% block body %}
    {# The grid renders itself — no extra Twig code needed here. #}
{% endblock %}
```

> The default template passed to `renderGrid()` is `@FedaleGridview/gridview/index.html.twig`.
> When a Turbo-Frame request arrives, the bundle automatically switches to the internal
> `_grid.html.twig` partial so only the table content is reloaded.

---

## Data Provider

The `dataProvider` array is passed to `setDataProvider()` and controls *where* data comes from,
*how many* rows to show, and *how* they can be sorted.

```php
$dataProvider = [
    'models'     => Customer::class,   // Doctrine entity class (full namespace)
    'pagination' => ['defaultPageSize' => 25],
    'sort'       => [...],             // see Sorting section
];
```

| Key | Type | Description |
|-----|------|-------------|
| `models` | `string` | Fully-qualified entity class name |
| `pagination` | `array` | Pagination options (see [Pagination](#pagination)) |
| `sort` | `array` | Sort attribute map (see [Sorting](#sorting)) |

---

## Columns

Each item in the `$columns` array can be a **string shorthand** or a **full array definition**.

### String shorthand

```php
$columns = [
    'id',           // renders $data['id'], header label = "id"
    'name',
    'email',
];
```

The shorthand format also accepts `attribute:twigFilter:label`:

```php
$columns = [
    'code:raw:Product Code',   // attribute=code, twigFilter=raw, label="Product Code"
];
```

### Full array definition

```php
$columns = [
    [
        'attribute' => 'email',
        'label'     => 'E-Mail',
        'value'     => function (array $data, string $key, ColumnInterface $column): string {
            return '<a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>';
        },
        'twigFilter' => 'raw',
        'visible'    => true,
        'filter'     => ['type' => 'text'],
    ],
];
```

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `attribute` | `string` | — | Field name in the data row (supports dot-notation: `profile.fullname`) |
| `label` | `string` | Same as `attribute` | Column header text |
| `value` | `Closure\|string\|null` | `null` | Custom cell value; closure receives `($data, $key, $column)` |
| `twigFilter` | `string\|null` | `null` | Any Twig filter applied to the rendered value (e.g. `raw`, `upper`, `date('d/m/Y')`) |
| `visible` | `bool` | `true` | Whether the column is rendered; `false` columns are hidden but toggleable via the UI |
| `filter` | `array\|null` | `null` | Column filter definition (requires a `SearchModel`) |
| `sortable` | `bool` | `true` | Whether clicking the header sorts the grid |
| `filterable` | `bool` | `true` | Whether the column shows a filter input |

### Column types

Pass `'type'` to use a non-data column:

```php
$columns = [
    ['type' => 'checkbox'],  // row selection checkboxes
    ['type' => 'serial'],    // sequential row numbers
    // ... data columns ...
    ['type' => 'action'],    // view / edit / delete links
];
```

| Type | Class | Description |
|------|-------|-------------|
| `data` | `DataColumn` | Default. Renders a scalar or closure value |
| `checkbox` | `CheckboxColumn` | Row selection with header toggle; not sortable or filterable |
| `serial` | `SerialColumn` | Auto-incrementing row index |
| `action` | `ActionColumn` | View / update / delete action links |
| `boolean` | `BooleanColumn` | Renders `✓` / `✗` for truthy/falsy values |

### Registering custom column types

Third-party code can register new column types through `ColumnFactory::register()`.
The typical place is a Symfony `CompilerPass` or a bundle's `boot()` method:

```php
// src/MyBundle/DependencyInjection/RegisterColumnsPass.php
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class RegisterColumnsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $factory = $container->findDefinition('fedale_gridview.column_factory');
        $factory->addMethodCall('register', ['badge', BadgeColumn::class]);
    }
}
```

Or at runtime before calling `setColumns()`:

```php
$factory->register('badge', BadgeColumn::class);
```

`BadgeColumn` must implement `Fedale\GridviewBundle\Column\ColumnInterface`.

### Dot-notation for nested data

When the data row contains nested arrays (e.g. from a JOIN), use dot-notation in `attribute`:

```php
[
    'attribute' => 'profile.fullname',
    'label'     => 'Full Name',
],
```

Or use a `value` closure for full control:

```php
[
    'attribute' => 'profile_fullname',
    'label'     => 'Full Name',
    'value'     => function (array $data, string $key, ColumnInterface $column): string {
        return $data['profile']['firstname'] . ' ' . $data['profile']['lastname'];
    },
],
```

### Returning arrays from `value`

When `value` returns an array, combine it with a compound `twigFilter`:

```php
[
    'attribute'  => 'locations',
    'label'      => 'Locations',
    'value'      => function (array $data, string $key, ColumnInterface $column): array {
        return array_map(
            fn($loc) => '<a href="/location/' . $loc['id'] . '">' . $loc['zipcode'] . '</a>',
            $data['locations']
        );
    },
    'twigFilter' => "join(', ', ' and ')|raw",
],
```

---

## Sorting

Sorting is declared in the `sort` key of the data provider array. Each entry maps a **sort name**
(used in the URL query string) to the Doctrine ORDER BY fields.

```php
$dataProvider = [
    'models' => Customer::class,
    'sort'   => [
        'name' => [
            'asc'     => ['c.name'],           // ORDER BY c.name ASC
            'desc'    => ['c.name'],            // ORDER BY c.name DESC
            'default' => 'asc',
            'label'   => 'Customer Name',       // optional, overrides column label in the link
        ],
        'email' => [
            'asc'     => ['c.email'],
            'desc'    => ['c.email'],
            'default' => 'asc',
        ],
        'fullname' => [                         // sort by multiple fields
            'asc'     => ['p.firstname', 'p.lastname'],
            'desc'    => ['p.firstname', 'p.lastname'],
            'default' => 'asc',
            'label'   => 'Full Name',
        ],
    ],
];
```

A `DataColumn` whose `label` (or `attribute`) matches a key in the sort map automatically
renders its header as a clickable sort link. Clicking toggles `asc` ↔ `desc`. The current
direction is reflected in the `?sort=` query parameter.

---

## Pagination

Pagination attributes are passed inside the data provider:

```php
$dataProvider = [
    'models'     => Customer::class,
    'pagination' => [
        'defaultPageSize' => 25,
    ],
];
```

The `{pagination}` token in the footer layout renders the page navigation links.
To remove pagination entirely, omit the token from the footer layout:

```php
->setOptions(['layout' => ['footer' => '']])
```

---

## Filtering & Search

Column filters require a **SearchModel** — a class that extends
`Fedale\GridviewBundle\Service\SearchModel`.

### Enabling filters

```php
// In the controller
$gridview = $this->createGridviewBuilder()
    ->setSearchModel($this->customerSearchModel)  // inject via constructor or autowiring
    ->setDataProvider($dataProvider)
    ->setColumns($columns)
    ->renderGridview();
```

### Declaring filter inputs in columns

```php
$columns = [
    [
        'attribute' => 'name',
        'label'     => 'Name',
        'filter'    => ['type' => 'text'],
    ],
    [
        'attribute' => 'status',
        'label'     => 'Status',
        'filter'    => [
            'type'    => 'select',
            'options' => ['active' => 'Active', 'inactive' => 'Inactive'],
        ],
    ],
];
```

Supported filter types: `text`, `select`.

### Global search

Global search adds a single text input that queries multiple fields at once.
Declare the DQL fields to search and add the `{globalSearch}` token to the header layout:

```php
->setOptions([
    'globalSearch' => ['c.name', 'c.email', 'c.code'],
    'layout' => [
        'header' => '{globalSearch}',
    ],
])
```

The search field auto-submits with a 300 ms debounce via the `gridview-filter` Stimulus
controller. Matched text is highlighted in the rendered rows with a `<mark>` element.

---

## Layout System

The grid renders via a **token-based layout**. Each section is a string of `{token}`
placeholders that resolve to a Twig template file.

### Default layout

```
gridview: "{header} {table} {footer}"
header:   "{globalSearch}"
table:    "{thead} {filter} {tbody} {tfoot}"    ← computed from showThead/showTfoot
footer:   "{pagination}"
toolbar:  ""                                    ← opt-in, empty by default
tfoot:    ""
```

### Available tokens

| Token | Template | Notes |
|-------|----------|-------|
| `{header}` | `sections/header.html.twig` | Wrapper above the table |
| `{toolbar}` | `sections/toolbar.html.twig` | Opt-in toolbar area |
| `{table}` | `sections/table.html.twig` | The `<table>` element |
| `{footer}` | `sections/footer.html.twig` | Wrapper below the table |
| `{thead}` | `sections/thead.html.twig` | Column header row |
| `{filter}` | `sections/filter.html.twig` | Column filter inputs row |
| `{tbody}` | `sections/tbody.html.twig` | Data rows |
| `{tfoot}` | `sections/tfoot.html.twig` | Table footer row |
| `{globalSearch}` | `sections/globalSearch.html.twig` | Global search input |
| `{pagination}` | `sections/pagination.html.twig` | Page navigation |
| `{addButton}` | `sections/addButton.html.twig` | "Add" link (requires `addRoute`) |
| `{columnVisibility}` | `sections/columnVisibility.html.twig` | Column show/hide dropdown |
| `{empty}` | `sections/empty.html.twig` | "No records found" row |

### Customising the layout at runtime

Pass a `layout` key inside `setOptions()`:

```php
->setOptions([
    'layout' => [
        'gridview' => '{toolbar} {header} {table} {footer}',
        'toolbar'  => '{addButton} {columnVisibility}',
        'header'   => '{globalSearch}',
        'footer'   => '{pagination}',
    ],
    'addRoute' => 'customer_new',
    'addLabel' => 'New Customer',
])
```

### Overriding individual section templates

Point a token to a custom Twig template:

```php
->setOptions([
    'layout' => [
        'templates' => [
            'header' => '@App/gridview/custom_header.html.twig',
            'empty'  => '@App/gridview/no_results.html.twig',
        ],
    ],
])
```

### Inline slots

For small snippets that do not justify a separate template file, use **slots**:

```php
->setOptions([
    'layout' => [
        'toolbar' => '{addButton} {recordCount}',
        'slots'   => [
            'recordCount' => '<span class="badge bg-secondary">{{ models|length }} records</span>',
        ],
    ],
])
```

Slot content is rendered as a Twig template with full access to the grid context
(`gridview`, `models`, `columns`, `pagination`, `form`).

### Hiding thead / tfoot without editing layout

Two boolean options control whether `{thead}` and `{tfoot}` are included when `table` layout
is computed automatically (i.e. when `table` is `null`):

```php
->setOptions([
    'showThead' => true,   // default
    'showTfoot' => false,  // removes tfoot from the table
])
```

---

## Attributes & Styling

HTML attributes for the table and its surrounding elements are set via `setAttributes()`:

```php
->setAttributes([
    'class'     => 'table table-striped table-hover',  // <table> class
    'container' => [
        'class'     => 'table-responsive',
        'data-type' => 'my-grid',
    ],
    'header'    => ['class' => 'gridview-header'],
    'filter'    => ['class' => 'gridview-filter'],
    'row'       => ['class' => 'clickable-row'],
])
```

| Key | Target element |
|-----|---------------|
| `class` | `<table>` element |
| `container` | Div wrapping the entire grid |
| `header` | Div wrapping the header section |
| `filter` | `<tr>` containing filter inputs |
| `row` | Every `<tr>` in the tbody |

---

## YAML Configuration

Global defaults and per-grid presets live in `config/packages/gridview.yaml`.
Runtime calls to `setOptions()` and `setAttributes()` override these values — they are merged,
not replaced.

### Global defaults

```yaml
# config/packages/gridview.yaml
fedale_gridview:
  defaults:
    options:
      emptyText:  "No records found"
      useTurbo:   true
      showThead:  true
      showTfoot:  true
      layout:
        gridview: "{header} {table} {footer}"
        header:   "{globalSearch}"
        footer:   "{pagination}"
    attributes:
      class: "table table-striped"
      container:
        class: "table-responsive"
```

### Per-grid presets

Register a named preset under `gridviews`, then pass the matching ID to the builder:

```yaml
fedale_gridview:
  gridviews:
    customer_list:
      options:
        globalSearch: ["c.name", "c.email"]
        layout:
          toolbar: "{addButton} {columnVisibility}"
          gridview: "{toolbar} {header} {table} {footer}"
      attributes:
        class: "table table-dark"
        row:
          class: "customer-row"
```

```php
// In the controller — the 'customer_list' preset is merged automatically
$gridview = $this->createGridviewBuilder()
    ->setId('customer_list')
    ->setDataProvider($dataProvider)
    ->setColumns($columns)
    ->renderGridview();
```

### All available options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `emptyText` | `string` | `'No records found'` | Text shown when there are no data rows |
| `useTurbo` | `bool` | `true` | Wrap the grid in a Turbo Frame and respond with partial HTML on frame requests |
| `showThead` | `bool` | `true` | Include `{thead}` in the auto-computed table layout |
| `showTfoot` | `bool` | `true` | Include `{tfoot}` in the auto-computed table layout |
| `globalSearch` | `string[]` | `[]` | DQL fields searched by the global search input |
| `addRoute` | `string\|null` | `null` | Route name for the `{addButton}` token |
| `addLabel` | `string` | `'Add'` | Label for the `{addButton}` link |
| `formName` | `string` | `'myform'` | Name of the filter form; change this to support multiple grids with filters on the same page |
| `caption` | `string\|null` | `null` | Optional `<caption>` text for the table |
| `layout` | `array` | see above | Layout token strings, template overrides, and inline slots |

### Multiple grids with filters on the same page

When you render two grids that both have column filters, each must use a unique `formName`
so their filter query parameters do not collide:

```php
// First grid
$this->createGridviewBuilder()
    ->setOptions(['formName' => 'order_filters'])
    ->setSearchModel($orderSearchModel)
    ->setColumns([...])
    ...

// Second grid on the same page
$this->createGridviewBuilder()
    ->setOptions(['formName' => 'product_filters'])
    ->setSearchModel($productSearchModel)
    ->setColumns([...])
    ...
```

> **Note:** the `SearchForm` builds its Symfony form with the configured `formName`.
> Each grid instance receives its own `SearchForm`, so their form submissions are independent.

### Merge precedence (lowest → highest)

1. Built-in code defaults (`Gridview::$options`)
2. `fedale_gridview.defaults` (YAML)
3. `fedale_gridview.gridviews.<id>` (YAML)
4. `setOptions()` / `setAttributes()` calls (runtime)

---

## JavaScript Controllers

The bundle ships three Stimulus controllers located in
`FedaleGridviewBundle/assets/controllers/`.

Register them in your app's `controllers.json` (or import them in `bootstrap.js`).

### `gridview-filter`

Auto-submits the filter form after a 300 ms debounce on every `input` event.
Also restores focus to the last active input after a Turbo-Frame swap, and highlights
matched search terms in the rendered rows.

**Connects to:** the `<form>` element wrapping the grid.

**Values:**

| Value | Type | Default | Description |
|-------|------|---------|-------------|
| `delay` | `Number` | `300` | Debounce delay in milliseconds |

**Usage (auto-applied by the bundle):**

```html
<form data-controller="gridview-filter" data-turbo-action="replace">
  ...
</form>
```

---

### `gridview-selection`

Manages row selection state across paginated pages using `sessionStorage`.
Supports three selection modes: current page, visible rows, and all records.

**Connects to:** the container div wrapping the grid (applied when a `CheckboxColumn` is present).

**Values:**

| Value | Type | Description |
|-------|------|-------------|
| `gridId` | `String` | Unique grid key (set automatically) |

**Targets:**

| Target | Element | Description |
|--------|---------|-------------|
| `checkbox` | `<input type="checkbox">` in each data row | Row checkbox |
| `headerCheckbox` | `<input type="checkbox">` in the header | Select-all checkbox |

**Actions available in templates:**

| Action | Description |
|--------|-------------|
| `gridview-selection#toggle` | Toggle a single row (exits all-mode) |
| `gridview-selection#togglePage` | Toggle all visible rows on the current page |
| `gridview-selection#selectAll` | Enter all-mode (all pages, all records) |
| `gridview-selection#selectVisible` | Add all visible rows to selection |
| `gridview-selection#deselectAll` | Clear selection completely |

**Session storage keys:**

| Key | Content |
|-----|---------|
| `gv-sel-{gridId}` | JSON array of selected row IDs |
| `gv-sel-{gridId}-all` | `"1"` when in all-mode |

---

### `gridview-visibility`

Toggles column visibility client-side and persists the state in `sessionStorage`.
Hidden columns retain their DOM nodes with `display:none` so the column count stays
consistent for colspan calculations.

**Connects to:** the `{columnVisibility}` section template.

**Values:**

| Value | Type | Description |
|-------|------|-------------|
| `gridId` | `String` | Unique grid key (set automatically) |

**Targets:**

| Target | Element |
|--------|---------|
| `menu` | The dropdown `<ul>` |

**Session storage key:** `gv-vis-{gridId}`

**Scope selectors used internally:**

```
table[data-gv="{gridId}"] [data-col="{colIndex}"]
```

Every cell (`<th>`, `<td>`) rendered by the bundle carries `data-col="{colIndex}"` and the
`<table>` element carries `data-gv="{gridId}"`, which is how the controller targets cells
for a specific column without touching other tables on the page.

**Columns that are not toggleable** (`CheckboxColumn`, `ActionColumn`) are excluded from the
dropdown automatically because their `isToggleable()` method returns `false`.

#### Declaring a column hidden by default

```php
$columns = [
    [
        'attribute' => 'internal_notes',
        'label'     => 'Notes',
        'visible'   => false,   // hidden on load, toggleable in the dropdown
    ],
];
```

---

## Full Example

A complete controller action combining the most common features:

```php
#[Route('/customers', name: 'customer_list', methods: ['GET'])]
public function list(Request $request): Response
{
    $dataProvider = [
        'models'     => Customer::class,
        'pagination' => ['defaultPageSize' => 25],
        'sort'       => [
            'name'  => ['asc' => ['c.name'],  'desc' => ['c.name'],  'default' => 'asc'],
            'email' => ['asc' => ['c.email'], 'desc' => ['c.email'], 'default' => 'asc'],
        ],
    ];

    $columns = [
        ['type' => 'checkbox'],
        'id',
        [
            'attribute' => 'name',
            'label'     => 'Full Name',
            'filter'    => ['type' => 'text'],
        ],
        [
            'attribute'  => 'email',
            'label'      => 'E-Mail',
            'value'      => fn(array $data) => '<a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>',
            'twigFilter' => 'raw',
            'filter'     => ['type' => 'text'],
        ],
        [
            'attribute' => 'internal_notes',
            'label'     => 'Notes',
            'visible'   => false,
        ],
        ['type' => 'action'],
    ];

    $gridview = $this->createGridviewBuilder()
        ->setId('customer_list')                          // uses YAML preset if defined
        ->setSearchModel($this->customerSearchModel)
        ->setOptions([
            'globalSearch' => ['c.name', 'c.email'],
            'addRoute'     => 'customer_new',
            'addLabel'     => 'New Customer',
            'layout'       => [
                'gridview' => '{toolbar} {header} {table} {footer}',
                'toolbar'  => '{addButton} {columnVisibility}',
                'header'   => '{globalSearch}',
                'footer'   => '{pagination}',
            ],
        ])
        ->setAttributes([
            'class'     => 'table table-striped',
            'container' => ['class' => 'table-responsive'],
        ])
        ->setDataProvider($dataProvider)
        ->setColumns($columns)
        ->renderGridview();

    return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);
}
```

---

## Extending the Bundle

### Public interfaces

All extension points are backed by PHP interfaces. Depend on these when building integrations
rather than on the concrete classes:

| Interface | Namespace | Stable |
|-----------|-----------|--------|
| `GridviewInterface` | `Fedale\GridviewBundle\Grid` | ✓ |
| `GridviewBuilderInterface` | `Fedale\GridviewBundle\Grid` | ✓ |
| `ColumnInterface` | `Fedale\GridviewBundle\Column` | ✓ |
| `DataProviderInterface` | `Fedale\GridviewBundle\DataProvider` | ✓ |
| `SortInterface` | `Fedale\GridviewBundle\Component` | ✓ |
| `PaginationInterface` | `Fedale\GridviewBundle\Component` | ✓ |
| `SearchFormInterface` | `Fedale\GridviewBundle\Service` | ✓ |
| `SearchModelInterface` | `Fedale\GridviewBundle\Service` | ✓ |

### Creating a custom column

1. Implement `ColumnInterface` (or extend `AbstractColumn` for convenience).
2. Register the type with `ColumnFactory`.

```php
// src/Column/StatusBadgeColumn.php
namespace App\Column;

use Fedale\GridviewBundle\Column\AbstractColumn;

class StatusBadgeColumn extends AbstractColumn
{
    public function __construct(
        private \Fedale\GridviewBundle\Grid\Gridview $gridview,
        private string $attribute,
        protected ?string $twigFilter = 'raw',
        protected ?string $label = null,
        protected ?array $options = [],
    ) {
        $this->sortable = false;
    }

    public function getAttribute(): string { return $this->attribute; }

    public function render(mixed $row, int $_index): mixed
    {
        $value = $row->data[$this->attribute] ?? null;
        $class = match ($value) {
            'active'   => 'bg-success',
            'inactive' => 'bg-secondary',
            default    => 'bg-warning',
        };
        return sprintf('<span class="badge %s">%s</span>', $class, htmlspecialchars((string) $value));
    }
}
```

Register via a compiler pass, then use in a controller:

```php
// config/services.yaml
services:
    App\Column\StatusBadgeColumn:
        tags:
            - { name: fedale_gridview.column, type: status_badge }

// In a controller:
$columns = [
    ['type' => 'status_badge', 'attribute' => 'status', 'label' => 'Status'],
];
```

Or register directly via `ColumnFactory::register()`:

```php
$columnFactory->register('status_badge', StatusBadgeColumn::class);
```

### Listening to row events

`RowEvent` is dispatched twice for every data row — before and after it is added to the
collection. Use a Symfony event subscriber to modify row data or HTML attributes:

```php
// src/EventSubscriber/MyRowSubscriber.php
use Fedale\GridviewBundle\Event\RowEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyRowSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            RowEvent::BEFORE_ROW => 'onBeforeRow',
        ];
    }

    public function onBeforeRow(RowEvent $event): void
    {
        // Highlight overdue rows
        if (($event->row->data['due_date'] ?? null) < new \DateTimeImmutable()) {
            $event->row->setAttr('class', 'table-danger');
        }
    }
}
```

Tag the subscriber with `kernel.event_subscriber` or rely on Symfony's autoconfigure.
