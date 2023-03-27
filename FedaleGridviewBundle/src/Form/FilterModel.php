<?php
namespace Fedale\GridviewBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterModel implements FilterModelInterface
{
    
    private Form $modelType;
    private Criteria $criteria;

    private ArrayCollection $filters;
    
    public function __construct(private FormFactoryInterface $formFactory) {
        $this->filters = new ArrayCollection();

        $this->setModelType();

        $formBuilder = $this->formFactory->createNamedBuilder('myform', FormType::class, null, ['method' => 'get', 'action' => '', 'required' => false]);
        $this->modelType = $formBuilder->getForm();
        $this->modelType->add('save', SubmitType::class, ['attr' => ['class' => 'save']]);
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter($name, $type, $options)
    {
        $class = "Fedale\\GridviewBundle\\FilterType\\Gridview" . ucfirst($type) . 'Type';
        $this->modelType->add($name, $class, $options);
        //$this->filters->add($filter => );
    }

    public function getCriteria(): Criteria|null
    {
        return $this->criteria ?? null;
    }

    public function setCriteria(Criteria $criteria) 
    {
        $this->criteria = $criteria;
    }

    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getModelType()
    {
        return $this->modelType;
    }

    public function prepareFilters()
    {
        foreach ($this->filters as $filter) {
            $this->modelType->add($filter);
        }
    }

    private function setModelType()
    {
        /*
        $formBuilder = $this->formFactory->createNamedBuilder('myform', FormType::class, null, ['method' => 'get', 'action' => '', 'required' => false]);
        $this->modelType = $formBuilder->getForm();
        $this->modelType->add('save', SubmitType::class, ['attr' => ['class' => 'save']]);
        */
        // if ($this->modelType->isSubmitted() && $this->modelType->isValid()) {
           // $this->modelType->handleRequest($this->request);
        // }
        // $this->modelType = $this->formFactory->create($type, $data, $options);
    }

    public function createfilterFromString($text) 
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new \Exception('The filter must be specified in the format of "attirbute", "attribute:filter" or "attribute:filter:label"');
        }
        
        $column =  new \Fedale\GridviewBundle\Column\DataColumn(
            $this, 
            $matches[1],
            isset($matches[3]) ? $matches[3] : null, 
            isset($matches[5]) ? $matches[5] : $matches[1]
        );
        return $column;
    }


} 