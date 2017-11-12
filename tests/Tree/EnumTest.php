<?php

namespace MCordingley\DecisionTree\Tests\Tree;

use MCordingley\DecisionTree\Tree\Enum;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function testTest()
    {
        $node = new Enum('foo');

        $node->setBranch('bar', 1);
        $node->setBranch('baz', 2);

        static::assertEquals(1, $node->test(['foo' => 'bar']));
        static::assertEquals(2, $node->test(['foo' => 'baz']));
    }
}
