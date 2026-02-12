<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(<<<'SQL'
        CREATE DOMAIN TIPO_USUARIO AS VARCHAR(50) CHECK (
            VALUE IN (
                'cliente',
                'administrador',
                'veterinario',
                'vendedor'
            )
        );

        SQL);
    }
};
