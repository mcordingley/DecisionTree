<?php

namespace MCordingley\DecisionTree;

interface Attribute
{
    public function key(): string;

    public function makeNode(): Node;

    /**
     * @param array $examples
     * @return array Keyed array grouping $examples by the tested attribute.
     */
    public function partition(array $examples): array;
}
