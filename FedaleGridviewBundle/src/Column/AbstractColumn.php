<?php

namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Contract\ColumnInterface;
use Fedale\GridviewBundle\Grid\Gridview;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Twig\Environment;

abstract class AbstractColumn implements ColumnInterface
{
    /** @var callable|null */
    public $content;

    protected bool $visible    = true;
    protected bool $sortable   = true;
    protected bool $filterable = true;
    protected bool $hidden     = false;
    protected bool $exportable = false;

    protected $value;

    protected Environment $twig;

    public function __construct(
        private Gridview $gridview,
        protected ?string $twigFilter = null,
        protected ?string $label = null,
        protected ?array $options = []
    ) {
        $this->initColumn();
    }

    protected function initColumn(): void {}

    public function renderFilter(FormBuilder $form): void
    {
        $form->add('name', TextType::class);
    }

    public function getAttribute(): ?string
    {
        return null;
    }

    public function render(mixed $data, int $_index): mixed
    {
        return $data[$this->content] ?? null;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel($label): void
    {
        $this->label = $label;
    }

    public function getTwigFilter(): ?string
    {
        return $this->twigFilter;
    }

    public function setTwigFilter(string $twigFilter): void
    {
        $this->twigFilter = $twigFilter;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool|\Closure $visible
     */
    public function setVisible($visible): static
    {
        $this->visible = $visible instanceof \Closure ? (bool) $visible() : (bool) $visible;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param bool|\Closure $sortable
     */
    public function setSortable($sortable): static
    {
        $this->sortable = $sortable instanceof \Closure ? (bool) $sortable() : (bool) $sortable;

        return $this;
    }

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * @param bool|\Closure $filterable
     */
    public function setFilterable($filterable): static
    {
        $this->filterable = $filterable instanceof \Closure ? (bool) $filterable() : (bool) $filterable;

        return $this;
    }

    public function setGridview(Gridview $gridview): void  // satisfies ColumnInterface
    {
        $this->gridview = $gridview;
    }

    public function renderHeader($label): string
    {
        return $label;
    }

    public function getOptions(): array
    {
        return $this->options ?? [];
    }

    public function isToggleable(): bool
    {
        return true;
    }

    public function getFilter(): mixed
    {
        return null;
    }
}
