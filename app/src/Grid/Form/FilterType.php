<?php 

namespace App\Grid\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class FilterType extends AbstractType
{
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // ... adding the name field if needed
            dump('Event_PRE_DATA');
        });
    }

   
}