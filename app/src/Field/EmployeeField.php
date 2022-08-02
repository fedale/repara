<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmployeeField implements FieldInterface
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

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
        ->setProperty($propertyName)
        ->setLabel($label)
        ->setTemplateName('crud/field/association')
        ->setFormType(EntityType::class)
        ->setFormTypeOption()
        ->addCssClass('field-association')
        ->setDefaultColumns('col-md-7 col-xxl-6')
        ->setCustomOption(self::OPTION_AUTOCOMPLETE, false)
        ->setCustomOption(self::OPTION_CRUD_CONTROLLER, null)
        ->setCustomOption(self::OPTION_WIDGET, self::WIDGET_AUTOCOMPLETE)
        ->setCustomOption(self::OPTION_QUERY_BUILDER_CALLABLE, null)
        ->setCustomOption(self::OPTION_RELATED_URL, null)
        ->setCustomOption(self::OPTION_DOCTRINE_ASSOCIATION_TYPE, null)
        ;
    }
}
