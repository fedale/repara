<?php 
namespace App\Grid;

use App\Grid\Column\ColumnInterface;
use App\Grid\Source\SourceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Gridview {

    private $twig;
    private $entities = [];

    private $columns;
    private $source;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $ormMetadata;

    private EntityManagerInterface $entityManager;

    private $response;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
//         $this->columns = $columns;
        $this->entityManager = $entityManager;
    }

    /*public function init($entityClass, $columns)
    {
        $this->ormMetadata = $this->entityManager->getClassMetadata($entityClass);
        $this->setColumns($columns);
        $this->setEntities($entityClass);
    }*/

    public function setColumns($columns) 
    {    
        $this->columns = $columns;
    }

    public function setSource($source) 
    {    
        $this->source = $this->entityManager
        ->getRepository(Customer::class)
        ->findAll();
        
        return $this;
    }

    public function createColumn(string $column) 
    {
        return match (strtolower($column)) {
            'action' => '', //this->createColumnBuilder()
            'boolean' => '',
            'checkbox' => '',
            'data' => '',
            'radio' => '',
            'serial' => ''
            // 'editable', 'enum', 'expand', 'formula', 
        };
    }

    public function setEntities($entityClass) {
        dd($entityClass);
        $this->entities = $this->entityManager
            ->getRepository($entityClass)
            ->findAll();
            dd($this->entities);
        return $this;
    }
        
    public function renderGrid(string $view, array $parameters = []): Response
    {
        $parameters['columns'] = $this->columns;
        $parameters['entities'] = $this->entities;
        $content = $this->twig->render($view, $parameters);

        $response = new Response();
        $response->setContent($content);

        return $response;
    }

    public function getFieldsMetadata($class, $group = 'default')
    {
        $result = [];
        foreach ($this->ormMetadata->getFieldNames() as $name) {
            $mapping = $this->ormMetadata->getFieldMapping($name);
            $values = ['title' => $name, 'source' => true];

            if (isset($mapping['fieldName'])) {
                $values['field'] = $mapping['fieldName'];
                $values['id'] = $mapping['fieldName'];
            }

            if (isset($mapping['id']) && $mapping['id'] == 'id') {
                $values['primary'] = true;
            }

            switch ($mapping['type']) {
                case 'string':
                case 'text':
                    $values['type'] = 'text';
                    break;
                case 'integer':
                case 'smallint':
                case 'bigint':
                case 'float':
                case 'decimal':
                    $values['type'] = 'number';
                    break;
                case 'boolean':
                    $values['type'] = 'boolean';
                    break;
                case 'date':
                    $values['type'] = 'date';
                    break;
                case 'datetime':
                    $values['type'] = 'datetime';
                    break;
                case 'time':
                    $values['type'] = 'time';
                    break;
                case 'array':
                case 'object':
                    $values['type'] = 'array';
                    break;
            }

            $result[$name] = $values;
        }

        return $result;
    }


    // https://github.com/tinustester/symfony-gridview-bundle/blob/e2cf9eec053ff21cd3d457b43babcd81d287fa39/src/Gridview.php
     /**
     * Renders full grid content.
     *
     * @return string
     */
    public function renderGrid2(): string
    {
        $this->containerOptions['id'] = $this->containerOptions['id'] ?? $this->getId();
        $gridContainerOptions = $this->html->prepareTagAttributes($this->containerOptions);

        return '<div ' . $gridContainerOptions . '>' . $this->renderTable() . '</div>';
    }

}