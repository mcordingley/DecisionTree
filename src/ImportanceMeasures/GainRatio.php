<?php

namespace MCordingley\DecisionTree\ImportanceMeasures;

final class GainRatio extends Base
{
    /** @var ImportanceMeasure */
    private $gain;

    /**
     * @param ImportanceMeasure|null $gain
     */
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
