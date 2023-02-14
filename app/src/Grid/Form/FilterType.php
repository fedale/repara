<?php 

namespace App\Grid\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\Common\Collections\Criteria;
use App\Grid\Service\GridFilter;

class FilterType extends AbstractType
{
    public function __construct(private GridFilter $gridFilter)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('id', TextType::class, ['required' => false]);
        $builder->add('codice', TextType::class, ['required' => false]);
        $builder->add('E-Mail', TextType::class, ['required' => false]);
        $builder->add('Fullname', TextType::class, ['required' => false]);
        $builder->add('location', TextType::class, ['required' => false]);
        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'save'],
        ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $criteria = Criteria::create();

            foreach ($data as $item) {
                if (null !== $item) {
                    dump($item);
                    $criteria->where(Criteria::expr()->eq("email", $item));
                    $this->gridFilter->setCriteria($criteria);
                }
            }
                
        });

    }

   
}