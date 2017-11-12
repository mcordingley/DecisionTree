<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\Nodes\Node;

interface Attribute
{
    /**
     * @return Node
     */
    public function makeNode(): Node;

    /**
     * @param array $examples
     * @return array Keyed array grouping $examples by the tested attribute.
     */
    public function partition(array $examples): array;
}
