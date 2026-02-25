<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('payment_period')->default('once')->after('days');
        });

        Schema::table('calculation_items', function (Blueprint $table) {
            $table->string('payment_period')->default('once')->after('days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('payment_period');
        });

        Schema::table('calculation_items', function (Blueprint $table) {
            $table->dropColumn('payment_period');
        });
    }
};
