<?php

namespace Fedale\GridviewBundle\Component;

interface PaginationInterface
{
    public function setAttributes(array $attributes): static;

    public function setTotalCount(int|float $totalCount): static;

    public function getPageSize(): ?int;

    public function getOffset(): int;

    public function getPageCount(): int;

    public function getCurrentPage(): int;

    public function getPageParamName(): string;
}
