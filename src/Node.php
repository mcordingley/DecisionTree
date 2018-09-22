<?php

namespace MCordingley\DecisionTree;

interface Node
{
    public function classify(array $example);

    /**
     * @param string $key
     * @param mixed $value Either a classification or another node.
     * @return void
     */
    public function setBranch(string $key, $value): void;
}