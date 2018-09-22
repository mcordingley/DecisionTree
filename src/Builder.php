<?php

namespace MCordingley\DecisionTree;

final class Builder
{
    private $attributes = [];
    private $measure;
    private $outcomeAttribute;

    public function __construct(string $outcomeAttribute, ImportanceMeasure $measure)
    {
        $this->outcomeAttribute = $outcomeAttribute;
        $this->measure = $measure;
    }

    /**
     * @param Attribute[] $attributes
     */
    public function addAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }
    }

    public function addAttribute(Attribute $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    public function build(array $examples)
    {
        return $this->buildSubTree($examples, $this->attributes);
    }

    private function buildSubTree(array $examples, array $attributes, array $parentExamples = [])
    {
        if (!$examples) {
            return $this->plurality($parentExamples);
        }

        if (!$attributes || $this->hasSameClassifications($examples)) {
            return $this->plurality($examples);
        }

        $splitAttribute = $this->findBestSplit($examples, $attributes);
        $node = $splitAttribute->makeNode();

        array_splice($attributes, array_search($splitAttribute, $attributes), 1);

        foreach ($splitAttribute->partition($examples) as $key => $partition) {
            $node->setBranch($key, $this->buildSubTree($partition, $attributes, $examples));
        }

        return $node;
    }

    private function plurality(array $examples)
    {
        $plurality = null;
        $highestCount = -INF;

        $values = array_map(function ($value) {
            return is_bool($value) ? (int) $value : $value;
        }, array_column($examples, $this->outcomeAttribute));

        foreach (array_count_values($values) as $key => $count) {
            if ($count > $highestCount) {
                $plurality = $key;
                $highestCount = $count;
            }
        }

        return $plurality;
    }

    private function hasSameClassifications(array $examples): bool
    {
        $firstClassification = reset($examples)[$this->outcomeAttribute];

        foreach ($examples as $example) {
            if ($example[$this->outcomeAttribute] !== $firstClassification) {
                return false;
            }
        }

        return true;
    }

    private function findBestSplit(array $examples, array $attributes): Attribute
    {
        $splitAttribute = null;
        $maxImportance = -INF;

        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $importance = $this->measure->importance($examples, $attribute->partition($examples), $this->outcomeAttribute, $attribute->key());

            if ($importance > $maxImportance) {
                $splitAttribute = $attribute;
                $maxImportance = $importance;
            }
        }

        return $splitAttribute;
    }
}
