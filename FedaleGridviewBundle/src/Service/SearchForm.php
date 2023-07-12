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
use Symfony\Component\Uid\Uuid;


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
        $name = str_replace('.', '_', $name);
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

    /*
    public function andFilterWhere(QueryBuilder $qb, string $operator, string $attribute, string $param)
    {
        //$qb->expr()->andX($attribute, 'param');
        $qb->andWhere(
            $qb->expr()->like($attribute, ':param')
        );
        $qb->setParameter(':param', '%' . $param . '%');
    } */

    public function andFilterWhere()
    {
        $condition = false;
        $args = func_get_args();
        $qb = $args[0];
        unset($args[0]);
        $baseParam = \uniqid(); //'uuid';//Uuid::v4();

        if ( in_array($args[1], ['or', 'and']) ) {
            $condition = $args[1];
            unset($args[1]);
        }        
        
        $newArgs = [];
        $c = 0;
        foreach ($args as $arg) {
            $param = $baseParam . '_' . $c;
            $operator = $arg[0];
            $attribute = $arg[1];
            $param = trim($arg[2]);
            $newArgs[] = $this->searchWithOperator($qb, $operator, $attribute, $param); //$qb->expr()->like($arg[1], ':' . $param);
            
            $c++;
        }
        
        if ($condition == 'or') {
            $qb->andWhere(
                \call_user_func_array([$qb->expr(), 'orX'], $newArgs)
            );
            
        } else {
            \call_user_func_array([$qb, 'andWhere'], $newArgs);
        }
        $newArgs = [];
    } 

    public function orFilterWhere()
    {
        $condition = false;
        $args = func_get_args();
        $qb = $args[0];
        unset($args[0]);
        $baseParam = \uniqid(); //'uuid';//Uuid::v4();

        if ( in_array($args[1], ['or', 'and']) ) {
            $condition = $args[1];
            unset($args[1]);
        }        
        
        $newArgs = [];
        $c = 0;
        foreach ($args as $arg) {
            $param = $baseParam . '_' . $c;
            $operator = $arg[0];
            $attribute = $arg[1];
            $param = trim($arg[2]);
            $newArgs[] = $this->searchWithOperator($qb, $operator, $attribute, $param); //$qb->expr()->like($arg[1], ':' . $param);
            
            $c++;
        }
        
        if ($condition == 'and') {
            $qb->andWhere(
                \call_user_func_array([$qb->expr(), 'andX'], $newArgs)
            );
            
        } else {
            \call_user_func_array([$qb, 'orWhere'], $newArgs);
        }
        $newArgs = [];
    } 

    public function searchWithOperator(QueryBuilder $qb, string $operator, string $attribute, string $param) {
        $search = match($operator) {
            'eq', '==' => $this->eq($qb, $attribute, $param),
            'ieq', '=' => $this->ieq($qb, $attribute, $param),
            'neq', 'not', '!==', '<>' => $this->neq($qb, $attribute, $param),
            'ineq', '!=' => $this->ineq($qb, $attribute, $param),
            'gt', '>' => $this->gt($qb, $attribute, $param),
            'gte', '>=' => $this->gte($qb, $attribute, $param),
            'lt', '>' => $this->lt($qb, $attribute, $param),
            'lte', '>=' => $this->lte($qb, $attribute, $param),
            'btw', 'between' => $this->between($qb, $attribute, $param),
            'like', '%' => $this->like($qb, $attribute, $param),
            'ilike' => $this->ilike($qb, $attribute, $param),
            'notLike', 'nlike', '!%' => $this->notLike($qb, $attribute, $param),
            'notIlike', 'nilike' => $this->notIlike($qb, $attribute, $param),
            'startwith', '-%' => $this->startWith($qb, $attribute, $param),
            'istartwith', '-%' => $this->iStartWith($qb, $attribute, $param),
            'endWith', '%-' => $this->endWith($qb, $attribute, $param),
            default => $this->default($qb, $attribute, $param),
        };
        return $search;
    }

    public function search(QueryBuilder $qb, string $attribute, string $param)
    {
        $token = strtok(strtolower($param), " ");

        if ( $this->isOperator($token) ) {
            $operator = $token;
            $searchTerm = trim(str_ireplace($token, '', $param));

        } else {
            $operator = 'ilike'; // Default operator
            $searchTerm = $param;
        }

        $search = match($operator) {
            'eq', '==' => $this->eq($qb, $attribute, $searchTerm),
            'ieq', '=' => $this->ieq($qb, $attribute, $searchTerm),
            'neq', 'not', '!==', '<>' => $this->neq($qb, $attribute, $searchTerm),
            'ineq', '!=' => $this->ineq($qb, $attribute, $searchTerm),
            'gt', '>' => $this->gt($qb, $attribute, $searchTerm),
            'gte', '>=' => $this->gte($qb, $attribute, $searchTerm),
            'lt', '>' => $this->lt($qb, $attribute, $searchTerm),
            'lte', '>=' => $this->lte($qb, $attribute, $searchTerm),
            'btw', 'between' => $this->between($qb, $attribute, $searchTerm),
            'like', '%' => $this->like($qb, $attribute, $searchTerm),
            'ilike' => $this->ilike($qb, $attribute, $searchTerm),
            'notLike', 'nlike', '!%' => $this->notLike($qb, $attribute, $searchTerm),
            'notIlike', 'nilike' => $this->notIlike($qb, $attribute, $searchTerm),
            'startwith', '-%' => $this->startWith($qb, $attribute, $searchTerm),
            'istartwith', '-%' => $this->iStartWith($qb, $attribute, $searchTerm),
            'endWith', '%-' => $this->endWith($qb, $attribute, $searchTerm),
            default => $this->default($qb, $attribute, $searchTerm),
        };
    }

    private function getOperators()
    {
        $operators = [
            'eq', '==',
            'ieq', '=',
            'neq', 'not', '!==', '<>',
            'ineq', '!=',
            'gt', '>',
            'gte', '>=',
            'lt', '<',
            'lte', '<=',
            'btw', 'between',
            'btwe',
            'like', '%',
            'notlike', 'nlike', '!%',
            'ilike',
            'notilike', 'nilike', '!ilike',
            'startwith', '-%',
            'notstartwith', '!-%',
            'istartwith',
            'notistartwith',
            'endwith', '%-', 
            'slike', '',
            'nslike', '',
            'rslike', '',
            'lslike', '',
            'isnull',
            'isnotnull',
            'in',
            'notin'
        ];

        return $operators;
    }

    private function isOperator($token) {
        if (in_array(strtolower($token), $this->getOperators())) {
            return true;
        }
        
        return false;
    }


    private function eq(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->eq($attribute, ':param'));
        $qb->setParameter(':param', $searchTerm);
    }

    private function ieq(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->eq(
            $qb->expr()->lower($attribute), ':param')
        );
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function neq(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->neq($attribute, ':param'));
        $qb->setParameter(':param', $searchTerm);
    }

    private function ineq(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->neq(
            $qb->expr()->lower($attribute), ':param')
        );
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function gt(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->gt($attribute, ':param'));
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function gte(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->gte($attribute, ':param'));
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function lt(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->lt($attribute, ':param'));
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function lte(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->lte($attribute, ':param'));
        $qb->setParameter(':param', strtolower($searchTerm));
    }

    private function between(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $terms = \explode(' AND ', $searchTerm);
        $qb->andWhere($qb->expr()->between($attribute, '\'' . $terms[0] . '\'', '\'' . $terms[1] . '\''));
    }

    private function like(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        return $qb->expr()->like($attribute, $qb->expr()->literal('%' . $searchTerm . '%'));
    }
    
    private function ilike(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        return $qb->expr()->like(
            $qb->expr()->lower($attribute), 
            $qb->expr()->literal('%' . strtolower($searchTerm) . '%')
        );      
    }

    private function notLike(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        return $qb->andWhere($qb->expr()->notLike(
            $attribute, 
            $qb->expr()->literal('%' . $searchTerm . '%')
        ));
        //$qb->setParameter(':param', '%' . $searchTerm . '%');
    }
    
    private function notIlike(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere(
            $qb->expr()->notLike(
                $qb->expr()->lower($attribute), 
                ':param'
            )
            );
        $qb->setParameter(':param', '%' . strtolower($searchTerm) . '%');
    }

    private function startWith(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->like($attribute, ':param'));
        $qb->setParameter(':param', $searchTerm . '%');
    }

    private function iStartWith(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->like(
                $qb->expr()->lower($attribute), 
                ':param'
            )
        );
        $qb->setParameter(':param', strtolower($searchTerm) . '%');
    }

    private function endWith(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $qb->andWhere($qb->expr()->notLike($attribute, ':param'));
        $qb->setParameter(':param', '%' . $searchTerm);
    }


    private function default(QueryBuilder $qb, string $attribute, string $searchTerm)
    {
        $this->ilike($qb, $attribute, $searchTerm);
    }
    

} 
/**
 *  const OPERATOR_EQ = 'eq'; OK
 *  const OPERATOR_NEQ = 'neq'; OK
 *  const OPERATOR_LT = 'lt'; OK
 *  const OPERATOR_LTE = 'lte';OK
 *  const OPERATOR_GT = 'gt';OK
 *  const OPERATOR_GTE = 'gte';OK
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