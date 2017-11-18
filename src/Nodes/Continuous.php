<?php

namespace MCordingley\DecisionTree\Nodes;

final class Continuous extends Base
{
    public function classify(array $example)
    {
        $value = $example[$this->key];

        // Note that the keys for $this->branches are the minimum values for their respective branches.
        foreach ($this->branches as $branchKey => $branch) {
            if ($value >= $branchKey) {
                return $branch;
            }
        }

        return null;
    }
}
