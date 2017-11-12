<?php

namespace MCordingley\DecisionTree\Tests\Nodes;

use MCordingley\DecisionTree\Nodes\Enum;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function testTest()
    {
        $node = new Enum('foo');

        $node->setBranch('bar', 1);
        $node->setBranch('baz', 2);

        static::assertEquals(1, $node->classify(['foo' => 'bar']));
        static::assertEquals(2, $node->classify(['foo' => 'baz']));
    }
}
