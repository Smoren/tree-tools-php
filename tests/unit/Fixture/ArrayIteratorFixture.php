<?php

declare(strict_types=1);

namespace Smoren\TreeTools\Tests\Unit\Fixture;

class ArrayIteratorFixture implements \Iterator
{
    private array $values;
    private int $i;

    public function __construct(array $values)
    {
        $this->values = $values;
        $this->i      = 0;
    }

    public function rewind(): void
    {
        $this->i = 0;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->values[$this->i];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->i;
    }

    public function next(): void
    {
        ++$this->i;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return array_key_exists($this->i, $this->values);
    }
}
