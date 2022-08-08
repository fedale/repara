<?php

namespace App\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Contracts\Translation\TranslatableInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;   

/**
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
final class MyCollectionField implements FieldInterface
{
    use FieldTrait;

    public const OPTION_ALLOW_ADD = 'allowAdd';
    public const OPTION_ALLOW_DELETE = 'allowDelete';
    public const OPTION_ENTRY_IS_COMPLEX = 'entryIsComplex';
    public const OPTION_ENTRY_TYPE = 'entryType';
    public const OPTION_SHOW_ENTRY_LABEL = 'showEntryLabel';
    public const OPTION_RENDER_EXPANDED = 'renderExpanded';
    public const OPTION_ENTRY_USES_CRUD_FORM = 'entryUsesCrudController';
    public const OPTION_ENTRY_CRUD_CONTROLLER_FQCN = 'entryCrudControllerFqcn';
    public const OPTION_ENTRY_CRUD_NEW_PAGE_NAME = 'entryCrudNewPageName';
    public const OPTION_ENTRY_CRUD_EDIT_PAGE_NAME = 'entryCrudEditPageName';

    /**
     * @param TranslatableInterface|string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        dump($propertyName, $label);
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/collection')
            ->setFormType(CollectionType::class)
            ->addCssClass('field-collection')
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-collection.js')->onlyOnForms())
            ->setDefaultColumns('col-md-8 col-xxl-7')
            ->setFormTypeOptions([
                'block_prefix' => 'collection_' . $propertyName,
                'by_reference' => false,
            ])
            ->addFormTheme('admin/form/form.html.twig')
            ->setCustomOption(self::OPTION_ALLOW_ADD, true)
            ->setCustomOption(self::OPTION_ALLOW_DELETE, true)
            ->setCustomOption(self::OPTION_ENTRY_TYPE, null)
            ->setCustomOption(self::OPTION_SHOW_ENTRY_LABEL, true)
            ->setCustomOption(self::OPTION_ENTRY_USES_CRUD_FORM, false)
            ->setCustomOption(self::OPTION_ENTRY_CRUD_CONTROLLER_FQCN, null)
            ->setCustomOption(self::OPTION_ENTRY_CRUD_NEW_PAGE_NAME, null)
            ->setCustomOption(self::OPTION_ENTRY_CRUD_EDIT_PAGE_NAME, null);
    }

    public function allowAdd(bool $allow = true): self
    {
        $this->setCustomOption(self::OPTION_ALLOW_ADD, $allow);

        return $this;
    }

    public function allowDelete(bool $allow = true): self
    {
        $this->setCustomOption(self::OPTION_ALLOW_DELETE, $allow);

        return $this;
    }

    
    public function setEntryType(string $formTypeFqcn): self
    {
        $this->setCustomOption(self::OPTION_ENTRY_TYPE, $formTypeFqcn);

        return $this;
    }

    public function showEntryLabel(bool $showLabel = true): self
    {
        $this->setCustomOption(self::OPTION_SHOW_ENTRY_LABEL, $showLabel);

        return $this;
    }

    public function useEntryCrudForm(?string $crudControllerFqcn = null, ?string $crudNewPageName = null, ?string $crudEditPageName = null): self
    {
        $this->setCustomOption(self::OPTION_ENTRY_USES_CRUD_FORM, true);
        $this->setCustomOption(self::OPTION_ENTRY_CRUD_CONTROLLER_FQCN, $crudControllerFqcn);
        $this->setCustomOption(self::OPTION_ENTRY_CRUD_NEW_PAGE_NAME, $crudNewPageName);
        $this->setCustomOption(self::OPTION_ENTRY_CRUD_EDIT_PAGE_NAME, $crudEditPageName);

        return $this;
    }
}
