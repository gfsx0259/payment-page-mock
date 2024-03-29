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
    public function findByRoute(int $routeId): array
    {
        $where = [
            'route_id' => $routeId,
        ];

        return $this->select()->where($where)->fetchAll();
    }
}
