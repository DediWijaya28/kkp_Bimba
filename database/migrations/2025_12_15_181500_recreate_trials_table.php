<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop table if exists to ensure clean state
        Schema::dropIfExists('trials');

        Schema::create('trials', function (Blueprint $table) {
            $table->id();
            // Moved user_id directly here to simplify
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('child_name');
            $table->string('parent_name');
            $table->string('phone');
            $table->integer('child_age')->nullable();
            $table->string('status')->default('pending'); // pending, scheduled, completed, registered
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trials');
    }
};
