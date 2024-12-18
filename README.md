# PHP Tree Tools

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/smoren/tree-tools)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Smoren/tree-tools-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Smoren/tree-tools-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/Smoren/tree-tools-php/badge.svg?branch=master)](https://coveralls.io/github/Smoren/tree-tools-php?branch=master)
![Build and test](https://github.com/Smoren/tree-tools-php/actions/workflows/test_master.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Library for working with trees.

## How to install to your project
```
composer require smoren/tree-tools
```

## Quick reference

#### Tree Walker
| Reducer                                           | Description                                | Code Snippet                                                     |
|---------------------------------------------------|--------------------------------------------|------------------------------------------------------------------|
| [`traverseDepthFirst`](#Traverse-Depth-First)     | Iterates a tree using depth-first search   | `TreeWalker::traverseDepthFirst($data, $childrenContainerKey)`   |
| [`traverseBreadthFirst`](#Traverse-Breadth-First) | Iterates a tree using breadth-first search | `TreeWalker::traverseBreadthFirst($data, $childrenContainerKey)` |

#### Tree Builder
| Reducer           | Description                              | Code Snippet                                                                                              |
|-------------------|------------------------------------------|-----------------------------------------------------------------------------------------------------------|
| [`build`](#Build) | Builds a tree from given flat collection | `TreeBuilder::build($collection, $idField, $parentIdField, $childrenContainerField, $itemContainerField)` |

## Usage

### Tree Walker

#### Traverse Depth First

Iterates a tree like a flat collection using depth-first traversal.

```TreeWalker::traverseDepthFirst(iterable $data, ?string $childrenContainerKey = null): Generator```

If `$childrenContainerKey` is not null looks for children items using by this key only.

Otherwise, considers any subarray to contain children.

```php
use Smoren\TreeTools\TreeWalker;

$tree = [
    [
        'id' => 1,
        'children' => [
            ['id' => 11],
            [
                'id' => 12,
                'children' => [
                    ['id' => 121],
                    ['id' => 122],
                ],
            ],
        ],
    ],
    [
        'id' => 2,
        'children' => [
            ['id' => 21],
        ],
    ],
    ['id' => 3],
];

$result = [];

foreach(TreeWalker::traverseDepthFirst($tree) as $item) {
    $result[] = $item['id'];
}
var_dump($result);
// [1, 11, 12, 121, 122, 2, 21, 3]
```

#### Traverse Breadth First

Iterates a tree like a flat collection using depth-breadth traversal.

```TreeWalker::traverseBreadthFirst(iterable $data, ?string $childrenContainerKey = null): Generator```

If `$childrenContainerKey` is not null looks for children items using by this key only.

Otherwise, considers any subarray to contain children.

```php
use Smoren\TreeTools\TreeWalker;

$tree = [
    [
        'id' => 1,
        'children' => [
            ['id' => 11],
            [
                'id' => 12,
                'children' => [
                    ['id' => 121],
                    ['id' => 122],
                ],
            ],
        ],
    ],
    [
        'id' => 2,
        'children' => [
            ['id' => 21],
        ],
    ],
    ['id' => 3],
];

$result = [];

foreach(TreeWalker::traverseBreadthFirst($tree) as $item) {
    $result[] = $item['id'];
}
var_dump($result);
// [1, 2, 3, 11, 12, 21, 121, 122]
```

### Tree Builder

#### Build

Builds a tree from given flat collection of items with relations.

```
TreeBuilder::build(
    iterable $collection,
    string $idField = 'id',
    string $parentIdField = 'parent_id',
    string $childrenContainerField = 'children',
    string $itemContainerField = 'item'
): array
```

```php
use Smoren\TreeTools\TreeBuilder;

$input = [
    ['id' => 1, 'name' => 'Item 1', 'parent_id' => null],
    ['id' => 2, 'name' => 'Item 1.1', 'parent_id' => 1],
    ['id' => 3, 'name' => 'Item 1.2', 'parent_id' => 1],
    ['id' => 4, 'name' => 'Item 1.1.1', 'parent_id' => 2],
    ['id' => 5, 'name' => 'Item 2', 'parent_id' => null],
    ['id' => 6, 'name' => 'Item 3', 'parent_id' => null],
    ['id' => 7, 'name' => 'Item 3.1', 'parent_id' => 6],
    ['id' => 8, 'name' => 'Item 3.2', 'parent_id' => 6],
];

$tree = TreeBuilder::build($input);
print_r($tree);
/*
[
    [
        'id' => 1,
        'name' => 'Item 1',
        'parent_id' => null,
        'children' => [
            [
                'id' => 2,
                'name' => 'Item 1.1',
                'parent_id' => 1,
                'children' => [
                    [
                        'id' => 4,
                        'name' => 'Item 1.1.1',
                        'parent_id' => 2,
                        'children' => [],
                    ]
                ],
            ],
            [
                'id' => 3,
                'name' => 'Item 1.2',
                'parent_id' => 1,
                'children' => [],
            ],
        ],
    ],
    [
        'id' => 5,
        'name' => 'Item 2',
        'parent_id' => null,
        'children' => [],
    ],
    [
        'id' => 6,
        'name' => 'Item 3',
        'parent_id' => null,
        'children' => [
            [
                'id' => 7,
                'name' => 'Item 3.1',
                'parent_id' => 6,
                'children' => [],
            ],
            [
                'id' => 8,
                'name' => 'Item 3.2',
                'parent_id' => 6,
                'children' => [],
            ],
        ]
    ],
]
*/

```

## Unit testing
```
composer install
composer test-init
composer test
```

## License

Tree Tools PHP is licensed under the MIT License.
