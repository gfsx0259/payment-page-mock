<?php

declare(strict_types=1);

namespace App\Stub;

use App\Stub\Entity\Stub;
use Cycle\ORM\Select;

/**
 * @method Stub[] findAll()
 * @method Stub findOne(array $scope = [])()
 */
final class StubRepository extends Select\Repository
{

}
