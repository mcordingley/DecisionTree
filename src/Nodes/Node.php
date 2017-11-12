<?php

namespace MCordingley\DecisionTree\Nodes;

interface Node
{
    /**
     * @param string $key
     * @param mixed $value Either a classification or another node.
     */
    public function setBranch(string $key, $value);

    /**
     * @param array $example
     * @return Node|mixed Either a classification or another node.
     */
    public function test(array $example);
}