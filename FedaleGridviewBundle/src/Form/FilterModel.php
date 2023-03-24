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
    private Request $request;

    private ArrayCollection $filters;
    
    public function __construct(private FormFactoryInterface $formFactory) {
        $this->filters = new ArrayCollection();
    }

    /*
    public function __construct()
    {
        $this->filters = new ArrayCollection();
    }*/

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter($filter)
    {
        $this->modelType->add($filter);
        //$this->filters->add($filter);
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

    public function setModelType($type, $data, $options)
    {
        $formBuilder = $this->formFactory->createNamedBuilder('myform', FormType::class, null, ['method' => 'get', 'action' => '', 'required' => false]);
        $this->modelType = $formBuilder->getForm();
        $this->modelType->add('save', SubmitType::class, ['attr' => ['class' => 'save']]);
        if ($this->modelType->isSubmitted() && $this->modelType->isValid()) {
            $this->modelType->handleRequest($this->request);
        }
        // $this->modelType = $this->formFactory->create($type, $data, $options);
    }

    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }
} 