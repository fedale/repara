<?php
namespace Fedale\GridviewBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Fedale\GridviewBundle\DataProvider\EntityDataProvider;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SearchForm implements SearchFormInterface
{
    
    private Form $modelType;

    private Criteria $criteria;

    private ArrayCollection $filters;

    private Request $request;

    public function __construct(
        private FormFactoryInterface $formFactory,
        private RequestStack $requestStack, 
        private EntityDataProvider $entityDataProvider
    ) {
        $this->filters = new ArrayCollection();

        // name, method, action and so on must be passed as argument!
        $formBuilder = $this->formFactory->createNamedBuilder(
            'myform', 
            FormType::class, 
            null, 
            [
                'method' => 'get', 
                'action' => '', 
                'required' => false
            ]
        );
        $this->modelType = $formBuilder->getForm();
        $this->modelType->add('save', SubmitType::class, ['attr' => ['class' => 'save']]);
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter($name, $type, $options)
    {
        $class = "Fedale\\GridviewBundle\\FilterType\\Filter" . ucfirst($type) . 'Type';
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

    public function andFilterWhere(QueryBuilder $qb, string $attribute, string $param)
    {
        $operator = strtolower(strtok($param, ' '));
        dump($attribute, $operator);
        if ($operator) {
            $param = trim(str_ireplace($operator, '', $param));
        }
        
        dump($operator, $param);

        $match = match($operator) {
            'eq', '=' => [
                $qb->andWhere($qb->expr()->eq($attribute, ':param')),
                $qb->setParameter(':param', $param)
            ],
            'ieq' => [
                $qb->andWhere($qb->expr()->eq(
                    $qb->expr()->lower($attribute), ':param')),
                $qb->setParameter(':param', strtolower($param))
            ],
            'neq', '!=', '<>' => [
                $qb->andWhere($qb->expr()->neq($attribute, ':param')),
                $qb->setParameter(':param', $param)
            ],
            'ineq' => [
                $qb->andWhere($qb->expr()->neq(
                    $qb->expr()->lower($attribute), ':param')),
                $qb->setParameter(':param', strtolower($param))
            ],
            default => [
                $qb->andWhere(
                    $qb->expr()->like($qb->expr()->lower($attribute), ':param')
                ),
                $qb->setParameter(':param', '%' . strtolower($param) . '%')
            ]
        };
        
        
    }

} 
/**
 *  const OPERATOR_EQ = 'eq'; OK
 *  const OPERATOR_NEQ = 'neq'; OK
 *  const OPERATOR_LT = 'lt';
 *  const OPERATOR_LTE = 'lte';
 *  const OPERATOR_GT = 'gt';
 *  const OPERATOR_GTE = 'gte';
 *  const OPERATOR_BTW = 'btw';
 *  const OPERATOR_BTWE = 'btwe';
 *  const OPERATOR_LIKE = 'like';
 *  const OPERATOR_NLIKE = 'nlike';
 *  const OPERATOR_RLIKE = 'rlike';
 *  const OPERATOR_LLIKE = 'llike';
 *  const OPERATOR_SLIKE = 'slike'; //simple/strict LIKE
 *  const OPERATOR_NSLIKE = 'nslike';
 *  const OPERATOR_RSLIKE = 'rslike';
 *  const OPERATOR_LSLIKE = 'lslike';
 * 
 * ISNULL
 * ISNOTNULL
 * IN
 * NOTIN
 */