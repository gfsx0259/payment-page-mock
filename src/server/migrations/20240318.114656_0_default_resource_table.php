<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefault9278a4feae2b365367da9e3e1a31706b extends Migration
{
    public function up(): void
    {
        $this->table('resource')
            ->addColumn('id', 'primary')
            ->addColumn('path', 'tinyText')
            ->addColumn('alias', 'tinyText')
            ->addColumn('description', 'tinyText')
            ->addColumn('content_type', 'tinyText')
            ->addColumn('content', 'text')
            ->create();
    }

    public function down(): void
    {
        $this->table('resource')
            ->drop();
    }
}
