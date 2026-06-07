<?php

namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Grid\Gridview;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActionColumn extends AbstractColumn
{
    public array $buttons = [];

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        private Gridview $gridview,
        private string $attribute,
        protected ?string $twigFilter = null,
        protected ?string $label = null,
        protected ?array $options = [],
    ) {
        if (null === $this->label) {
            $this->setLabel($attribute);
        }
        $this->setTwigFilter('raw');
        $this->initDefaultButtons();
    }

    public function initColumn(): void
    {
        $this->label = 'Action';
    }

    public function setRouter(UrlGeneratorInterface $urlGenerator): void
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function isToggleable(): bool
    {
        return false;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    private function initDefaultButtons(): void
    {
        $this->initDefaultButton('view');
        $this->initDefaultButton('update');
        $this->initDefaultButton('delete');
    }

    private function initDefaultButton(string $name, ?array $_options = null): void
    {
        $this->buttons[$name] = '<a href="' . $name . '">' . $name . '</a>';
    }

    public function render(mixed $_model, int $_index): mixed
    {
        return implode('', $this->buttons);
    }

    public function renderHeader(mixed $_label): string
    {
        return $this->label ?? '';
    }
}
