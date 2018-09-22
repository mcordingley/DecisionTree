<?php

namespace MCordingley\DecisionTree\Tests\Attributes;

use MCordingley\DecisionTree\Attributes\Continuous;
use MCordingley\DecisionTree\ImportanceMeasures\InformationGain;
use MCordingley\DecisionTree\Nodes\Continuous as Node;
use PHPUnit\Framework\TestCase;

final class ContinuousTest extends TestCase
{
    public function testMakeNode()
    {
        $attribute = new Continuous('foo', new InformationGain, 'WillWait');

        static::assertInstanceOf(Node::class, $attribute->makeNode());
    }

    public function testPartition()
    {
        $attribute = new Continuous('a', new InformationGain, 'WillWait');

        $partitions = $attribute->partition([
            [
                'foo' => 'bar',
                'a' => 1,
                'b' => 2,
                'c' => 3,
                'WillWait' => true,
            ],
            [
                'foo' => 'bar',
                'a' => 3,
                'b' => 2,
                'c' => 2,
                'WillWait' => true,
            ],
            [
                'foo' => 'baz',
                'a' => 1,
                'b' => 3,
                'c' => 7,
                'WillWait' => false,
            ],
        ]);
//var_dump($partitions);
        static::assertEquals(2, count($partitions));
        static::assertEquals(2, count($partitions['']));
        static::assertEquals(1, count($partitions['3']));
    }
}
