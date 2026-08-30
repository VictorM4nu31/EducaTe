<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mapea los tipos heredados ('deposit'/'withdraw') al vocabulario actual
     * ('income'/'expense') para que las estadísticas sean consistentes.
     */
    public function up(): void
    {
        DB::table('transactions')->where('type', 'deposit')->update(['type' => 'income']);
        DB::table('transactions')->where('type', 'withdraw')->update(['type' => 'expense']);
    }

    /**
     * Reverse the migrations. (No es reversible de forma exacta; se deja no-op.)
     */
    public function down(): void
    {
        //
    }
};
