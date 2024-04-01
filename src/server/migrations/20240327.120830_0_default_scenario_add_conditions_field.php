<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefaultE2cc8bcd7fddbdcf818da08a6d8f9b95 extends Migration
{
    public function up(): void
    {
        $this->table('stub')
            ->addColumn('conditions', 'json')
            ->update();
    }

    public function down(): void
    {
        $this->table('stub')
            ->dropColumn('conditions')
            ->update();
    }
}
