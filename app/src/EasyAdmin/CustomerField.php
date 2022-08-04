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
final class CustomerField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_AUTOCOMPLETE = 'autocomplete';
    public const OPTION_CRUD_CONTROLLER = 'crudControllerFqcn';
    public const OPTION_WIDGET = 'widget';
    public const OPTION_QUERY_BUILDER_CALLABLE = 'queryBuilderCallable';
    /** @internal this option is intended for internal use only */
    public const OPTION_RELATED_URL = 'relatedUrl';
    /** @internal this option is intended for internal use only */
    public const OPTION_DOCTRINE_ASSOCIATION_TYPE = 'associationType';

    public const WIDGET_AUTOCOMPLETE = 'autocomplete';
    public const WIDGET_NATIVE = 'native';

    /** @internal this option is intended for internal use only */
    public const PARAM_AUTOCOMPLETE_CONTEXT = 'autocompleteContext';

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/association')
            ->setFormType(EntityType::class)
            ->addCssClass('field-association')
            ->setDefaultColumns('col-md-7 col-xxl-12')
            ->setFormTypeOptions([
                'by_reference' => false,
                'expanded' => true,
                'attr' => ['data-controller' => 'employee'],
                'label_attr' => ['class' => 'checkbox-inline'],
                'block_prefix' => 'user_list',
                'choice_attr' =>  function($choice, $key, $value) {
                    $groups = $choice->getGroups()->toArray();
                    return [
                        // 'data-profile-status' => $choice->getProfile()->getStatus(),
                        // 'data-profile-type' => $choice->getProfile()->getType(),
                        // 'data-profile-gender' => $choice->getProfile()->getGender(),
                        'data-groups' => json_encode(
                            array_map(function($group) { 
                                return $group->getName();
                            }, 
                            $groups
                        ))
                    ];
                }
            ])
            ->addFormTheme('admin/form.html.twig')
            ->addCssFiles('bundles/easyadmin/user_group.css')
            // ->setQueryBuilder(
            //     fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Employee::class)->findWithProfileAndGroups()
            // )
            // ->setCustomOption(self::OPTION_AUTOCOMPLETE, false)
            // ->setCustomOption(self::OPTION_CRUD_CONTROLLER, null)
            // ->setCustomOption(self::OPTION_WIDGET, self::WIDGET_AUTOCOMPLETE)
            // ->setCustomOption(self::OPTION_QUERY_BUILDER_CALLABLE, null)
            // ->setCustomOption(self::OPTION_RELATED_URL, null)
            // ->setCustomOption(self::OPTION_DOCTRINE_ASSOCIATION_TYPE, null)
        ;
    }

    public function autocomplete(): self
    {
        $this->setCustomOption(self::OPTION_AUTOCOMPLETE, true);

        return $this;
    }

    public function renderAsNativeWidget(bool $asNative = true): self
    {
        $this->setCustomOption(self::OPTION_WIDGET, $asNative ? self::WIDGET_NATIVE : self::WIDGET_AUTOCOMPLETE);

        return $this;
    }

    public function setCrudController(string $crudControllerFqcn): self
    {
        $this->setCustomOption(self::OPTION_CRUD_CONTROLLER, $crudControllerFqcn);

        return $this;
    }

    public function setQueryBuilder(\Closure $queryBuilderCallable): self
    {
        $this->setCustomOption(self::OPTION_QUERY_BUILDER_CALLABLE, $queryBuilderCallable);

        return $this;
    }
}
