# FedaleGridviewBundle — Documentation

A Symfony bundle for rendering configurable data grids, inspired by the Yii 2 GridView widget.
The grid is not automagic: you configure a data source and a column list, the bundle does the rest.

---

## Table of Contents

1. [Overview](#overview)
2. [Quick Start](#quick-start)
3. [Data Provider](#data-provider)
4. [Columns](#columns) — [ActionColumn](#actioncolumn--token-based-actions)
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
| `filter` | `array\|bool\|null` | `null` | Column filter definition (requires a `SearchModel`). `true` enables a filter whose type is inherited from the column `type`; an array may set its own `type` to override it |
| `sortable` | `bool` | `true` | Whether clicking the header sorts the grid |
| `filterable` | `bool` | `true` | Whether the column shows a filter input |
| `filterBar` | `bool` | `false` | Render this column's filter in the `{filterBar}` section instead of inline in the header row |
| `headerMirror` | `bool` | `false` | Only with `filterBar: true` (text/number filters): also render a synced "mirror" input in the column header. Off by default → the filter lives **only** in the filterBar |

### Column types

The root `type` of a column has **two flavours**:

1. **Data types** — describe the *kind of data* the column holds. They render via
   `DataColumn` and, crucially, set the **default filter type** (see
   [Inheriting the filter type from the column](#inheriting-the-filter-type-from-the-column)).
   When `type` is omitted it defaults to **`text`**.
2. **Structural types** — dedicated column classes for non-data concerns (selection,
   numbering, actions).

```php
$columns = [
    ['type' => 'checkbox'],                       // structural: row selection
    ['type' => 'serial'],                         // structural: row numbers
    ['attribute' => 'email'],                     // data: text (the default)
    ['attribute' => 'active', 'type' => 'boolean'], // data: renders ✓/✗
    ['type' => 'action'],                         // structural: action links
];
```

**Data types** (rendered by `DataColumn`):

| Type | Renders as | Default filter |
|------|-----------|----------------|
| `text` | Raw scalar / closure value (**default** when `type` is omitted) | `text` |
| `boolean` | `✓` / `✗` for truthy / falsy values | `boolean` |
| `date` | Raw value (format it with `twigFilter`) | `date` |
| `number` | Raw value | `number` |
| `relation` | Raw value (use `value` to render the related label) | `relation` |
| `choice` | Raw value | `choice` |
| `data` | Raw value (legacy alias of `text`) | `text` |

**Structural types** (dedicated classes):

| Type | Class | Description |
|------|-------|-------------|
| `checkbox` | `CheckboxColumn` | Row selection with header toggle; not sortable or filterable |
| `serial` | `SerialColumn` | Auto-incrementing row index |
| `action` | `ActionColumn` | View / update / delete action links |

> A `value` closure always wins over the data type's built-in rendering — set
> `type: 'boolean'` for the ✓/✗ default, or supply your own `value` to override it.

### ActionColumn — token-based actions

`ActionColumn` renders per-row action buttons (view, edit, delete, or anything custom).
Which buttons appear is controlled by a **layout string** of `{token}` placeholders — the same
concept used for the grid layout system.

#### Default behaviour

```php
['type' => 'action']
// renders: {view} {edit} {delete}  — three placeholder <a> links
```

#### Controlling which buttons appear

Set `layout` to any combination of built-in or custom token names:

```php
['type' => 'action', 'layout' => '{view}']

['type' => 'action', 'layout' => '{edit} {delete}']

['type' => 'action', 'layout' => '{view} {archive} {delete}']
```

#### Custom button content

The `buttons` key maps token names to their rendering specification.
You can mix `ActionButton` objects, closures, plain HTML strings, or arrays:

```php
use Fedale\GridviewBundle\Column\ActionButton;

$columns = [
    [
        'type'    => 'action',
        'layout'  => '{view} {edit} {delete}',
        'buttons' => [
            // Closure — full control, receives the row data and row index
            'view' => new ActionButton(
                fn(array $row, int $i) => sprintf(
                    '<a href="/customers/%d" class="btn btn-sm btn-outline-primary">View</a>',
                    $row['id']
                )
            ),

            // Plain HTML string — static content
            'edit' => new ActionButton(
                '<a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>'
            ),

            // Array shorthand — no need to import ActionButton
            'delete' => [
                'content' => fn(array $row) => sprintf(
                    '<a href="/customers/%d/delete" class="btn btn-sm btn-danger">Delete</a>',
                    $row['id']
                ),
            ],
        ],
    ],
];
```

#### Role-based visibility

Pass a `roles` array to hide a button from users who lack **all listed roles**.
Only one role needs to match (OR logic). Requires the Symfony Security component.

```php
use Fedale\GridviewBundle\Column\ActionButton;

'buttons' => [
    'view' => new ActionButton(
        fn(array $row) => '<a href="/customers/' . $row['id'] . '">View</a>',
    ),

    // Shown only to ROLE_EDITOR or ROLE_ADMIN
    'edit' => new ActionButton(
        fn(array $row) => '<a href="/customers/' . $row['id'] . '/edit">Edit</a>',
        roles: ['ROLE_EDITOR', 'ROLE_ADMIN'],
    ),

    // Shown only to ROLE_ADMIN
    'delete' => new ActionButton(
        fn(array $row) => '<a href="/customers/' . $row['id'] . '/delete">Delete</a>',
        roles: ['ROLE_ADMIN'],
    ),
],
```

When the security component is not installed, the `roles` check is skipped and all
buttons are shown regardless.

#### Conditional visibility per row

Use the `visible` parameter (bool or closure) to show or hide a button based on row data:

```php
'edit' => new ActionButton(
    fn(array $row) => '<a href="/customers/' . $row['id'] . '/edit">Edit</a>',
    visible: fn(array $row, int $i) => $row['active'] === true,
),
```

#### Array shorthand (no import needed)

All `ActionButton` constructor options are available as array keys:

```php
'buttons' => [
    'delete' => [
        'content' => fn(array $row) => '<a href="/customers/' . $row['id'] . '/delete">Delete</a>',
        'roles'   => ['ROLE_ADMIN'],
        'visible' => fn(array $row) => $row['deletable'] === true,
    ],
],
```

#### Adding a completely custom action

Any token name works — just add a matching entry in `buttons`:

```php
[
    'type'    => 'action',
    'layout'  => '{view} {impersonate}',
    'buttons' => [
        'view'        => new ActionButton(fn($row) => '<a href="/customers/' . $row['id'] . '">View</a>'),
        'impersonate' => new ActionButton(
            fn($row) => '<a href="/?_switch_user=' . $row['email'] . '">Impersonate</a>',
            roles: ['ROLE_ALLOWED_TO_SWITCH'],
        ),
    ],
]
```

#### Summary of `ActionButton` constructor

```php
new ActionButton(
    content: string|\Closure,   // HTML string or fn(mixed $row, int $index): string
    roles:   string[],          // Symfony roles required (empty = always shown)
    visible: bool|\Closure,     // fn(mixed $row, int $index): bool, or plain bool
)
```

#### ActionColumn options reference

These keys are specific to `['type' => 'action']` and have no meaning for data columns
(`id`, `name`, `email`, …).

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `layout` | `string` | `'{view} {edit} {delete}'` | Token string controlling which buttons appear and in what order |
| `buttons` | `array` | built-in icon placeholders | Map of token name → `ActionButton`, callable, HTML string, or array spec |
| `label` | `string` | `'Actions'` | Column header text |

#### YAML configuration

Column definitions — including `layout` and `buttons` — **cannot be set from YAML**.
The YAML config (`fedale_gridview` in `gridview.yaml`) only covers grid-level `options`
(layout tokens, globalSearch, useTurbo, …) and `attributes`.

Columns must always be declared in PHP because they routinely contain closures (for `value`,
`visible`, `buttons`), which YAML cannot represent.

---

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

### Navigation UI

The pagination renders a **sliding window** of page numbers rather than every page, so a
50-page list never prints 50 buttons. Around the current page it shows `_window` pages per
side (2 by default → 5 numbers), framed by first / previous / next / last icon buttons and
ellipses when the window does not reach an edge:

```
« ‹ … 8 9 10 11 12 … › »
```

First/previous are disabled on page 1, next/last on the last page. Each piece carries a
dedicated CSS class so it can be targeted independently:

| Class | Element |
|-------|---------|
| `gv-pagination` | the `<ul>` wrapper |
| `gv-page-item` | every `<li>` |
| `gv-page-first` / `gv-page-prev` / `gv-page-next` / `gv-page-last` | icon buttons |
| `gv-page-number` | a numbered page |
| `gv-page-ellipsis` | the `…` separator (non-interactive) |
| `gv-page-jump` | the "jump to page" `<select>` wrapper |
| `gv-page-link` | the `<a>`/`<span>`/`<select>` inside each item |
| `gv-active` | the current page |
| `gv-disabled` | a disabled control |

### Jump-to-page select

For long lists a `<select>` lets the user jump directly to any page. It is controlled by the
`pagination` options:

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `pagination.pageSelect` | `bool` | `true` | Show the jump-to-page `<select>` |
| `pagination.pageSelectThreshold` | `int` | `10` | Minimum page count before the `<select>` appears |

```php
// Disable the select for this grid
->setOptions(['pagination' => ['pageSelect' => false]])

// Or only show it from 20 pages up
->setOptions(['pagination' => ['pageSelectThreshold' => 20]])
```

Each `<option>` value is the fully-built page URL, so navigation needs no client-side query
rebuilding — see the [`gridview-page-jump`](#gridview-page-jump) controller.

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

A filterable column needs a `filter` key. Additional options are passed under `options`
and forwarded directly to the underlying Symfony Form type.

```php
$columns = [
    [
        'attribute' => 'name',
        'filter'    => ['type' => 'text'],
    ],
    [
        'attribute' => 'active',
        'filter'    => ['type' => 'boolean'],
    ],
];
```

### Inheriting the filter type from the column

You rarely need to repeat the type: the filter **inherits the column's root `type`** by
default. Set `filter: true` (or an array without `type`) and the filter takes the column
type; the column `type` itself defaults to `text` when omitted.

```php
$columns = [
    // type defaults to "text" → text filter
    ['attribute' => 'name',   'filter' => true],

    // boolean cell (✓/✗) AND boolean filter — declared once
    ['attribute' => 'active', 'type' => 'boolean', 'filter' => true],

    // date filter inherited; options still allowed on the array form
    ['attribute' => 'createdAt', 'type' => 'date', 'filter' => true],

    // relation filter inherited, only the options are given
    ['attribute' => 'type', 'type' => 'relation',
     'filter' => ['options' => ['choices' => $choices, 'multiple' => true]]],
];
```

**A `filter.type` set explicitly always wins** over the column type. The two axes are
independent — the cell renders according to the column `type`, the filter according to its
resolved type. So a column left at the default `text` type but given a `boolean` filter
renders its cell as plain text while filtering as a boolean:

```php
// cell rendered as text, filter behaves as boolean
['attribute' => 'active', 'filter' => ['type' => 'boolean']]
```

### Default filter values

A filter can declare a `default` value so the grid opens **already filtered** on first
visit, with the filter input pre-filled accordingly:

```php
$columns = [
    [
        'attribute' => 'active',
        'filter'    => ['type' => 'boolean', 'default' => '1'],   // open on active rows
    ],
    [
        'attribute' => 'createdAt',
        'filter'    => ['type' => 'date', 'default' => ['from' => '2025-01-01', 'to' => null]],
    ],
];
```

**Accepted shapes per type** (validated at configuration time — an invalid shape throws
`InvalidArgumentException`):

| Filter type | `default` shape |
|-------------|-----------------|
| `text` | scalar, e.g. `'abc'` |
| `boolean` | `'1'`/`'0'` (also `1`, `0`, `true`, `false`) |
| `date` | `['from' => 'YYYY-MM-DD', 'to' => 'YYYY-MM-DD']` (either bound nullable) or the string shorthand `'YYYY-MM-DD'` (= `from`) |
| `number` | `['from' => 10, 'to' => 20]` (either bound nullable) or a numeric shorthand (= `from`) |
| `choice` / `relation` | scalar value, or an array of values when the filter has `'multiple' => true` |

**Semantics:**

- Defaults apply **only when the request carries no `myform` parameter at all** (first
  visit). A submitted GET form always sends every field — even empty ones — so a
  present-but-empty `myform` means *the user cleared the filter*, and the default is
  **not** reapplied.
- Sort and pagination links generated from a first visit carry no `myform` params, so
  defaults keep applying consistently while navigating.
- The default value also pre-fills the form input (via the form `data` option), so what
  the user sees always matches the applied query.
- For columns with dotted attributes (e.g. `t.name`) the default is keyed by the mangled
  param name (`t_name`), matching the submitted form field name.

### The filterBar — placing filters anywhere

By default a column filter is rendered inline in the table header row. Set
`filterBar: true` to render it in the dedicated `{filterBar}` section instead:

```php
$columns = [
    [
        'attribute' => 'profile_fullname',
        'filter'    => ['type' => 'text'],
        'filterBar' => true,           // → rendered in {filterBar}, not in the header
    ],
];
```

**The `{filterBar}` section can live anywhere on the page**, with whatever CSS you
like — including outside the grid itself (e.g. a page sidebar). The form and the
`<turbo-frame>` do **not** need to wrap the whole page: the filterBar widgets are
associated to the grid's form by id (`form="gv-form-{key}"`), so they belong to the
form even when rendered far from it. `FormData` / `requestSubmit` / `reset` include
them, and the debounced auto-submit-as-you-type still fires (a delegated listener
handles inputs rendered outside the controller's DOM).

Render it wherever you want via the token in the layout, or directly in a host
template:

```twig
{# In a page sidebar, outside the grid container #}
<aside class="my-sidebar">
    {{ gridview_include(gridview, 'filterBar') }}
</aside>
```

When the filterBar is placed outside the grid, drop `{filterBar}` from the grid's
internal `layout` so it is not rendered twice.

#### `headerMirror` — also show the filter in the column header

For `text` / `number` filters in the filterBar you can opt to **also** render a
synced "mirror" input in the column header, so users can type from either place:

```php
[
    'attribute'    => 'code',
    'filter'       => ['type' => 'text'],
    'filterBar'    => true,
    'headerMirror' => true,   // filterBar + a mirror input in the header
],
```

`headerMirror` is **off by default**: a `filterBar` filter lives only in the
filterBar. It has no effect on non-text/number filters (relation, boolean, date),
which are never mirrored.

### Filter types reference

#### `text`

A plain text input. Supports any operator prefix (e.g. `>= 100`, `like foo%`) and a
client-driven **wildcard** (see below).

```php
'filter' => ['type' => 'text']
```

**PHP form options** (`options` key — Symfony form type):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `placeholder` | `string` | `''` | Placeholder shown in the input (injected into `attr.placeholder`) |

```php
'filter' => ['type' => 'text', 'options' => ['placeholder' => 'Search by name…']]
```

**Applier options** (third tuple element of the `applyFilters()` map — query-side behavior):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `default_operator` | `string` | `'ilike'` | Operator used when the term has no prefix (case-insensitive contains) |
| `trim` | `bool` | `true` | Trim the submitted value before matching |
| `wildcard` | `string` | `'%'` | The char the **end user** types; its position drives the match |

**Client-driven wildcard.** When the user has not typed an explicit operator prefix, the
position of the wildcard char in their input shapes the query (case-insensitive `LIKE`):

| User types (wildcard `%`) | Match | SQL pattern |
|---------------------------|-------|-------------|
| `foo` | contains | `%foo%` |
| `%foo%` | contains | `%foo%` |
| `foo%` | starts-with | `foo%` |
| `%foo` | ends-with | `%foo` |
| `%%` (only wildcards) | no constraint | — |

The wildcard char(s) are stripped before matching; the SQL pattern always uses `%`. An
explicit operator prefix (`eq foo`, `like foo`, …) takes precedence — the wildcard char is
then kept verbatim. Change the char per column via the applier option, e.g. so users type
`*`:

```php
// In the repository applyFilters() map:
'code' => ['text', 'c.code', ['wildcard' => '*']],   // user types  cod*  → starts-with
'name' => ['text', 'p.name', ['trim' => false, 'default_operator' => 'eq']],
```

---

#### `boolean`

A `<select>` with two choices and an empty "show all" placeholder.
Submits `'1'` (true) or `'0'` (false) as string values.

```php
'filter' => ['type' => 'boolean']
```

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `true_label` | `string` | `'Sì'` | Label for the truthy option |
| `false_label` | `string` | `'No'` | Label for the falsy option |
| `placeholder` | `string` | `'–'` | Label for the empty "show all" option |

**Custom labels example:**

```php
[
    'attribute' => 'active',
    'label'     => 'Status',
    'filter'    => [
        'type'    => 'boolean',
        'options' => [
            'true_label'  => 'Active',
            'false_label' => 'Inactive',
        ],
    ],
    'value' => fn(array $data) => $data['active'] ? 'Active' : 'Inactive',
],
```

**Repository filter example** — the `boolean` applier casts `'1'`/`'0'` to a typed
Doctrine boolean parameter:

```php
$this->searchForm->applyFilters($qb, $params, [
    'active' => ['boolean', 'c.active'],
]);
```

<details><summary>Under the hood (manual equivalent)</summary>

```php
if (isset($params['active']) && $params['active'] !== '') {
    $qb->andWhere('c.active = :active')
       ->setParameter('active', $params['active'] === '1', \Doctrine\DBAL\Types\Types::BOOLEAN);
}
```
</details>

---

#### `choice`

A `<select>` built from a static choices array.

```php
'filter' => [
    'type'    => 'choice',
    'options' => [
        'choices' => ['Active' => 'active', 'Inactive' => 'inactive'],
    ],
]
```

Accepts all standard Symfony `ChoiceType` options under `options`.

---

#### `relation`

A multi-select (or single-select) for relation fields. Supports a built-in searchable
search input and optional AJAX loading.

```php
// Static choices + searchable input
'filter' => [
    'type'    => 'relation',
    'options' => [
        'choices'    => $locationChoices,   // ['Label' => id, ...]
        'multiple'   => true,
        'searchable' => true,
    ],
]

// AJAX loading
'filter' => [
    'type'    => 'relation',
    'options' => [
        'ajax_url'     => '/api/filter-options/locations',
        'option_label' => 'name',
        'option_value' => 'id',
        'multiple'     => true,
    ],
]
```

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `choices` | `array` | `[]` | Static `['Label' => value]` map |
| `multiple` | `bool` | `false` | Allow multiple selections |
| `searchable` | `bool` | `false` | Show a live-filter search input above the options |
| `ajax_url` | `string\|null` | `null` | URL that returns `[{"id":1,"name":"…"},…]` |
| `option_label` | `string` | `'name'` | JSON key used as option label (AJAX mode) |
| `option_value` | `string` | `'id'` | JSON key used as option value (AJAX mode) |

**Repository filter example** — the `relation` applier handles both single values (`=`)
and multi-select arrays (`IN`):

```php
$this->searchForm->applyFilters($qb, $params, [
    'locations' => ['relation', 'l.id'],
]);
```

<details><summary>Under the hood (manual equivalent)</summary>

```php
$this->searchForm->andFilterWhere($qb, ['in', 'l.id', $params['locations'] ?? []]);
```
</details>

---

#### `number`

Two text inputs rendered side by side as a from/to range.
Submits as `myform[field][from]` and `myform[field][to]`.

```php
'filter' => ['type' => 'number']
```

**PHP form options** (`options` key — Symfony form type):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `from_placeholder` | `string` | `'Min'` | Placeholder for the lower bound input |
| `to_placeholder` | `string` | `'Max'` | Placeholder for the upper bound input |

**Hybrid operator / range syntax.** Each bound is a plain text input, so besides a plain
number it also accepts an operator expression or a range — same spirit as the `text`
filter. A plain number keeps the range semantics (`from` → `>=`, `to` → `<=`); an operator
expression applies as-is. Bounds AND-combine.

| You type in a bound | Result |
|---------------------|--------|
| `10` (in `from`) | `>= 10` |
| `10` (in `to`) | `<= 10` |
| `>5`, `>=5`, `<5`, `<=5` | `>` / `>=` / `<` / `<=` 5 |
| `=10` | `= 10` |
| `!=10` / `<>10` | `<> 10` |
| `1-5` | `BETWEEN 1 AND 5` (bounds auto-sorted) |
| `>=-5` | `>= -5` (negative lower bound) |

Decimal commas are accepted (`2,5` → `2.5`). Range bounds must be non-negative (the default
`-` separator would clash with a leading minus — use `>=-5` for negatives). The example
`from = ">5"`, `to = "20"` yields `(5, 20]`.

**Applier options** (third tuple element of the `applyFilters()` map):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `range_separator` | `string` | `'-'` | Character splitting a `a<sep>b` range expression |

**Repository filter example** — the `number` applier validates both bounds, parses any
operator/range expression and applies the matching comparison(s):

```php
$this->searchForm->applyFilters($qb, $params, [
    'price' => ['number', 'p.price'],
    // custom range separator, so users can type "1:5":
    // 'price' => ['number', 'p.price', ['range_separator' => ':']],
]);
```

<details><summary>Under the hood (plain-number equivalent)</summary>

```php
$from = ($params['price']['from'] ?? '') !== '' ? (float)$params['price']['from'] : null;
$to   = ($params['price']['to']   ?? '') !== '' ? (float)$params['price']['to']   : null;
$this->searchForm->andFilterWhere($qb, ['gte', 'p.price', $from]);
$this->searchForm->andFilterWhere($qb, ['lte', 'p.price', $to]);
```
</details>

---

#### `date`

A **Flatpickr** calendar popup that replaces the two native `<input type="date">` fields.
Supports both single-date and date-range selection. Always submits ISO `YYYY-MM-DD` values
as `myform[field][from]` and `myform[field][to]`.

```php
'filter' => ['type' => 'date']   // range mode, Italian locale, d/m/Y display
```

**PHP form options** (`options` key — Symfony form type):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `from_placeholder` | `string` | `'Da'` | Placeholder on the underlying from input (shown before JS loads) |
| `to_placeholder` | `string` | `'A'` | Placeholder on the underlying to input |

**Client options** (`clientOptions` key — passed verbatim to Flatpickr):

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `mode` | `string` | `'range'` | `'single'` or `'range'` |
| `locale` | `string` | `'it'` | Locale code; currently `'it'` (Italian) is bundled |
| `altFormat` | `string` | `'d/m/Y'` | Display format shown to the user |
| `dateFormat` | `string` | `'Y-m-d'` | Value format sent to the server (keep ISO) |
| `minDate` | `string` | today − 1 year | Earliest selectable date (e.g. `'2020-01-01'` or `'today'`) |
| `maxDate` | `string` | today + 1 year | Latest selectable date |

`minDate`/`maxDate` default to a one-year window around today (mirroring the NG DateFilter);
pass your own values via `clientOptions` to widen, narrow, or remove the bounds. ISO
(`YYYY-MM-DD`) bounds are accepted even though the display format is `d/m/Y` — the Stimulus
controller converts them to `Date` objects before handing them to Flatpickr.

Any other [Flatpickr option](https://flatpickr.js.org/options/) can be passed via `clientOptions`.

**Examples:**

```php
// Default — range, Italian, d/m/Y
'filter' => ['type' => 'date'],

// Single date
'filter' => [
    'type'          => 'date',
    'clientOptions' => ['mode' => 'single'],
],

// Range with min/max and custom display format
'filter' => [
    'type'          => 'date',
    'clientOptions' => [
        'mode'      => 'range',
        'minDate'   => '2020-01-01',
        'maxDate'   => 'today',
        'altFormat' => 'd MMMM Y',
    ],
],
```

**Repository filter example** — the `date` applier validates ISO bounds, converts them to
`DateTime` and extends the upper bound to end of day (`23:59:59`):

```php
$this->searchForm->applyFilters($qb, $params, [
    'createdAt' => ['date', 'c.createdAt'],
]);

// Pass applier options as an optional third tuple element:
// 'createdAt' => ['date', 'c.createdAt', ['end_of_day' => false]],
```

<details><summary>Under the hood (manual equivalent)</summary>

```php
$fromDate = ($params['createdAt']['from'] ?? '') !== ''
    ? new \DateTime($params['createdAt']['from'])
    : null;
$toDate = ($params['createdAt']['to'] ?? '') !== ''
    ? new \DateTime($params['createdAt']['to'] . ' 23:59:59')
    : null;
$this->searchForm->andFilterWhere($qb, ['gte', 'c.createdAt', $fromDate]);
$this->searchForm->andFilterWhere($qb, ['lte', 'c.createdAt', $toDate]);
```
</details>

> **DateTime serialization:** the bundle serializes entity `DateTime` fields to ISO 8601
> strings (e.g. `2024-01-15T10:30:00+01:00`) using `DateTimeNormalizer`. Twig's `|date()`
> filter accepts this format directly:
> ```php
> 'twigFilter' => "date('d/m/Y')",
> ```

### Applying filters in the repository — `applyFilters()`

`SearchForm::applyFilters()` centralizes the per-type filter logic (operator parsing for
text, boolean cast, date-range validation and end-of-day handling, `IN` for relations)
that would otherwise be re-implemented by hand in every repository `search()` method:

```php
public function search(array $params = [])
{
    $qb = $this->createQueryBuilder('c')
        ->select('c', 'p', 'l')
        ->join('c.profile', 'p')
        ->join('c.locations', 'l');

    $this->searchForm->applyFilters($qb, $params, [
        'code'      => ['text',     'c.code'],
        'email'     => ['text',     'c.email'],
        'active'    => ['boolean',  'c.active'],
        'createdAt' => ['date',     'c.createdAt'],
        'locations' => ['relation', 'l.id'],
    ]);

    // Genuinely custom conditions still use andFilterWhere():
    $this->searchForm->andFilterWhere($qb, 'or',
        ['ilike', 'p.firstname', $params['fullname'] ?? null],
        ['ilike', 'p.lastname',  $params['fullname'] ?? null],
    );

    return $qb;
}
```

**Map format:** `param key => [type, dqlField]` with an optional third element of
applier options (e.g. `['date', 'c.createdAt', ['end_of_day' => false]]`).
Map keys are the **submitted param names**, i.e. the column attribute with dots replaced
by underscores (`t.name` → `t_name`).

**Built-in types:** `text`, `boolean`, `date`, `number`, `choice`, `relation`.

**Semantics:**

- Blank values (`null`, `''`, `[]`, all-empty range arrays) are skipped silently —
  filter-when-set, like `andFilterWhere()`. Note that `'0'` is a *valid* value.
- Every condition is `AND`-combined and uses **bound parameters** with unique names
  (never string-concatenated literals).
- The `text` applier supports the operator-prefix syntax (`= foo`, `>= 10`, `in a,b`,
  `btw 1 AND 9`, ...) and defaults to case-insensitive contains (`ilike`); override with
  the `default_operator` option. It also honors a client-driven, positional `wildcard`
  char (default `%`) and a `trim` toggle (default `true`) — see the [`text` filter
  reference](#text).
- The `number` applier accepts a from/to range and, in either bound, an operator/range
  expression (`>5`, `=10`, `1-5`, …); the range separator is configurable via
  `range_separator` — see the [`number` filter reference](#number).
- An unknown type in the map throws `InvalidArgumentException` (configuration error).

**Custom appliers:** implement `Fedale\GridviewBundle\Contract\FilterApplierInterface`
and register the instance on the `fedale_gridview.filter_applier_registry` service:

```php
$searchForm->getApplierRegistry()->register('money', new MoneyFilterApplier());
```

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

When `useTurbo: false`, the auto-submit is disabled and a **Filter** button (`{filterSubmit}`)
appears in the header so the user can submit the form manually.

---

## Layout System

The grid renders via a **token-based layout**. Each section is a string of `{token}`
placeholders that resolve to a Twig template file.

### Default layout

```
gridview: "{header} {table} {footer}"
header:   "{globalSearch} {filterSubmit}"
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
| `{filter}` | `sections/filter.html.twig` | Column filter inputs row (header) |
| `{filterBar}` | `sections/filterBar.html.twig` | Filters of columns with `filterBar: true`; placeable anywhere, even outside the grid (see [The filterBar](#the-filterbar--placing-filters-anywhere)) |
| `{tbody}` | `sections/tbody.html.twig` | Data rows |
| `{tfoot}` | `sections/tfoot.html.twig` | Table footer row |
| `{globalSearch}` | `sections/globalSearch.html.twig` | Global search input |
| `{filterSubmit}` | `sections/filterSubmit.html.twig` | Filter submit button — visible only when `useTurbo: false` |
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
        header:   "{globalSearch} {filterSubmit}"
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
| `pagination.pageSelect` | `bool` | `true` | Show the jump-to-page `<select>` in the pagination |
| `pagination.pageSelectThreshold` | `int` | `10` | Minimum page count before the `<select>` appears |
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

The bundle ships four Stimulus controllers located in
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

### `gridview-page-jump`

Navigates to the page chosen in the pagination's jump-to-page `<select>`. Each `<option>`
value is the target page URL, so the controller just visits it on `change` — using
`Turbo.visit(url, { action: 'advance' })` when Turbo is active, otherwise `window.location`.

**Connects to:** the `{pagination}` `<select>` wrapper (rendered automatically when
`pagination.pageSelect` is on and the page count reaches the threshold).

**Values:**

| Value | Type | Description |
|-------|------|-------------|
| `turbo` | `Boolean` | Use `Turbo.visit` instead of a full navigation (mirrors the `useTurbo` option) |

**Action available in templates:**

| Action | Description |
|--------|-------------|
| `gridview-page-jump#jump` | Navigate to the URL of the selected `<option>` |

---

## Full Example

A complete controller action combining the most common features:

```php
use Fedale\GridviewBundle\Column\ActionButton;

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
        [
            'type'    => 'action',
            'layout'  => '{view} {edit} {delete}',
            'buttons' => [
                'view' => new ActionButton(
                    fn(array $row) => sprintf('<a href="/customers/%d">View</a>', $row['id'])
                ),
                'edit' => new ActionButton(
                    fn(array $row) => sprintf('<a href="/customers/%d/edit">Edit</a>', $row['id']),
                    roles: ['ROLE_EDITOR', 'ROLE_ADMIN'],
                ),
                'delete' => new ActionButton(
                    fn(array $row) => sprintf('<a href="/customers/%d/delete">Delete</a>', $row['id']),
                    roles: ['ROLE_ADMIN'],
                ),
            ],
        ],
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
