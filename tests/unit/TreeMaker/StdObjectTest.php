<?php

namespace Smoren\TreeTools\Tests\Unit\TreeMaker;

use Smoren\TreeTools\TreeMaker;

class StdObjectTest extends \Codeception\Test\Unit
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
                    (object)['id' => 1, 'name' => 'Элемент 1'],
                    (object)['id' => 2, 'name' => 'Элемент 1.1', 'parent_id' => 1],
                    (object)['id' => 3, 'name' => 'Элемент 1.2', 'parent_id' => 1],
                    (object)['id' => 4, 'name' => 'Элемент 1.1.1', 'parent_id' => 2],
                    (object)['id' => 5, 'name' => 'Элемент 2'],
                    (object)['id' => 6, 'name' => 'Элемент 3'],
                    (object)['id' => 7, 'name' => 'Элемент 3.1', 'parent_id' => 6],
                    (object)['id' => 8, 'name' => 'Элемент 3.2', 'parent_id' => 6],
                ],
                [
                    (object)[
                        'id' => 1,
                        'name' => 'Элемент 1',
                        'children' => [
                            (object)[
                                'id' => 2,
                                'name' => 'Элемент 1.1',
                                'parent_id' => 1,
                                'children' => [
                                    (object)[
                                        'id' => 4,
                                        'name' => 'Элемент 1.1.1',
                                        'parent_id' => 2,
                                        'children' => [],
                                    ]
                                ],
                            ],
                            (object)[
                                'id' => 3,
                                'name' => 'Элемент 1.2',
                                'parent_id' => 1,
                                'children' => [],
                            ],
                        ]
                    ],
                    (object)[
                        'id' => 5,
                        'name' => 'Элемент 2',
                        'children' => [],
                    ],
                    (object)[
                        'id' => 6,
                        'name' => 'Элемент 3',
                        'children' => [
                            (object)[
                                'id' => 7,
                                'name' => 'Элемент 3.1',
                                'parent_id' => 6,
                                'children' => [],
                            ],
                            (object)[
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
                    (object)['id' => 1, 'name' => 'Элемент 1', 'parent_id' => null],
                    (object)['id' => 2, 'name' => 'Элемент 1.1', 'parent_id' => 1],
                    (object)['id' => 3, 'name' => 'Элемент 1.2', 'parent_id' => 1],
                    (object)['id' => 4, 'name' => 'Элемент 1.1.1', 'parent_id' => 2],
                    (object)['id' => 5, 'name' => 'Элемент 2', 'parent_id' => null],
                    (object)['id' => 6, 'name' => 'Элемент 3', 'parent_id' => null],
                    (object)['id' => 7, 'name' => 'Элемент 3.1', 'parent_id' => 6],
                    (object)['id' => 8, 'name' => 'Элемент 3.2', 'parent_id' => 6],
                ],
                [
                    (object)[
                        'id' => 1,
                        'name' => 'Элемент 1',
                        'parent_id' => null,
                        'children' => [
                            (object)[
                                'id' => 2,
                                'name' => 'Элемент 1.1',
                                'parent_id' => 1,
                                'children' => [
                                    (object)[
                                        'id' => 4,
                                        'name' => 'Элемент 1.1.1',
                                        'parent_id' => 2,
                                        'children' => [],
                                    ]
                                ],
                            ],
                            (object)[
                                'id' => 3,
                                'name' => 'Элемент 1.2',
                                'parent_id' => 1,
                                'children' => [],
                            ],
                        ]
                    ],
                    (object)[
                        'id' => 5,
                        'name' => 'Элемент 2',
                        'parent_id' => null,
                        'children' => [],
                    ],
                    (object)[
                        'id' => 6,
                        'name' => 'Элемент 3',
                        'parent_id' => null,
                        'children' => [
                            (object)[
                                'id' => 7,
                                'name' => 'Элемент 3.1',
                                'parent_id' => 6,
                                'children' => [],
                            ],
                            (object)[
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
