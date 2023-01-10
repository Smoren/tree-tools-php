<?php

declare(strict_types=1);

namespace Smoren\TreeTools\Tests\Unit\Fixture;

class GeneratorFixture
{
    public static function getGenerator(array $values): \Generator
    {
        foreach ($values as $value) {
            yield $value;
        }
    }
}
