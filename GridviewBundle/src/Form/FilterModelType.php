<?php 

namespace Fedale\GridviewBundle\Form;

use Fedale\GridviewBundle\Gridview;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr;
use Fedale\GridviewBundle\Service\FilterModel;


class FilterModelType extends AbstractType
{
    /*
    public function __construct(private FilterModel $filterModel, private Gridview $gridview) {
    }*/

    /*
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($this->filterModel->getFilters() as $filter) {
            dump($filter);
        }
        
        $builder->add('id', TextType::class, ['required' => false]);
        $builder->add('code', TextType::class, ['required' => false]);
        $builder->add('email', TextType::class, ['required' => false]);
        $builder->add('profile_fullname', TextType::class, ['required' => false]);
        $builder->add('locations', TextType::class, ['required' => false]);
        $builder->add('column_2', TextType::class, ['required' => false]);
        $builder->add('column_3', TextType::class, ['required' => false]);
        $builder->add('column_4', TextType::class, ['required' => false]);
        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'save'],
        ]);

        
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $criteria = Criteria::create();
            $expr = Criteria::expr();
            
            foreach ($data as $key => $item) {
                if (null !== $item) {
                    
                    if ($key === 'fullname') {
                        $criteria->andWhere(
                            // $expr->andX(
                                $expr->orX(
                                    $expr->contains('p.firstname', $item),
                                    $expr->contains('p.lastname', $item),
                                    //$expr->contains('CONCAT("p.firstname", " ", "p.lastname")', $item)
                                    // Example - $qb->expr()->concat('u.firstname', $qb->expr()->concat($qb->expr()->literal(' '), 'u.lastname'))
                                )
                            // )
                        );
                    } else if ($key === 'locations') {
                        $criteria->andWhere(
                            $expr->contains('l.zipcode', $item)
                        );
                    } else {
                        $criteria->andWhere($expr->contains($key, $item));
                    }
                }
            }
            $this->filterModel->setCriteria($criteria);
                
        });
        
    }
    */

}

            /*  In Yii 2
            $query->andFilterWhere(['OR',
                ['like', 'customer_location.name', $this->locations],
                ['like', 'customer_location.address', $this->locations],
                ['like', 'customer_location.zipcode', $this->locations],
                ['like', 'customer_location.city', $this->locations],
                ['like', 'customer_location_place.name', $this->locations],
            ]);
            **/
