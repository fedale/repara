<?php

namespace App\Form\Setting;

use Fedale\SettingBundle\Bridge\Doctrine\Entity\Setting;
use Fedale\SettingBundle\Setting\ValueCaster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tenantId')
            ->add('name')
            ->add('value')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'String' => ValueCaster::TYPE_STRING,
                    'Integer' => ValueCaster::TYPE_INT,
                    'Float' => ValueCaster::TYPE_FLOAT,
                    'Boolean' => ValueCaster::TYPE_BOOL,
                    'JSON' => ValueCaster::TYPE_JSON,
                ],
            ])
            ->add('active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Setting::class,
        ]);
    }
}
