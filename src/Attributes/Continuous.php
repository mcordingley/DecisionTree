<?php

namespace MCordingley\DecisionTree\Attributes;

use MCordingley\DecisionTree\ImportanceMeasure;
use MCordingley\DecisionTree\Node;
use MCordingley\DecisionTree\Nodes\Continuous as ContinuousNode;

final class Continuous extends Base
{
    /** @var ImportanceMeasure */
    private $measure;

    /** @var string */
    private $outcomeAttribute;

    public function __construct(string $key, ImportanceMeasure $measure, string $outcomeAttribute)
    {
        parent::__construct($key);

        $this->measure = $measure;
        $this->outcomeAttribute = $outcomeAttribute;
    }

    public function makeNode(): Node
    {
        return new ContinuousNode($this->key);
    }

    public function partition(array $examples): array
    {
        return $this->partitionByKeys($examples, $this->calculateSplitPoints($examples));
    }

    private function calculateSplitPoints(array $examples): array
    {
        usort($examples, function (array $a, array $b) {
            return $a[$this->outcomeAttribute] <=> $b[$this->outcomeAttribute];
        });

        $maxImportance = -INF;
        $splitPoint = 0;

        foreach ($examples as $index => $example) {
            // Splitting only makes sense when the key value changes.
            if (!$index || $example[$this->key] === $examples[$index - 1][$this->key]) {
                continue;
            }

            $importance = $this->measure->importance(
                $examples,
                [
                    array_slice($examples, 0, $index),
                    array_slice($examples, $index),
                ],
                $this->outcomeAttribute,
                $this->key
            );

            if ($importance > $maxImportance) {
                $maxImportance = $importance;
                $splitPoint = $index;
            }
        }

        return [$examples[0][$this->key], $examples[$splitPoint][$this->key]];
    }

    private function partitionByKeys(array $examples, array $keys): array
    {
        sort($keys);

        $partitioned = [];

        foreach ($keys as $key) {
            $partitioned[$key] = [];
        }

        foreach ($examples as $example) {
            foreach ($partitioned as $partitionKey => &$partition) {
                if ($example[$this->key] >= $partitionKey) {
                    $partition[] = $example;
                    continue;
                }
            }
        }

        return $partitioned;
    }
}
