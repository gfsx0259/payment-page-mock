<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Callback;
use App\Stub\Session\State;
use Cycle\ORM\Select;

/**
 * @method Callback[] findAll()
 * @method Callback findOne(array $scope = [])()
 */
final class CallbackRepository extends Select\Repository
{
    private StubRepository $stubRepository;

    /**
     * @param Select $select
     * @param StubRepository $stubRepository
     */
    public function __construct(Select $select, StubRepository $stubRepository)
    {
        parent::__construct($select);

        $this->stubRepository = $stubRepository;
    }

    /**
     * @param int $stubId
     * @return Callback[]
     */
    public function findByStub(int $stubId): array
    {
        return $this->select()->where(['stub_id' => $stubId])->fetchAll();
    }

    /**
     * @param State $state
     * @return Callback
     */
    public function findCurrentOne(State $state): Callback
    {
        $stubs = $this->stubRepository->findDefaultByRoute($state->getRouteId());

        $callbacks = current($stubs)->getCallbacks();

        $cursor = min($state->getCursor(), $callbacks->count()) - 1;

        if ($cursor < 0) {
            $cursor = 0;
        }

        return $callbacks->get($cursor);
    }
}
