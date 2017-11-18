<?php

namespace MCordingley\DecisionTree\Tests;

use MCordingley\DecisionTree\Attributes\Boolean;
use MCordingley\DecisionTree\Attributes\Enum;
use MCordingley\DecisionTree\Builder;
use MCordingley\DecisionTree\ImportanceMeasures\InformationGain;
use PHPUnit\Framework\TestCase;

final class BuilderTest extends TestCase
{
    public function testSimpleTree()
    {
        $values = [
            [true,  false, false, true,  'Some', '$$$', false, true,  'French',  '0-10',  true],
            [true,  false, false, true,  'Full', '$',   false, false, 'Thai',    '30-60', false],
            [false, true,  false, false, 'Some', '$',   false, false, 'Burger',  '0-10',  true],
            [true,  false, true,  true,  'Full', '$',   true,  false, 'Thai',    '10-30', true],
            [true,  false, true,  false, 'Full', '$$$', false, true,  'French',  '>60',   false],
            [false, true,  false, true,  'Some', '$$',  true,  true,  'Italian', '0-10',  true],
            [false, true,  false, false, 'None', '$',   true,  false, 'Burger',  '0-10',  false],
            [false, false, false, true,  'Some', '$$',  true,  true,  'Thai',    '0-10',  true],
            [false, true,  true,  false, 'Full', '$',   true,  false, 'Burger',  '>60',   false],
            [true,  true,  true,  true,  'Full', '$$$', false, true,  'Italian', '10-30', false],
            [false, false, false, false, 'None', '$',   false, false, 'Thai',    '0-10',  false],
            [true,  true,  true,  true,  'Full', '$',   false, false, 'Burger',  '30-60', true],
        ];

        $keyExample = function(array $example): array {
            $keys = ['Alt', 'Bar', 'Fri', 'Hun', 'Pat', 'Price', 'Rain', 'Res', 'Type', 'Est', 'WillWait'];

            return array_combine($keys, $example);
        };

        $examples = array_map($keyExample, $values);

        $builder = new Builder('WillWait', new InformationGain);

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

        $tree = $builder->build($examples);

        // Examples that trace expected paths through the tree.
        static::assertEquals(0, $tree->classify($keyExample([1, 0, 0, 1, 'None', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(1, $tree->classify($keyExample([1, 0, 0, 1, 'Some', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(0, $tree->classify($keyExample([1, 0, 0, 0, 'Full', '$$$', 0, 1, 'French',   '0-10', 1])));
        static::assertEquals(0, $tree->classify($keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Italian',  '0-10', 1])));
        static::assertEquals(0, $tree->classify($keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Thai',     '0-10', 1])));
        static::assertEquals(1, $tree->classify($keyExample([1, 0, 1, 1, 'Full', '$$$', 0, 1, 'Thai',     '0-10', 1])));
        static::assertEquals(1, $tree->classify($keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'Burger',   '0-10', 1])));

        // Example leads to testing a key that doesn't exist.
        static::assertNull($tree->classify($keyExample([1, 0, 0, 1, 'Full', '$$$', 0, 1, 'French',   '0-10', 1])));
    }
}
