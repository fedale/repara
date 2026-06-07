<?php

namespace Fedale\GridviewBundle\Contract;

use Fedale\GridviewBundle\Grid\Gridview;

interface ColumnInterface
{
    public function isVisible(): bool;

    public function isFilterable(): bool;

    public function isSortable(): bool;

    public function isToggleable(): bool;

    public function setGridview(Gridview $gridview): void;

    public function getAttribute(): ?string;

    public function getLabel(): ?string;

    public function getTwigFilter(): ?string;

    /** Render a data cell for the given row model. */
    public function render(mixed $model, int $index): mixed;

    /** Render the column header cell (may include sort link). */
    public function renderHeader(mixed $label): string;
}
