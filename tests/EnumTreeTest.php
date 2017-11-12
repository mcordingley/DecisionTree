<?php

namespace MCordingley\DecisionTree\Tests;

use MCordingley\DecisionTree\Attributes\Boolean;
use MCordingley\DecisionTree\Attributes\Enum;
use MCordingley\DecisionTree\Builder;
use MCordingley\DecisionTree\ImportanceMeasures\Gain;
use PHPUnit\Framework\TestCase;

final class EnumTreeTest extends TestCase
{
    public function testEndToEnd()
    {
        $builder = new Builder('WillWait', new Gain);

        $builder->addAttributes([
            new Boolean('Alt'),
            new Boolean('Bar'),
            new Boolean('Fri'),
            new Boolean('Hun'),
            new Enum('Pat'),
            new Enum('Price'),
            new Boolean('Rain'),
            new Boolean('Res'),
            new Enum('Type'),
            new Enum('Est'),
        ]);

        $tree = $builder->build($this->getExamples());

        // Examples that trace expected paths through the tree.
        static::assertEquals(0, $tree->test($this->keyExample([1, 0, 0, 1, 'None', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(1, $tree->test($this->keyExample([1, 0, 0, 1, 'Some', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(0, $tree->test($this->keyExample([1, 0, 0, 0, 'Full', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(0, $tree->test($this->keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Italian',  '0-10', 1])));
        static::assertEquals(0, $tree->test($this->keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Thai',     '0-10', 1])));
        static::assertEquals(1, $tree->test($this->keyExample([1, 0, 1, 1, 'Full', '$$$', 0, 1, 'Thai',     '0-10', 1])));
        static::assertEquals(1, $tree->test($this->keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Burger',   '0-10', 1])));

        // Example leads to testing a key that doesn't exist.
        static::assertNull($tree->test($this->keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'French',   '0-10', 1])));
    }

    private function getExamples(): array
    {

        $values = [
            [1, 0, 0, 1, 'Some', '$$$', 0, 1, 'French',     '0-10',     1],
            [1, 0, 0, 1, 'Full', '$',   0, 0, 'Thai',       '30-60',    0],
            [0, 1, 0, 0, 'Some', '$',   0, 0, 'Burger',     '0-10',     1],
            [1, 0, 1, 1, 'Full', '$',   1, 0, 'Thai',       '10-30',    1],
            [1, 0, 1, 0, 'Full', '$$$', 0, 1, 'French',     '>60',      0],
            [0, 1, 0, 1, 'Some', '$$',  1, 1, 'Italian',    '0-10',     1],
            [0, 1, 0, 0, 'None', '$',   1, 0, 'Burger',     '0-10',     0],
            [0, 0, 0, 1, 'Some', '$$',  1, 1, 'Thai',       '0-10',     1],
            [0, 1, 1, 0, 'Full', '$',   1, 0, 'Burger',     '>60',      0],
            [1, 1, 1, 1, 'Full', '$$$', 0, 1, 'Italian',    '10-30',    0],
            [0, 0, 0, 0, 'None', '$',   0, 0, 'Thai',       '0-10',     0],
            [1, 1, 1, 1, 'Full', '$',   0, 0, 'Burger',     '30-60',    1],
        ];

        return array_map([$this, 'keyExample'], $values);
    }

    private function keyExample(array $example): array
    {
        $keys = ['Alt', 'Bar', 'Fri', 'Hun', 'Pat', 'Price', 'Rain', 'Res', 'Type', 'Est', 'WillWait'];

        return array_combine($keys, $example);
    }
}
