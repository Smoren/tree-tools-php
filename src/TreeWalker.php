<?php

declare(strict_types=1);

namespace Smoren\TreeTools;

use ArrayAccess;
use Generator;
use Smoren\TypeTools\MapAccessor;

/**
 * @phpstan-type DictAccess = array<string, mixed>|ArrayAccess<string, mixed>|object
 */
class TreeWalker
{
    /**
     * Iterates a tree like a flat collection using deep traversal.
     *
     * If $childrenContainerKey is not null looks for children items using by this key only.
     *
     * Otherwise, considers any subarray to contain children.
     *
     * @param iterable<DictAccess> $data
     * @param ?string $childrenContainerKey
     *
     * @return Generator
     */
    public static function traverseDepthFirst(iterable $data, ?string $childrenContainerKey = null): Generator
    {
        yield from static::traverseDepthFirstRecursive($data, $childrenContainerKey);
    }

    /**
     * Iterates a tree like a flat collection using wide traversal.
     *
     * If $childrenContainerKey is not null looks for children items using by this key only.
     *
     * Otherwise, considers any subarray to contain children.
     *
     * @param iterable<DictAccess> $data
     * @param ?string $childrenContainerKey
     *
     * @return Generator
     */
    public static function traverseBreadthFirst(iterable $data, ?string $childrenContainerKey = null): Generator
    {
        $level = 0;
        do {
            $subLevelContainer = [];
            foreach($data as $datum) {
                if($childrenContainerKey !== null) {
                    yield $level => $datum;
                    $childrenContainer = MapAccessor::get($datum, $childrenContainerKey);
                } else {
                    if(!is_iterable($datum)) {
                        yield $level => $datum;
                    }
                    $childrenContainer = $datum;
                }
                if(is_iterable($childrenContainer)) {
                    foreach($childrenContainer as $child) {
                        $subLevelContainer[] = $child;
                    }
                }
            }
            $data = $subLevelContainer;
            ++$level;
        } while(count($subLevelContainer));
    }

    /**
     * Recursive helper method for wide traversal.
     *
     * @param iterable<DictAccess> $data
     * @param ?string $childrenContainerKey
     * @param int $initialLevel
     *
     * @return Generator
     */
    protected static function traverseDepthFirstRecursive(
        iterable $data,
        ?string $childrenContainerKey = null,
        int $initialLevel = 0
    ): Generator {
        $level = $initialLevel;
        foreach($data as $datum) {
            if($childrenContainerKey !== null) {
                yield $level => $datum;
                $childrenContainer = MapAccessor::get($datum, $childrenContainerKey);
            } else {
                if(!is_iterable($datum)) {
                    yield $level => $datum;
                }
                $childrenContainer = $datum;
            }
            if(is_iterable($childrenContainer)) {
                yield from static::traverseDepthFirstRecursive($childrenContainer, $childrenContainerKey, $level + 1);
            }
        }
    }
}
