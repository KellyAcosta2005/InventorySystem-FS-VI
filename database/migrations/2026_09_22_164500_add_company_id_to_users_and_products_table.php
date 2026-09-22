<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('companies')->insertOrIgnore(['name' => 'Empresa por defecto']);

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->default(1)->constrained()->restrictOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_sku_unique');
            $table->foreignId('company_id')->default(1)->constrained()->restrictOnDelete();
            $table->unique(['company_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('company_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['company_id', 'sku']);
            $table->dropConstrainedForeignId('company_id');
            $table->string('sku')->unique();
        });
    }
};
