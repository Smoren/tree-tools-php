<?php

namespace Smoren\TreeTools\Tests\Unit\TreeBuilder;

use Smoren\TreeTools\TreeBuilder;

class ArrayTest extends \Codeception\Test\Unit
{
    /**
     * @dataProvider dataProviderForWithoutParentIds
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testWithoutParentIds(array $input, array $expected): void
    {
        // When
        $result = TreeBuilder::build($input);

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForWithoutParentIds(): array
    {
        return [
            [
                [],
                [],
            ],
            [
                [
                    ['id' => 1, 'name' => 'Item 1'],
                    ['id' => 2, 'name' => 'Item 1.1', 'parent_id' => 1],
                    ['id' => 3, 'name' => 'Item 1.2', 'parent_id' => 1],
                    ['id' => 4, 'name' => 'Item 1.1.1', 'parent_id' => 2],
                    ['id' => 5, 'name' => 'Item 2'],
                    ['id' => 6, 'name' => 'Item 3'],
                    ['id' => 7, 'name' => 'Item 3.1', 'parent_id' => 6],
                    ['id' => 8, 'name' => 'Item 3.2', 'parent_id' => 6],
                ],
                [
                    [
                        'id' => 1,
                        'name' => 'Item 1',
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
                        ]
                    ],
                    [
                        'id' => 5,
                        'name' => 'Item 2',
                        'children' => [],
                    ],
                    [
                        'id' => 6,
                        'name' => 'Item 3',
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
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForWithNullableParentIds
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testWithNullableParentIds(array $input, array $expected): void
    {
        // When
        $result = TreeBuilder::build($input);

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForWithNullableParentIds(): array
    {
        return [
            [
                [],
                [],
            ],
            [
                [
                    ['id' => 1, 'name' => 'Item 1', 'parent_id' => null],
                    ['id' => 2, 'name' => 'Item 1.1', 'parent_id' => 1],
                    ['id' => 3, 'name' => 'Item 1.2', 'parent_id' => 1],
                    ['id' => 4, 'name' => 'Item 1.1.1', 'parent_id' => 2],
                    ['id' => 5, 'name' => 'Item 2', 'parent_id' => null],
                    ['id' => 6, 'name' => 'Item 3', 'parent_id' => null],
                    ['id' => 7, 'name' => 'Item 3.1', 'parent_id' => 6],
                    ['id' => 8, 'name' => 'Item 3.2', 'parent_id' => 6],
                ],
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
                ],
            ],
        ];
    }
}
