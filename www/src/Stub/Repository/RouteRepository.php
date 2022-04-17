<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Route;
use Cycle\ORM\Select;

/**
 * @method Route[] findAll()
 * @method Route findOne(array $scope = [])()
 */
final class RouteRepository extends Select\Repository
{
    /**
     * @param string $path
     * @return Route
     */
    public function findByPath(string $path): Route
    {
        return $this->select()->where(['route' => $path])->fetchOne();
    }
}
