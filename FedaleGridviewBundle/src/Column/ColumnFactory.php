<?php

namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Contract\ColumnInterface;
use Fedale\GridviewBundle\Form\Control\ControlResolver;
use Fedale\GridviewBundle\Grid\Gridview;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ColumnFactory
{
    private ControlResolver $controlResolver;

    public function __construct(
        private ?AuthorizationCheckerInterface $authChecker = null,
        ?ControlResolver $controlResolver = null,
    ) {
        $this->controlResolver = $controlResolver ?? new ControlResolver();
    }

    /**
     * Structural columns: selected by the root `type` and backed by a dedicated
     * column class. Custom types may be added through register().
     */
    private array $registry = [
        'action'   => ActionColumn::class,
        'checkbox' => CheckboxColumn::class,
        'serial'   => SerialColumn::class,
    ];

    /**
     * Semantic data types handled by DataColumn. The root `type` defines the
     * column's data type (driving rendering and the default filter type) and
     * defaults to "text" when omitted; the subset that also names a filter is
     * listed in FILTER_TYPES. "data" is kept as a raw-rendering alias of "text".
     */
    private const DATA_TYPES   = ['data', 'text', 'boolean', 'date', 'number', 'relation', 'choice'];
    private const FILTER_TYPES = ['text', 'boolean', 'date', 'number', 'relation', 'choice'];

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
        $type      = $spec['type'] ?? 'text';
        $attribute = $spec['attribute'] ?? 'column_' . $key;
        $value     = $spec['value'] ?? null;

        unset($spec['attribute'], $spec['value'], $spec['type']);

        // Structural / custom columns keep their dedicated class.
        if (isset($this->registry[$type])) {
            $class  = $this->registry[$type];
            $column = $type === 'action'
                ? new $class($gridview, $attribute, null, $spec['label'] ?? null, [], $this->authChecker)
                : new $class($gridview, null, $spec['label'] ?? $attribute, []);
        } elseif (\in_array($type, self::DATA_TYPES, true)) {
            // Data column carrying a semantic data type.
            $column = new DataColumn($gridview, $attribute, null, $spec['label'] ?? $attribute, []);
            $column->value = $value;
            $column->setDataType($type);

            // The per-column filter inherits the root data type unless it names
            // its own type, which always wins.
            if (\array_key_exists('filter', $spec)) {
                $spec['filter'] = $this->normalizeFilter($spec['filter'], $type);
            }

            // The per-column control (write-side field) inherits the root data
            // type unless it names its own type, mirroring the filter logic.
            if (\array_key_exists('control', $spec)) {
                $spec['control'] = $this->controlResolver->resolve($spec['control'], $type);
            }
        } else {
            throw new \InvalidArgumentException(sprintf('Unknown column type "%s".', $type));
        }

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

    /**
     * Normalizes a column's `filter` spec into an array with a resolved `type`.
     * A `filter.type` set explicitly always wins; otherwise the root data type
     * is inherited (falling back to "text" for non-filterable data types).
     */
    private function normalizeFilter(mixed $filter, string $dataType): array
    {
        $inherited = \in_array($dataType, self::FILTER_TYPES, true) ? $dataType : 'text';

        if (\is_array($filter)) {
            $filter['type'] ??= $inherited;

            return $filter;
        }

        if (\is_string($filter)) {
            return ['type' => $filter];
        }

        // `filter => true` (or any other truthy scalar) inherits the root type.
        return ['type' => $inherited];
    }
}
