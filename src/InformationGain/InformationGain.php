<?php

namespace MCordingley\DecisionTree\InformationGain;

interface InformationGain
{
    /**
     * @param array $examples
     * @param array $partitions
     * @param string $outcomeAttribute
     * @return float
     */
    public function importance(array $examples, array $partitions, string $outcomeAttribute): float;
}
