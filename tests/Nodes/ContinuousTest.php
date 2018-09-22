<?php

namespace MCordingley\DecisionTree\Tests\Nodes;

use MCordingley\DecisionTree\Nodes\Continuous;
use PHPUnit\Framework\TestCase;

final class ContinuousTest extends TestCase
{
    public function testClassify()
    {
        $node = new Continuous('foo');

        $node->setBranch('10', 2);
        $node->setBranch('5.5', 1);

        static::assertEquals(1, $node->classify(['foo' => '7']));
        static::assertEquals(2, $node->classify(['foo' => '10']));
    }
}
