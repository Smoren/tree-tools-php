<?php

namespace Smoren\TreeTools\Tests\Unit\Fixture;

class TreeItemFixture
{
    public int $id;
    public ?int $parent_id;
    private string $name;

    /**
     * @param array{id: int, parent_id: int|null, name: string} $config
     */
    public function __construct(array $config)
    {
        $this->id = $config['id'];
        $this->parent_id = $config['parent_id'] ?? null;
        $this->name = $config['name'];
    }

    public function getName(): string
    {
        return $this->name;
    }
}
