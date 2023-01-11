<?php

namespace Smoren\TreeTools\Tests\Unit\TreeMaker;

use Smoren\TreeTools\Tests\Unit\Fixture\TreeItemFixture;
use Smoren\TreeTools\TreeMaker;

class ClassObjectTest extends \Codeception\Test\Unit
{
    /**
     * @dataProvider dataProviderForMain
     * @param array $input
     * @param array $expected
     * @return void
     */
    public function testMain(array $input, array $expected): void
    {
        // When
        $result = TreeMaker::fromList($input);

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderForMain(): array
    {
        return [
            [
                [],
                [],
            ],
            [
                [
                    ($item1 = new TreeItemFixture(['id' => 1, 'name' => 'Элемент 1', 'parent_id' => null])),
                    ($item11 = new TreeItemFixture(['id' => 2, 'name' => 'Элемент 1.1', 'parent_id' => 1])),
                    ($item12 = new TreeItemFixture(['id' => 3, 'name' => 'Элемент 1.2', 'parent_id' => 1])),
                    ($item111 = new TreeItemFixture(['id' => 4, 'name' => 'Элемент 1.1.1', 'parent_id' => 2])),
                    ($item2 = new TreeItemFixture(['id' => 5, 'name' => 'Элемент 2', 'parent_id' => null])),
                    ($item3 = new TreeItemFixture(['id' => 6, 'name' => 'Элемент 3', 'parent_id' => null])),
                    ($item31 = new TreeItemFixture(['id' => 7, 'name' => 'Элемент 3.1', 'parent_id' => 6])),
                    ($item32 = new TreeItemFixture(['id' => 8, 'name' => 'Элемент 3.2', 'parent_id' => 6])),
                ],
                [
                    [
                        'item' => $item1,
                        'children' => [
                            [
                                'item' => $item11,
                                'children' => [
                                    [
                                        'item' => $item111,
                                        'children' => [],
                                    ],
                                ],
                            ],
                            [
                                'item' => $item12,
                                'children' => [],
                            ],
                        ],
                    ],
                    [
                        'item' => $item2,
                        'children' => [],
                    ],
                    [
                        'item' => $item3,
                        'children' => [
                            [
                                'item' => $item31,
                                'children' => [],
                            ],
                            [
                                'item' => $item32,
                                'children' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
