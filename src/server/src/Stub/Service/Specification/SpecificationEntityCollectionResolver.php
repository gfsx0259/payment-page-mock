<?php

namespace App\Stub\Service\Specification;

class SpecificationEntityCollectionResolver
{
    public function __construct(
        private SpecificationEntityInspector $specificationInspector
    ) {
    }

    /**
     * @param array $payload
     * @param SpecificationEntityInterface[] $specificationProviders
     * @return SpecificationEntityInterface
     * @throws SpecificationEntityCollectionException
     */
    public function resolveMostPriority(array $payload, array $specificationProviders): SpecificationEntityInterface
    {
        $scores = [];

        foreach (array_reverse($specificationProviders) as $specificationProvider) {
            $scores[$specificationProvider->getId()] = $this->specificationInspector->calculateScore($payload, $specificationProvider);
        }

        arsort($scores);

        $hasSuitableSpecification = current($scores);

        if ($hasSuitableSpecification) {
            $filteredCollection = array_filter(
                $specificationProviders,
                fn (SpecificationEntityInterface $specificationProvider) => $specificationProvider->getId() === array_key_first($scores)
            );
        } else {
            $filteredCollection = array_filter(
                $specificationProviders,
                fn (SpecificationEntityInterface $specificationProvider) => $specificationProvider->getIsDefault()
            );
        }

        if (!$detectedElement = current($filteredCollection)) {
            throw new SpecificationEntityCollectionException();
        }

        return $detectedElement;
    }
}
