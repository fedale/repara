<?php

namespace App\EasyAdmin;

use App\Entity\Employee\Employee;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Contracts\Translation\TranslatableInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

/**
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
final class AssociationCheckboxField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_WIDGET = 'widget';
    public const OPTION_QUERY_BUILDER_CALLABLE = 'queryBuilderCallable';

    public const WIDGET_NATIVE = 'native';

   

   

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/association')
            ->setTemplatePath('admin/field/association.html.twig')
            ->setFormType(EntityType::class)
            ->addCssClass('field-association')
            ->setDefaultColumns('col-md-7 col-xxl-12')
            // ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-collection.js')->onlyOnForms())
            ->setFormTypeOptions([
                'by_reference' => false,
                'expanded' => true,
                'row_attr' => [
                    'data-controller' => $propertyName, 
                ],
                'label_attr' => ['class' => 'checkbox-inline'],
                'block_prefix' => $propertyName . '_association',
                'choice_attr' =>  function($choice, $key, $value) {
                    $groups = $choice->getGroups()->toArray();
                    
                    
                    return [
                        'data-users-target' => 'input',
                        // 'data-action' => 'users#change',
                        'data-groups' => json_encode(
                            array_map(function($group) { 
                                return $group->getSlug();
                            }, 
                            $groups
                        ))
                    ];
                },
            ])
            ->addFormTheme('admin/form/form.html.twig')
            ->addCssFiles('admin/css/' . $propertyName . '.css')->onlyOnForms()
            // ->setQueryBuilder(
            //     fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Employee::class)->findWithProfileAndGroups()
            // )
        ;
    }

    public function setQueryBuilder(\Closure $queryBuilderCallable): self
    {

        $this->setCustomOption(self::OPTION_QUERY_BUILDER_CALLABLE, $queryBuilderCallable);

        return $this;
    }
}
