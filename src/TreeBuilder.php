<?php

declare(strict_types=1);

namespace Smoren\TreeTools;

use Smoren\TypeTools\MapAccess;
use stdClass;

class TreeBuilder
{
    /**
     * Builds a tree from given flat collection of items with relations.
     *
     * @param iterable<mixed> $collection
     * @param string $idField
     * @param string $parentIdField
     * @param string $childrenContainerField
     * @param string $itemContainerField
     *
     * @return array<mixed>
     */
    public static function build(
        iterable $collection,
        string $idField = 'id',
        string $parentIdField = 'parent_id',
        string $childrenContainerField = 'children',
        string $itemContainerField = 'item'
    ): array {
        $result = [];
        $map = [];

        foreach($collection as $item) {
            $map[MapAccess::get($item, $idField)] = static::wrapItem(
                $item,
                $childrenContainerField,
                $itemContainerField
            );
        }

        foreach($map as &$item) {
            if(($parentId = static::getParentId($item, $parentIdField, $itemContainerField)) !== null) {
                $childrenContainer = &static::getChildrenContainer($map[$parentId], $childrenContainerField);
                $childrenContainer[] = &$item;
            } else {
                $result[] = &$item;
            }
        }

        return $result;
    }

    /**
     * Returns value of parent relation.
     *
     * @param mixed $item
     * @param string $parentIdField
     * @param string $itemContainerField
     *
     * @return scalar|null
     */
    protected static function getParentId($item, string $parentIdField, string $itemContainerField)
    {
        /** @var scalar|null $parentId */
        $parentId = MapAccess::get($item, $parentIdField);

        if($parentId !== null) {
            return $parentId;
        }

        return MapAccess::get(MapAccess::get($item, $itemContainerField), $parentIdField);
    }

    /**
     * Returns children container of given item.
     *
     * @param mixed $item
     * @param string $childrenContainerField
     *
     * @return array<mixed>
     */
    protected static function &getChildrenContainer(&$item, string $childrenContainerField): array
    {
        if(is_array($item)) {
            return $item[$childrenContainerField];
        }

        return $item->{$childrenContainerField};
    }

    /**
     * Wraps collection item for tree representation.
     *
     * @param mixed $item
     * @param string $childrenContainerField
     * @param string $itemContainerField
     *
     * @return array<mixed>|stdClass
     */
    protected static function wrapItem($item, string $childrenContainerField, string $itemContainerField)
    {
        if(is_array($item)) {
            $item[$childrenContainerField] = [];
            return $item;
        }

        if($item instanceof stdClass) {
            $item->{$childrenContainerField} = [];
            return $item;
        }

        return [$itemContainerField => &$item, $childrenContainerField => []];
    }
}
