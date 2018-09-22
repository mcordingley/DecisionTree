<?php

namespace MCordingley\DecisionTree\Tests\ImportanceMeasures;

use MCordingley\DecisionTree\Attributes\Enum;
use MCordingley\DecisionTree\ImportanceMeasures\InformationGain;
use MCordingley\DecisionTree\ImportanceMeasures\InformationGainRatio;
use PHPUnit\Framework\TestCase;

final class InformationGainRatioTest extends TestCase
{
    public function testImportance()
    {
        $attribute = new Enum('foo');

        $examples = [
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
                'a' => 0,
                'b' => 3,
                'c' => 7,
                'WillWait' => false,
            ],
        ];

        $partitions = $attribute->partition($examples);

        $gainRatio = new InformationGainRatio(new InformationGain);

        static::assertEquals(0.57938, round($gainRatio->importance($examples, $partitions, 'WillWait', 'a'), 5));
    }
}
