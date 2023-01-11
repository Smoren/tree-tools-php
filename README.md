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

## Usage

### Tree Walker

#### Traverse-Depth-First

Iterates a tree like a flat collection using depth-first traversal.

If `$childrenContainerKey` is not null looks for children items using by this key only.

Otherwise, considers any subarray to contain children.

```TreeWalker::traverseDepthFirst(iterable $data, ?string $childrenContainerKey = null): Generator```

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

#### Traverse-Breadth-First

Iterates a tree like a flat collection using depth-breadth traversal.

If `$childrenContainerKey` is not null looks for children items using by this key only.

Otherwise, considers any subarray to contain children.

```TreeWalker::traverseBreadthFirst(iterable $data, ?string $childrenContainerKey = null): Generator```

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

## Unit testing
```
composer install
composer test-init
composer test
```

## License

PHP Tree Tools is licensed under the MIT License.
