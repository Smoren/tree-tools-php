<?php

namespace Smoren\TreeTools\Tests\Unit\TreeBuilder;

use Smoren\TreeTools\Tests\Unit\Fixture\TreeItemFixture;
use Smoren\TreeTools\TreeBuilder;

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
        $result = TreeBuilder::build($input);

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
                    ($item1 = new TreeItemFixture(['id' => 1, 'name' => 'Item 1', 'parent_id' => null])),
                    ($item11 = new TreeItemFixture(['id' => 2, 'name' => 'Item 1.1', 'parent_id' => 1])),
                    ($item12 = new TreeItemFixture(['id' => 3, 'name' => 'Item 1.2', 'parent_id' => 1])),
                    ($item111 = new TreeItemFixture(['id' => 4, 'name' => 'Item 1.1.1', 'parent_id' => 2])),
                    ($item2 = new TreeItemFixture(['id' => 5, 'name' => 'Item 2', 'parent_id' => null])),
                    ($item3 = new TreeItemFixture(['id' => 6, 'name' => 'Item 3', 'parent_id' => null])),
                    ($item31 = new TreeItemFixture(['id' => 7, 'name' => 'Item 3.1', 'parent_id' => 6])),
                    ($item32 = new TreeItemFixture(['id' => 8, 'name' => 'Item 3.2', 'parent_id' => 6])),
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
