<?php

namespace MCordingley\DecisionTree;

interface ImportanceMeasure
{
    /**
     * @param array $examples
     * @param array $partitions
     * @param string $outcomeAttribute
     * @param string $testedAttribute
     * @return float
     */
    public function importance(array $examples, array $partitions, string $outcomeAttribute, string $testedAttribute): float;
}
