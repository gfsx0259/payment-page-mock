<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefaultE2cc8bcd7fddbdcf818da08a6d8f9b94 extends Migration
{
    public function up(): void
    {
        $this->table('callback')
            ->addColumn('id', 'primary')
            ->addColumn('stub_id', 'integer')
            ->addColumn('order', 'integer')
            ->addColumn('body', 'text')
            ->create();
    }

    public function down(): void
    {
        $this->table('callback')
            ->drop();
    }
}
