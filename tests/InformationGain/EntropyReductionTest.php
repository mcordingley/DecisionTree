<?php

namespace MCordingley\DecisionTree\Tests\InformationGain;

use MCordingley\DecisionTree\ImportanceMeasures\Gain;
use PHPUnit\Framework\TestCase;

final class EntropyReductionTest extends TestCase
{
    public function testImportance()
    {
        $gain = new Gain;

        static::assertEquals(
            1,
            $gain->importance(
                [
                    ['foo' => 1, 'bar' => 1],
                    ['foo' => 1, 'bar' => 2],
                    ['foo' => 2, 'bar' => 1],
                    ['foo' => 2, 'bar' => 2],
                ],
                [
                    [
                        ['foo' => 1, 'bar' => 1],
                        ['foo' => 2, 'bar' => 1],
                    ],
                    [
                        ['foo' => 1, 'bar' => 2],
                        ['foo' => 2, 'bar' => 2],
                    ]
                ],
                'bar'
            )
        );
    }
}
