<?php

namespace Fedale\GridviewBundle\Grid;

use Doctrine\Common\Collections\ArrayCollection;
use Fedale\GridviewBundle\Column\ColumnInterface;
use Fedale\GridviewBundle\Component\GridviewUrlState;
use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Symfony\Component\HttpFoundation\Response;

interface GridviewInterface
{
    public function getKey(): string;

    public function getId(): ?string;

    public function setId(string $id): void;

    public function getColumns(): ArrayCollection;

    public function addColumn(ColumnInterface $column): void;

    public function getDataProvider(): DataProviderInterface;

    public function getOptions(): array;

    public function setOptions(array $options): void;

    public function getUrlState(): GridviewUrlState;

    public function parseLayout(string $section): array;

    public function layoutTemplate(string $token): string;

    public function isSlot(string $token): bool;

    public function slotContent(string $token): string;

    public function hasCheckboxColumn(): bool;

    public function hasHiddenColumns(): bool;

    public function renderGrid(string $view, array $parameters = []): Response;
}
