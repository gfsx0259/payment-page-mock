<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Stub;
use Cycle\ORM\Select;

/**
 * @method Stub[] findAll()
 * @method Stub findOne(array $scope = [])()
 */
final class StubRepository extends Select\Repository
{
    /**
     * @param int $routeId
     * @return Stub[]
     */
    public function findByRoute(int $routeId): array
    {
        return $this->select()->where(['route_id' => $routeId])->fetchAll();
    }

    /**
     * @param int $routeId
     * @return Stub
     */
    public function findDefaultByRoute(int $routeId): Stub
    {
        $where = [
            'route_id' => $routeId,
            'default' => true,
        ];

        return $this->select()->fetchOne($where);
    }
}
