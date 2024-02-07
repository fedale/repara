# repara
The goal of this project is to create a Gridview component for Symfony framework.
Main inspiration of this project is Yii 2 Gridview.


First of all, this gridview is not automagic: if you are searching something magical like EasyAdmin gridview this project is not for you. You have, at least, configure a Fedale\GridviewBundle\DataProviderInterface and an array of columns to display.

With an Entity having these properties:
- id
- code
- username 
you can dsplay a grid having these columns configuring this array:

$columns = [
    'id',
    'code',
    'username'
];

$dataProvider = [
    // 'queryBuilder' => $queryBuilder,
    'models' => \App\Entity\Customer\Customer::class,
];

$gridview = $this->createGridviewBuilder()
->setDataProvider($dataProvider)
->setColumns($columns)
->renderGridview();

return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);

For each you can set further configurations, passing each of them as array. In that case you can configure 'attribute', 'filter' (i.e. a query filter, that it needs a searchModel first), 'value' an anonymous function to return specific value, 'twigFilter' that will be applied to value of cell, 'visibile' 'boolean', 'label' (header of the column).

Try to change array $columns in this way:
$columns = [
    'id',
    [
        'attribute' => 'code',
        'value' => function (array $data, string $key, ColumnInterface $column) {
            return '<strong>' . $data['code'] . '</strong>';
        },
        'twigFilter' => 'raw'
    ],
    [
        'attribute' =>'username',
        'twigFilter' => 'reverse'
    ]    
];

In $dataProvider you can also set 'pagination' and 'sort' parameters:

// be careful that IDs must have same name as columns
$sortAttributes = [
    'id' => [
        'asc' => ['c.id' => Sort::ASC],
        'desc' => ['c.id' => Sort::DESC],
        'default' => Sort::DESC,
    ],
    'code' => [
        'asc' => ['c.code' => Sort::ASC],
        'desc' => ['c.code' => Sort::DESC],
        'default' => Sort::DESC,
    ],
];

and Gridview become sortable by 'id' and 'code' columns!
With 'pagination' like this: you can set default page size
$paginationAttributes = [
    'defaultPageSize' => 10
];





But the only thing you have to do is to set a config arrays. 
// Order matters! Try to switch setColumns() / setFilterModel()
        $gridview = $this->createGridviewBuilder()
            ->setSearchModel($this->customerSearchModel)
            ->setDataProvider($dataProvider)
            ->setColumns($columns)
            ->setAttributes([
                'class' => 'table table-dark',
                'row' => [
                    'class' => 'row-class'
                ],
                'header' => [
                    'class' => 'row-header'
                ],
                'container' => [
                    'class' => 'row-container',
                    'data-type' => 'my-custom-type'
                ]
            ])
            ->renderGridview();
        ;

where $this->customerSearchModel is a child of Fedale\GridviewBundle\Service\SearchModel
$dataProvider represents a way and how to get data from a source like a database
$dataProvider = [
            // 'queryBuilder' => $queryBuilder,
            'models' => \App\Entity\Customer\Customer::class,
            'pagination' => $paginationAttributes,
            'sort' => $sortAttributes
        ];

Let's try with one entity.


How to define relations between entitites?

->setColumns($columns)  is the place where you set columns from different entities. $columns is an array where each item has these keys: 
attribute: the name of columnn
value: is the value to display, you can use a closure 
filter: filter to use, like 'text' or 'select'
twigFilter: one of twig filter 
visible: boolean
label: 