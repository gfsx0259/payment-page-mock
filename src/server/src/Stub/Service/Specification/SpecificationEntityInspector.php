<?php

namespace App\Stub\Service\Specification;

use Yiisoft\Arrays\ArrayHelper;

final class SpecificationEntityInspector
{
    /**
     * Calculate and return weight if all entity conditions are met, otherwise zero
     *
     * @param array $payload
     * @param SpecificationEntityInterface $specificationEntity
     * @return int
     */
    public function calculateScore(array $payload, SpecificationEntityInterface $specificationEntity): int
    {
        $score = 0;

        if (!$conditions = $specificationEntity->getSpecification()) {
            return $score;
        }

        foreach ($conditions as $key => $value) {
            if (ArrayHelper::getValueByPath($payload, $key) == $value) {
                $score += 1;
            }
        }

        return count($conditions) === $score
            ? $score
            : 0;
    }
}
