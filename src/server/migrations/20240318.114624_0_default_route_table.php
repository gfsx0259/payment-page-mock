<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefaultDcbd3a78648d84b3c558009c8d90ceb5 extends Migration
{
    public function up(): void
    {
        $this->table('route')
            ->addColumn('id', 'primary')
            ->addColumn('route', 'tinyText')
            ->addColumn('title', 'tinyText')
            ->addColumn('logo', 'tinyText')
            ->addColumn('type', 'integer')
            ->create();
    }

    public function down(): void
    {
        $this->table('route')
            ->drop();
    }
}
