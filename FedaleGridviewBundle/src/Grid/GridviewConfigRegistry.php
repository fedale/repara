<?php
namespace Fedale\GridviewBundle\Grid;

class GridviewConfigRegistry
{
    private const OPTION_DEFAULTS = [
        'caption'      => null,
        'emptyText'    => 'No records found',
        'showThead'    => true,
        'showTfoot'    => true,
        'useTurbo'     => true,
        'globalSearch' => [],
        'addRoute'     => null,
        'addLabel'     => 'Add',
        'formName'     => 'myform',
        'layout'       => [
            'gridview'  => '{header} {table} {footer}',
            'header'    => '{globalSearch}',
            'toolbar'   => '',
            'table'     => null,
            'footer'    => '{pagination}',
            'tfoot'     => '',
            'templates' => [],
            'slots'     => [],
        ],
    ];

    public function __construct(private array $config) {}

    public function resolveOptions(?string $id): array
    {
        $yamlDefaults = $this->config['defaults']['options'] ?? [];

        $resolved = array_replace(self::OPTION_DEFAULTS, $yamlDefaults);
        $resolved['layout'] = $this->mergeLayout($yamlDefaults['layout'] ?? []);

        if ($id !== null && isset($this->config['gridviews'][$id]['options'])) {
            $gridviewOptions = $this->config['gridviews'][$id]['options'];
            $resolved = array_replace($resolved, $gridviewOptions);
            $resolved['layout'] = $this->mergeLayout(
                $yamlDefaults['layout'] ?? [],
                $gridviewOptions['layout'] ?? []
            );
        }

        return $resolved;
    }

    private function mergeLayout(array ...$layers): array
    {
        $result = self::OPTION_DEFAULTS['layout'];
        foreach ($layers as $layer) {
            foreach ($layer as $key => $value) {
                if ($key === 'templates' || $key === 'slots') {
                    if (!empty($value)) {
                        $result[$key] = array_replace($result[$key], $value);
                    }
                } elseif ($value !== null) {
                    $result[$key] = $value;
                }
            }
        }
        return $result;
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
