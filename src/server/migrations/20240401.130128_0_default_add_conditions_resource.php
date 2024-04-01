<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefault4ebe12e03752e83bfc422a513dd6f8a1 extends Migration
{
    public function up(): void
    {
        $this->table('resource')
            ->addColumn('conditions', 'json')
            ->update();
    }

    public function down(): void
    {
        $this->table('resource')
            ->dropColumn('conditions')
            ->update();
    }
}
