<?php

namespace MCordingley\DecisionTree\Tests\Attribute;

use MCordingley\DecisionTree\Attributes\Enum;
use MCordingley\DecisionTree\Nodes\Enum as Node;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function testMakeNode()
    {
        $attribute = new Enum('foo');

        static::assertInstanceOf(Node::class, $attribute->makeNode());
    }

    public function testPartition()
    {
        $attribute = new Enum('foo');

        $partitions = $attribute->partition([
            [
                'foo' => 'bar',
                'a' => 1,
                'b' => 2,
                'c' => 3,
            ],
            [
                'foo' => 'bar',
                'a' => 3,
                'b' => 2,
                'c' => 2,
            ],
            [
                'foo' => 'baz',
                'a' => 0,
                'b' => 3,
                'c' => 7,
            ],
        ]);

        static::assertEquals(2, count($partitions));
        static::assertEquals(2, count($partitions['bar']));
        static::assertEquals(1, count($partitions['baz']));
    }
}
