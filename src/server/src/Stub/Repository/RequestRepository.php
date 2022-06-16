<?php

declare(strict_types=1);

namespace App\Stub\Repository;

use App\Stub\Entity\Request;
use Cycle\ORM\Select;
use DateInterval;
use Safe\DateTime;

final class RequestRepository extends Select\Repository
{
    private const MYSQL_DATETIME_UTC_FORMAT = 'Y-m-d H:i:sP';

    /**
     * @return Request[]
     */
    public function findActual(): array
    {
        $fromDateTime = (new DateTime())->sub((new DateInterval('PT10M')))->format(self::MYSQL_DATETIME_UTC_FORMAT);

        return $this->select()
            ->where('created_at', '>', $fromDateTime)
            ->fetchAll();
    }
}
