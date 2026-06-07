<?php

namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Contract\ColumnInterface;
use Fedale\GridviewBundle\Grid\Gridview;

class ColumnFactory
{
    private array $registry = [
        'data'     => DataColumn::class,
        'action'   => ActionColumn::class,
        'checkbox' => CheckboxColumn::class,
        'serial'   => SerialColumn::class,
        'boolean'  => BooleanColumn::class,
    ];

    /** Register a custom column type. Call from a Symfony CompilerPass or bundle boot. */
    public function register(string $type, string $columnClass): void
    {
        if (!is_a($columnClass, ColumnInterface::class, true)) {
            throw new \InvalidArgumentException(
                sprintf('Column class "%s" must implement %s.', $columnClass, ColumnInterface::class)
            );
        }

        $this->registry[$type] = $columnClass;
    }

    public function create(array|string $spec, Gridview $gridview, int|string $key): ColumnInterface
    {
        if (\is_string($spec)) {
            return $this->createFromString($spec, $gridview);
        }

        return $this->createFromArray($spec, $gridview, $key);
    }

    private function createFromString(string $text, Gridview $gridview): ColumnInterface
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $m)) {
            throw new \InvalidArgumentException(
                'Column spec must be "attribute", "attribute:filter" or "attribute:filter:label".'
            );
        }

        return new DataColumn($gridview, $m[1], $m[3] ?? null, $m[5] ?? $m[1]);
    }

    private function createFromArray(array $spec, Gridview $gridview, int|string $key): ColumnInterface
    {
        $type      = $spec['type'] ?? 'data';
        $attribute = $spec['attribute'] ?? 'column_' . $key;
        $value     = $spec['value'] ?? null;

        $class = $this->registry[$type]
            ?? throw new \InvalidArgumentException(sprintf('Unknown column type "%s".', $type));

        $column = match ($type) {
            'data'   => new $class($gridview, $attribute, null, $spec['label'] ?? $attribute, []),
            'action' => new $class($gridview, $attribute, null, $spec['label'] ?? $attribute, []),
            default  => new $class($gridview, null, $spec['label'] ?? $attribute, []),
        };

        if ($type === 'data') {
            $column->value = $value;
        }

        unset($spec['attribute'], $spec['value'], $spec['type']);

        foreach ($spec as $property => $val) {
            $setter = 'set' . ucfirst($property);
            if (!method_exists($column, $setter)) {
                throw new \InvalidArgumentException(
                    sprintf('Column of type "%s" has no setter for property "%s".', $type, $property)
                );
            }
            $column->$setter($val);
        }

        return $column;
    }
}
