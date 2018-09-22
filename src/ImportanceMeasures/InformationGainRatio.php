<?php

namespace MCordingley\DecisionTree\ImportanceMeasures;

use MCordingley\DecisionTree\ImportanceMeasure;

final class InformationGainRatio extends Base
{
    private $gain;

    public function __construct(ImportanceMeasure $gain = null)
    {
        $this->gain = $gain ?: new InformationGain;
    }

    public function importance(array $examples, array $partitions, string $outcomeAttribute, string $testedAttribute): float
    {
        $gain = $this->gain->importance($examples, $partitions, $outcomeAttribute, $testedAttribute);
        $intrinsic = $this->entropy($this->proportions($examples, $testedAttribute));

        return $gain / $intrinsic;
    }
}
