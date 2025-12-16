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
            $table->string('province_id')->nullable()->after('religion');
            $table->string('city_id')->nullable()->after('province_id');
            $table->string('district_id')->nullable()->after('city_id');
            $table->string('village_id')->nullable()->after('district_id');
            $table->text('street_address')->nullable()->after('village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'province_id',
                'city_id',
                'district_id',
                'village_id',
                'street_address'
            ]);
        });
    }
};
