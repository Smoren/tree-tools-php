<?php

declare(strict_types=1);

namespace Smoren\TreeTools;

use Smoren\TypeTools\MapAccess;
use ArrayAccess;

/**
 * @phpstan-type DictAccess = array<string, mixed>|ArrayAccess<string, mixed>|object
 */
class TreeMaker
{
    /**
     * @param iterable<array<string, mixed>> $list
     * @param string $idField
     * @param string $parentIdField
     * @param string $childrenContainerField
     *
     * @return array<array<string, mixed>>
     */
    public static function fromList(
        iterable $list,
        string $idField = 'id',
        string $parentIdField = 'parent_id',
        string $childrenContainerField = 'children'
    ): array {
        $result = [];

        $map = [];

        foreach($list as $item) {
            $item[$childrenContainerField] = [];
            $map[MapAccess::get($item, $idField)] = $item;
        }

        foreach($map as &$item) {
            if(isset($item[$parentIdField])) {
                $parentId = MapAccess::get($item, $parentIdField);

                /** @var array<mixed> $childrenContainer */
                $childrenContainer = &$map[$parentId][$childrenContainerField];
                $childrenContainer[] = &$item;
            } else {
                $result[] = &$item;
            }
        }

        return $result;
    }
}
