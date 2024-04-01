<?php

namespace App\Migration;

use Cycle\Migrations\Migration;

class OrmDefaultCfde22901eb7770b50fb7562a9e8fb64 extends Migration
{
    public function up(): void
    {
        $this->table('resource')
            ->addColumn('default', 'bool', ['default' => 0])
            ->update();
    }

    public function down(): void
    {
        $this->table('resource')
            ->dropColumn('default')
            ->update();
    }
}
