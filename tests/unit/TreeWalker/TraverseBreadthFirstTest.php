<?php

declare(strict_types=1);

namespace Smoren\TreeTools\Tests\Unit\TreeWalker;

use Codeception\Test\Unit;
use Smoren\TreeTools\Tests\Unit\Fixture\ArrayIteratorFixture;
use Smoren\TreeTools\Tests\Unit\Fixture\GeneratorFixture;
use Smoren\TreeTools\Tests\Unit\Fixture\IteratorAggregateFixture;
use Smoren\TreeTools\TreeWalker;

class TraverseBreadthFirstTest extends Unit
{
    /**
     * @test         traverseWide array
     * @dataProvider dataProviderForArrayWithChildrenContainerKey
     * @param array<mixed> $data
     * @param string $childrenContainerKey
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testArrayWithChildrenContainerKey(
        array  $data,
        string $childrenContainerKey,
        array  $expectedLevels,
        array  $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data, $childrenContainerKey) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForArrayWithChildrenContainerKey(): array
    {
        return [
            [
                [],
                'children',
                [],
                [],
            ],
            [
                [1, 2, 3],
                'children',
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                [
                    ['id' => 1, 'children' => [11, 12, 13]],
                    ['id' => 2, 'children' => [21, 22, 23]],
                    ['id' => 3, 'children' => [31, 32, 33]],
                ],
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                [
                    new \ArrayObject(['id' => 1, 'children' => [11, 12, 13]]),
                    new \ArrayObject(['id' => 2, 'children' => [21, 22, 23]]),
                    new \ArrayObject(['id' => 3, 'children' => [31, 32, 33]]),
                    new \ArrayObject(['id' => 4]),
                ],
                'children',
                [0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 4, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                [
                    [
                        'id' => 1,
                        'children' => [
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]
                    ],
                    2,
                    (object)[
                        'id' => 3,
                        'children' => [
                            [
                                'id' => 31,
                                'children' => [
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ],
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;
                                public array $children;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                    $this->children = [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ],
                    ],
                ],
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
            [
                [
                    [
                        'id' => 1,
                        'items' => [
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]
                    ],
                    2,
                    [
                        'id' => 3,
                        'items' => [
                            [
                                'id' => 31,
                                'items' => [
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ],
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                public function getItems(): array
                                {
                                    return [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ],
                    ],
                ],
                'items',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
        ];
    }

    /**
     * @test         traverseWide array
     * @dataProvider dataProviderForArrayWithoutChildrenContainerKey
     * @param array<mixed> $data
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testArrayWithoutChildrenContainerKey(
        array $data,
        array $expectedLevels,
        array $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForArrayWithoutChildrenContainerKey(): array
    {
        return [
            [
                [],
                [],
                [],
            ],
            [
                [1, 2, 3],
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                [
                    ['id' => 1, [11, 12, 13]],
                    ['id' => 2, [21, 22, 23]],
                    ['id' => 3, [31, 32, 33]],
                ],
                [1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                [
                    1,
                    2,
                    [
                        31,
                        32,
                        [331, 332],
                        [341, 342],
                    ],
                    [41, 42],
                ],
                [0, 0, 1, 1, 1, 1, 2, 2, 2, 2],
                [1, 2, 31, 32, 41, 42, 331, 332, 341, 342],
            ],
        ];
    }

    /**
     * @test         traverseWide generator
     * @dataProvider dataProviderForGeneratorWithChildrenContainerKey
     * @param \Generator<mixed> $data
     * @param string $childrenContainerKey
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testGeneratorWithChildrenContainerKey(
        \Generator $data,
        string     $childrenContainerKey,
        array      $expectedLevels,
        array      $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data, $childrenContainerKey) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForGeneratorWithChildrenContainerKey(): array
    {
        $gen = static function(array $data) {
            return GeneratorFixture::getGenerator($data);
        };

        return [
            [
                $gen([]),
                'children',
                [],
                [],
            ],
            [
                $gen([1, 2, 3]),
                'children',
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $gen([
                    ['id' => 1, 'children' => $gen([11, 12, 13])],
                    ['id' => 2, 'children' => $gen([21, 22, 23])],
                    ['id' => 3, 'children' => $gen([31, 32, 33])],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $gen([
                    new \ArrayObject(['id' => 1, 'children' => $gen([11, 12, 13])]),
                    new \ArrayObject(['id' => 2, 'children' => $gen([21, 22, 23])]),
                    new \ArrayObject(['id' => 3, 'children' => $gen([31, 32, 33])]),
                    new \ArrayObject(['id' => 4]),
                ]),
                'children',
                [0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 4, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $gen([
                    [
                        'id' => 1,
                        'children' => $gen([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    [
                        'id' => 3,
                        'children' => $gen([
                            [
                                'id' => 31,
                                'children' => [
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ],
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;
                                public array $children;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                    $this->children = [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
            [
                $gen([
                    [
                        'id' => 1,
                        'items' => $gen([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    (object)[
                        'id' => 3,
                        'items' => $gen([
                            [
                                'id' => 31,
                                'items' => $gen([
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ]),
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                public function getItems(): array
                                {
                                    return [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'items',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
        ];
    }

    /**
     * @test         traverseWide generator
     * @dataProvider dataProviderForGeneratorWithoutChildrenContainerKey
     * @param \Generator<mixed> $data
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testGeneratorWithoutChildrenContainerKey(
        \Generator $data,
        array      $expectedLevels,
        array      $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForGeneratorWithoutChildrenContainerKey(): array
    {
        $gen = static function(array $data) {
            return GeneratorFixture::getGenerator($data);
        };

        return [
            [
                $gen([]),
                [],
                [],
            ],
            [
                $gen([1, 2, 3]),
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $gen([
                    ['id' => 1, $gen([11, 12, 13])],
                    ['id' => 2, $gen([21, 22, 23])],
                    ['id' => 3, $gen([31, 32, 33])],
                ]),
                [1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $gen([
                    1,
                    2,
                    $gen([
                        31,
                        32,
                        $gen([331, 332]),
                        $gen([341, 342]),
                    ]),
                    [41, 42],
                ]),
                [0, 0, 1, 1, 1, 1, 2, 2, 2, 2],
                [1, 2, 31, 32, 41, 42, 331, 332, 341, 342],
            ],
        ];
    }

    /**
     * @test         traverseWide iterator
     * @dataProvider dataProviderForIteratorWithChildrenContainerKey
     * @param \Iterator<mixed> $data
     * @param string $childrenContainerKey
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testIteratorWithChildrenContainerKey(
        \Iterator $data,
        string    $childrenContainerKey,
        array     $expectedLevels,
        array     $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data, $childrenContainerKey) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForIteratorWithChildrenContainerKey(): array
    {
        $iter = static function(array $data) {
            return new ArrayIteratorFixture($data);
        };

        return [
            [
                $iter([]),
                'children',
                [],
                [],
            ],
            [
                $iter([1, 2, 3]),
                'children',
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $iter([
                    ['id' => 1, 'children' => $iter([11, 12, 13])],
                    ['id' => 2, 'children' => $iter([21, 22, 23])],
                    ['id' => 3, 'children' => $iter([31, 32, 33])],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $iter([
                    new \ArrayObject(['id' => 1, 'children' => $iter([11, 12, 13])]),
                    new \ArrayObject(['id' => 2, 'children' => $iter([21, 22, 23])]),
                    new \ArrayObject(['id' => 3, 'children' => $iter([31, 32, 33])]),
                    new \ArrayObject(['id' => 4]),
                ]),
                'children',
                [0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 4, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $iter([
                    [
                        'id' => 1,
                        'children' => $iter([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    (object)[
                        'id' => 3,
                        'children' => $iter([
                            [
                                'id' => 31,
                                'children' => [
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ],
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;
                                public array $children;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                    $this->children = [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
            [
                $iter([
                    [
                        'id' => 1,
                        'items' => $iter([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    [
                        'id' => 3,
                        'items' => $iter([
                            [
                                'id' => 31,
                                'items' => $iter([
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ]),
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                public function getItems(): array
                                {
                                    return [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'items',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
        ];
    }

    /**
     * @test         traverseWide iterator
     * @dataProvider dataProviderForIteratorWithoutChildrenContainerKey
     * @param \Iterator<mixed> $data
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testIteratorWithoutChildrenContainerKey(
        \Iterator $data,
        array     $expectedLevels,
        array     $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForIteratorWithoutChildrenContainerKey(): array
    {
        $iter = static function(array $data) {
            return new ArrayIteratorFixture($data);
        };

        return [
            [
                $iter([]),
                [],
                [],
            ],
            [
                $iter([1, 2, 3]),
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $iter([
                    ['id' => 1, $iter([11, 12, 13])],
                    ['id' => 2, $iter([21, 22, 23])],
                    ['id' => 3, $iter([31, 32, 33])],
                ]),
                [1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $iter([
                    1,
                    2,
                    $iter([
                        31,
                        32,
                        $iter([331, 332]),
                        $iter([341, 342]),
                    ]),
                    [41, 42],
                ]),
                [0, 0, 1, 1, 1, 1, 2, 2, 2, 2],
                [1, 2, 31, 32, 41, 42, 331, 332, 341, 342],
            ],
        ];
    }

    /**
     * @test         traverseWide traversable
     * @dataProvider dataProviderForTraversableWithChildrenContainerKey
     * @param \Traversable<mixed> $data
     * @param string $childrenContainerKey
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testTraversableWithChildrenContainerKey(
        \Traversable $data,
        string       $childrenContainerKey,
        array        $expectedLevels,
        array        $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data, $childrenContainerKey) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForTraversableWithChildrenContainerKey(): array
    {
        $trav = static function(array $data) {
            return new IteratorAggregateFixture($data);
        };

        return [
            [
                $trav([]),
                'children',
                [],
                [],
            ],
            [
                $trav([1, 2, 3]),
                'children',
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $trav([
                    ['id' => 1, 'children' => $trav([11, 12, 13])],
                    ['id' => 2, 'children' => $trav([21, 22, 23])],
                    ['id' => 3, 'children' => $trav([31, 32, 33])],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $trav([
                    new \ArrayObject(['id' => 1, 'children' => $trav([11, 12, 13])]),
                    new \ArrayObject(['id' => 2, 'children' => $trav([21, 22, 23])]),
                    new \ArrayObject(['id' => 3, 'children' => $trav([31, 32, 33])]),
                    new \ArrayObject(['id' => 4]),
                ]),
                'children',
                [0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                [1, 2, 3, 4, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $trav([
                    [
                        'id' => 1,
                        'children' => $trav([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    (object)[
                        'id' => 3,
                        'children' => $trav([
                            [
                                'id' => 31,
                                'children' => [
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ],
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;
                                public array $children;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                    $this->children = [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'children',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
            [
                $trav([
                    [
                        'id' => 1,
                        'items' => $trav([
                            11,
                            ['id' => 12],
                            (object)['id' => 13],
                        ]),
                    ],
                    2,
                    [
                        'id' => 3,
                        'items' => $trav([
                            [
                                'id' => 31,
                                'items' => $trav([
                                    311,
                                    ['id' => 312],
                                    new class (313) {
                                        public int $id;

                                        public function __construct(int $id)
                                        {
                                            $this->id = $id;
                                        }
                                    }
                                ]),
                            ],
                            (object)['id' => 32],
                            new class (33) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                public function getItems(): array
                                {
                                    return [
                                        ['id' => 331],
                                        332,
                                        (object)['id' => 333]
                                    ];
                                }
                            },
                            new class (34) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                protected function getChildren(): array
                                {
                                    return [
                                        ['id' => 341],
                                        342,
                                        (object)['id' => 343]
                                    ];
                                }
                            },
                            new class (35) {
                                public int $id;

                                public function __construct(int $id)
                                {
                                    $this->id = $id;
                                }

                                private function getChildren(): array
                                {
                                    return [
                                        ['id' => 351],
                                        352,
                                        (object)['id' => 353]
                                    ];
                                }
                            }
                        ]),
                    ],
                ]),
                'items',
                [0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 31, 32, 33, 34, 35, 311, 312, 313, 331, 332, 333],
            ],
        ];
    }

    /**
     * @test         traverseWide traversable
     * @dataProvider dataProviderForTraversableWithoutChildrenContainerKey
     * @param \Traversable<mixed> $data
     * @param array<int> $expectedLevels
     * @param array<int> $expectedIds
     */
    public function testTraversableWithoutChildrenContainerKey(
        \Traversable $data,
        array        $expectedLevels,
        array        $expectedIds
    ): void
    {
        // Given
        $actualLevels = [];
        $actualIds = [];

        // When
        foreach(TreeWalker::traverseBreadthFirst($data) as $level => $item) {
            $actualLevels[] = $level;
            $actualIds[] = $this->getId($item);
        }

        // Then
        $this->assertSame($expectedLevels, $actualLevels);
        $this->assertSame($expectedIds, $actualIds);
    }

    public function dataProviderForTraversableWithoutChildrenContainerKey(): array
    {
        $trav = static function(array $data) {
            return new IteratorAggregateFixture($data);
        };

        return [
            [
                $trav([]),
                [],
                [],
            ],
            [
                $trav([1, 2, 3]),
                [0, 0, 0],
                [1, 2, 3],
            ],
            [
                $trav([
                    ['id' => 1, $trav([11, 12, 13])],
                    ['id' => 2, $trav([21, 22, 23])],
                    ['id' => 3, $trav([31, 32, 33])],
                ]),
                [1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2],
                [1, 2, 3, 11, 12, 13, 21, 22, 23, 31, 32, 33],
            ],
            [
                $trav([
                    1,
                    2,
                    $trav([
                        31,
                        32,
                        $trav([331, 332]),
                        $trav([341, 342]),
                    ]),
                    [41, 42],
                ]),
                [0, 0, 1, 1, 1, 1, 2, 2, 2, 2],
                [1, 2, 31, 32, 41, 42, 331, 332, 341, 342],
            ],
        ];
    }

    /**
     * @param array<string, mixed>|object|scalar $container
     * @return mixed|null
     */
    protected function getId($container)
    {
        $key = 'id';
        switch(true) {
            case is_scalar($container):
                return $container;
            case $container instanceof \ArrayAccess:
                if($container->offsetExists($key)) {
                    return $container[$key];
                }
                break;
            case is_array($container):
                if(array_key_exists($key, $container)) {
                    return $container[$key];
                }
                break;
            case is_object($container):
                if(property_exists($container, $key)) {
                    return $container->{$key};
                }
                break;
        }

        return null;
    }
}
