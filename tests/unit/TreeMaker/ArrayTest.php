<?php

namespace Smoren\TreeTools\Tests\Unit\TreeMaker;

use Smoren\TreeTools\TreeMaker;

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
        $result = TreeMaker::fromList($input);

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
                    ['id' => 1, 'name' => 'Элемент 1'],
                    ['id' => 2, 'name' => 'Элемент 1.1', 'parent_id' => 1],
                    ['id' => 3, 'name' => 'Элемент 1.2', 'parent_id' => 1],
                    ['id' => 4, 'name' => 'Элемент 1.1.1', 'parent_id' => 2],
                    ['id' => 5, 'name' => 'Элемент 2'],
                    ['id' => 6, 'name' => 'Элемент 3'],
                    ['id' => 7, 'name' => 'Элемент 3.1', 'parent_id' => 6],
                    ['id' => 8, 'name' => 'Элемент 3.2', 'parent_id' => 6],
                ],
                [
                    [
                        'id' => 1,
                        'name' => 'Элемент 1',
                        'children' => [
                            [
                                'id' => 2,
                                'name' => 'Элемент 1.1',
                                'parent_id' => 1,
                                'children' => [
                                    [
                                        'id' => 4,
                                        'name' => 'Элемент 1.1.1',
                                        'parent_id' => 2,
                                        'children' => [],
                                    ]
                                ],
                            ],
                            [
                                'id' => 3,
                                'name' => 'Элемент 1.2',
                                'parent_id' => 1,
                                'children' => [],
                            ],
                        ]
                    ],
                    [
                        'id' => 5,
                        'name' => 'Элемент 2',
                        'children' => [],
                    ],
                    [
                        'id' => 6,
                        'name' => 'Элемент 3',
                        'children' => [
                            [
                                'id' => 7,
                                'name' => 'Элемент 3.1',
                                'parent_id' => 6,
                                'children' => [],
                            ],
                            [
                                'id' => 8,
                                'name' => 'Элемент 3.2',
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
        $result = TreeMaker::fromList($input);

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
                    ['id' => 1, 'name' => 'Элемент 1', 'parent_id' => null],
                    ['id' => 2, 'name' => 'Элемент 1.1', 'parent_id' => 1],
                    ['id' => 3, 'name' => 'Элемент 1.2', 'parent_id' => 1],
                    ['id' => 4, 'name' => 'Элемент 1.1.1', 'parent_id' => 2],
                    ['id' => 5, 'name' => 'Элемент 2', 'parent_id' => null],
                    ['id' => 6, 'name' => 'Элемент 3', 'parent_id' => null],
                    ['id' => 7, 'name' => 'Элемент 3.1', 'parent_id' => 6],
                    ['id' => 8, 'name' => 'Элемент 3.2', 'parent_id' => 6],
                ],
                [
                    [
                        'id' => 1,
                        'name' => 'Элемент 1',
                        'parent_id' => null,
                        'children' => [
                            [
                                'id' => 2,
                                'name' => 'Элемент 1.1',
                                'parent_id' => 1,
                                'children' => [
                                    [
                                        'id' => 4,
                                        'name' => 'Элемент 1.1.1',
                                        'parent_id' => 2,
                                        'children' => [],
                                    ]
                                ],
                            ],
                            [
                                'id' => 3,
                                'name' => 'Элемент 1.2',
                                'parent_id' => 1,
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'id' => 5,
                        'name' => 'Элемент 2',
                        'parent_id' => null,
                        'children' => [],
                    ],
                    [
                        'id' => 6,
                        'name' => 'Элемент 3',
                        'parent_id' => null,
                        'children' => [
                            [
                                'id' => 7,
                                'name' => 'Элемент 3.1',
                                'parent_id' => 6,
                                'children' => [],
                            ],
                            [
                                'id' => 8,
                                'name' => 'Элемент 3.2',
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
