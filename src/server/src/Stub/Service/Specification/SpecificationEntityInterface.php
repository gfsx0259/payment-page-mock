<?php

namespace App\Stub\Service\Specification;

/**
 * Specifies entity with specification rules set
 */
interface SpecificationEntityInterface
{
    public function getId(): int;
    public function getIsDefault(): bool;
    public function getSpecification(): array;
}
