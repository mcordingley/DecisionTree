<?php

namespace MCordingley\DecisionTree;

interface Attribute
{
    /**
     * @return string
     */
    public function key(): string;

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
