<?php

namespace MCordingley\DecisionTree\ImportanceMeasures;

abstract class Base implements ImportanceMeasure
{
    /**
     * @param float[] $proportions e.g. [0.8, 0.1, 0.05, 0.05]
     * @return float
     */
    final protected function entropy(array $proportions): float
    {
        return array_reduce($proportions, function ($carry, $proportion) {
            return $carry - ($proportion > 0 ? $proportion * log($proportion, 2) : 0);
        }, 0.0);
    }

    /**
     * @param array $examples
     * @param string $outcomeAttribute
     * @return array e.g. [0.8, 0.1, 0.05, 0.05]
     */
    final protected function proportions(array $examples, string $outcomeAttribute): array
    {
        $values = array_map(function ($value) {
            return is_bool($value) ? (int) $value : $value;
        }, array_column($examples, $outcomeAttribute));

        $counts = array_count_values($values);
        $total = array_sum($counts);

        return array_map(function (int $count) use ($total): float {
            return $count / $total;
        }, $counts);
    }
}
