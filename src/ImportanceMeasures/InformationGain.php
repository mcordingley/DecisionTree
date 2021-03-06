<?php

namespace MCordingley\DecisionTree\ImportanceMeasures;

final class InformationGain extends Base
{
    public function importance(array $examples, array $partitions, string $outcomeAttribute, string $testedAttribute): float
    {
        $currentEntropy = $this->entropy($this->proportions($examples, $outcomeAttribute));
        $totalExamples = count($examples);

        $expectedEntropy = array_sum(array_map(function (array $partition) use ($outcomeAttribute, $totalExamples) {
            $proportion = count($partition) / $totalExamples;

            return $proportion * $this->entropy($this->proportions($partition, $outcomeAttribute));
        }, $partitions));

        return $currentEntropy - $expectedEntropy;
    }
}
