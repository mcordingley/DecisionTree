<?php

namespace MCordingley\DecisionTree;

use MCordingley\DecisionTree\Attribute\Attribute;
use MCordingley\DecisionTree\InformationGain\InformationGain;
use MCordingley\DecisionTree\Tree\Node;

final class Builder
{
    /** @var array */
    private $attributes = [];

    /** @var InformationGain */
    private $informationGain;

    /** @var string */
    private $outcomeAttribute;

    /**
     * @param string $outcomeAttribute
     * @param InformationGain $informationGain
     */
    public function __construct(string $outcomeAttribute, InformationGain $informationGain)
    {
        $this->outcomeAttribute = $outcomeAttribute;
        $this->informationGain = $informationGain;
    }

    /**
     * @param Attribute[] $attributes
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }
    }

    /**
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;
    }

    /**
     * @param array $examples
     * @return Tree
     */
    public function build(array $examples): Tree
    {
        return new Tree($this->buildSubTree($examples, $this->attributes, []));
    }

    /**
     * @param array $examples
     * @param array $attributes
     * @param array $parentExamples
     * @return Node|mixed Either a classification or a node.
     */
    private function buildSubTree(array $examples, array $attributes, array $parentExamples)
    {
        if (!$examples) {
            return $this->plurality($parentExamples);
        }

        if (!$attributes || $this->hasSameClassifications($examples)) {
            return $this->plurality($examples);
        }

        $splitAttribute = $this->calculateSplitAttribute($examples, $attributes);
        $node = $splitAttribute->makeNode();

        array_splice($attributes, array_search($splitAttribute, $attributes), 1);

        foreach ($splitAttribute->partition($examples) as $key => $partition) {
            $node->setBranch($key, $this->buildSubTree($partition, $attributes, $examples));
        }

        return $node;
    }

    /**
     * Returns the outcome value with the highest representation.
     *
     * @param array $examples
     * @return mixed
     */
    private function plurality(array $examples)
    {
        $plurality = null;
        $highestCount = -INF;

        foreach (array_count_values(array_column($examples, $this->outcomeAttribute)) as $key => $count) {
            if ($count > $highestCount) {
                $plurality = $key;
                $highestCount = $count;
            }
        }

        return $plurality;
    }

    /**
     * @param array $examples
     * @return bool
     */
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

    /**
     * Calculates which attribute gives the best split.
     *
     * @param array $examples
     * @param Attribute[] $attributes
     * @return Attribute
     */
    private function calculateSplitAttribute(array $examples, array $attributes): Attribute
    {
        $splitAttribute = null;
        $maxImportance = -INF;

        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $importance = $this->informationGain->importance($examples, $attribute->partition($examples), $this->outcomeAttribute);

            if ($importance > $maxImportance) {
                $splitAttribute = $attribute;
                $maxImportance = $importance;
            }
        }

        return $splitAttribute;
    }
}
