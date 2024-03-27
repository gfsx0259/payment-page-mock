<?php

declare(strict_types=1);

namespace App\tests\Unit;

use App\Stub\Entity\Stub;
use App\Stub\Service\Specification\SpecificationEntityCollectionResolver;
use App\Stub\Service\Specification\SpecificationEntityInspector;
use Codeception\Test\Unit;

final class SpecificationEntityCollectionResolverTest extends Unit
{
    public function testSpecificationEntityCollectionResolver(): void
    {
        $resolver = new SpecificationEntityCollectionResolver(new SpecificationEntityInspector());

        $collection = $this->getCollection();

        $this->assertEquals(1, $resolver->resolveMostPriority(['amount' => 2000], $collection)->getId());
        $this->assertEquals(2, $resolver->resolveMostPriority(['amount' => 4000], $collection)->getId());
        $this->assertEquals(3, $resolver->resolveMostPriority(['amount' => 6000], $collection)->getId());

        $collectionDeep = $this->getCollectionDeep();

        $this->assertEquals(1, $resolver->resolveMostPriority(['amount' => 2000, 'customer_id' => 10, 'currency' => 'USD'], $collectionDeep)->getId());
        $this->assertEquals(3, $resolver->resolveMostPriority(['amount' => 2000, 'customer_id' => 10], $collectionDeep)->getId());
        $this->assertEquals(3, $resolver->resolveMostPriority(['amount' => 2000], $collectionDeep)->getId());
        $this->assertEquals(2, $resolver->resolveMostPriority(['customer_id' => 10], $collectionDeep)->getId());
        $this->assertEquals(4, $resolver->resolveMostPriority(['currency' => 'USD'], $collectionDeep)->getId());
    }

    private function getCollection(): array
    {
        return [
            $this->buildScenario(1, ['amount' => 2000]),
            $this->buildScenario(2, ['amount' => 4000]),
            $this->buildScenario(3, [], true),
        ];
    }

    private function getCollectionDeep(): array
    {
        return [
            $this->buildScenario(1, ['amount' => 2000, 'customer_id' => 10, 'currency' => 'USD']),
            $this->buildScenario(2, ['customer_id' => 10]),
            $this->buildScenario(3, ['amount' => 2000]),
            $this->buildScenario(4, [], true),
        ];
    }

    private function buildScenario(int $id, array $data, bool $default = false): Stub
    {
        return (new Stub('', '', '', json_encode($data)))
            ->setId($id)
            ->setDefault($default);
    }
}
