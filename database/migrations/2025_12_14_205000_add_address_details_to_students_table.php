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
        Schema::table('students', function (Blueprint $table) {
            $table->string('rt', 5)->nullable()->after('street_address');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('house_number')->nullable()->after('rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'house_number']);
        });
    }
};
