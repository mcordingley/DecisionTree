<?php

namespace MCordingley\DecisionTree;

interface ImportanceMeasure
{
    public function importance(array $examples, array $partitions, string $outcomeAttribute, string $testedAttribute): float;
}
