<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Stub\Collection\ArrayCollection;
use App\Stub\Collection\ReplaceIterator;
use Codeception\Test\Unit;

final class ReplaceIteratorTest extends Unit
{
    private ReplaceIterator $replaceIterator;

    public function _before()
    {
        $this->replaceIterator = new ReplaceIterator();
    }

    public function testBaseScenario(): void
    {
        $collection = new ArrayCollection([
            'request_id' => '{{REQUEST_ID}}'
        ]);

        $collection = $this->replaceIterator->replace(
            $collection,
            '{{REQUEST_ID}}',
            'uniqRequestId',
        );

        $this->assertEquals('uniqRequestId', $collection->get('request_id'));
    }

    public function testRecursive(): void
    {
        $collection = new ArrayCollection([
            'acs' => [
                'acs_url' => '{{TERM_URL}}'
            ],
        ]);

        $collection = $this->replaceIterator->replace(
            $collection,
            '{{TERM_URL}}',
            'termUrl',
        );

        $this->assertEquals('termUrl', $collection->get('acs.acs_url'));
    }
}
