<?php 

namespace Fedale\GridviewBundle\Form;

use Fedale\GridviewBundle\Grid\Gridview;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Fedale\GridviewBundle\Form\FilterModel;
use Fedale\GridviewBundle\Form\FilterModelInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterModelType extends AbstractType
{
    //private FilterModel $filterModel;
    // private Gridview $gridview;
    
    
    public function __construct(
        private FilterModel $filterModel
     ) {}
    

    public function setFilterModel(FilterModel $filterModel)
    {        
        $this->filterModel = $filterModel;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        dump($this->filterModel);
        /*
        foreach ($this->gridview->getFilterModel()->getFilters() as $filter) {
            dump($filter);
            $builder->add($filter, TextType::class, ['required' => false]);
        }*/
        
        $builder->add('id', TextType::class, ['required' => false]);
        $builder->add('code', TextType::class, ['required' => false]);
        $builder->add('email', TextType::class, ['required' => false]);
        $builder->add('profile_fullname', TextType::class, ['required' => false]);
        $builder->add('locations', TextType::class, ['required' => false]);
       
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
            $this->gridview->getFilterModel()->setCriteria($criteria);
                
        });
        
    }    

    /**
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
       // dd($resolver);
    }

    public function setModel()
    {
        dd('setmodel)');
    }

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