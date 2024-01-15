# repara
The goal of this project is to create a Gridview component for Symfony framework.
Main inspiration of this project is Yii 2 Gridview.

First of all, this gridview is not automagic: if you are searching something magical like EasyAdmin gridview this project is not for you.

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