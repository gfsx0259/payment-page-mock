<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefault8a4d718187624b62abbee9483e778903 extends Migration
{
    public function up(): void
    {
        $this->table('stub')
            ->addColumn('id', 'primary')
            ->addColumn('route_id', 'integer')
            ->addColumn('title', 'tinyText')
            ->addColumn('description', 'text')
            ->addColumn('creator_telegram_alias', 'tinyText')
            ->addColumn('default', 'tinyInteger', ['default' => 0])
            ->create();
    }

    public function down(): void
    {
        $this->table('stub')
            ->drop();
    }
}
