<?php
namespace Fedale\GridviewBundle\Grid;

class GridviewConfigRegistry
{
    private const OPTION_DEFAULTS = [
        'caption'      => null,
        'emptyText'    => 'No records found',
        'showHeader'   => true,
        'showFooter'   => true,
        'useTurbo'     => true,
        'globalSearch' => [],
    ];

    public function __construct(private array $config) {}

    public function resolveOptions(?string $id): array
    {
        $resolved = array_replace(self::OPTION_DEFAULTS, $this->config['defaults']['options'] ?? []);

        if ($id !== null && isset($this->config['gridviews'][$id]['options'])) {
            $resolved = array_replace($resolved, $this->config['gridviews'][$id]['options']);
        }

        return $resolved;
    }

    public function resolveAttributes(?string $id): array
    {
        $resolved = ['row' => [], 'container' => [], 'header' => [], 'filter' => []];

        $resolved = $this->mergeAttributeLayer($resolved, $this->config['defaults']['attributes'] ?? []);

        if ($id !== null && isset($this->config['gridviews'][$id]['attributes'])) {
            $resolved = $this->mergeAttributeLayer($resolved, $this->config['gridviews'][$id]['attributes']);
        }

        return $resolved;
    }

    private function mergeAttributeLayer(array $base, array $layer): array
    {
        if (isset($layer['class']) && $layer['class'] !== null) {
            $base['class'] = $layer['class'];
        }
        foreach (['row', 'container', 'header', 'filter'] as $key) {
            if (!empty($layer[$key])) {
                $base[$key] = array_replace($base[$key] ?? [], $layer[$key]);
            }
        }
        return $base;
    }
}
