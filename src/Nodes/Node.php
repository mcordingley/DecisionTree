<?php

namespace MCordingley\DecisionTree\Nodes;

interface Node
{
    public function classify(array $example);

    /**
     * @param string $key
     * @param mixed $value Either a classification or another node.
     */
    public function setBranch(string $key, $value);
}