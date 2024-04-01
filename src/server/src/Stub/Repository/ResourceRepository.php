<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Resource;
use Cycle\ORM\Select;

final class ResourceRepository extends Select\Repository
{
    /**
     * @param string $path
     * @return Resource[]
     */
    public function findByPath(string $path): array
    {
        return $this->select()->where(['path' => $path])->fetchAll();
    }
}
