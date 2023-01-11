<?php

declare(strict_types=1);

namespace Smoren\TreeTools;

use Smoren\TypeTools\MapAccess;
use ArrayAccess;
use stdClass;

class TreeMaker
{
    /**
     * @param iterable<mixed> $list
     * @param string $idField
     * @param string $parentIdField
     * @param string $childrenContainerField
     * @param string $itemContainerField
     *
     * @return array<mixed>
     */
    public static function fromList(
        iterable $list,
        string $idField = 'id',
        string $parentIdField = 'parent_id',
        string $childrenContainerField = 'children',
        string $itemContainerField = 'item'
    ): array {
        $result = [];
        $map = [];

        foreach($list as $item) {
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
