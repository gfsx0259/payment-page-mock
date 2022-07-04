<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Callback;
use Cycle\ORM\Select;

/**
 * @method Callback[] findAll()
 * @method Callback findOne(array $scope = [])()
 */
final class CallbackRepository extends Select\Repository
{
}
