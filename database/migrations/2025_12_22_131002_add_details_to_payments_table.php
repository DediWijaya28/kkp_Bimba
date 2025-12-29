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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('registration_number')->nullable()->after('status');
            $table->decimal('registration_fee', 10, 2)->nullable()->after('registration_number');
            $table->decimal('spp_fee', 10, 2)->nullable()->after('registration_fee');
            $table->string('authorized_signer')->default('Rosdiana')->nullable()->after('spp_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['registration_number', 'registration_fee', 'spp_fee', 'authorized_signer']);
        });
    }
};
