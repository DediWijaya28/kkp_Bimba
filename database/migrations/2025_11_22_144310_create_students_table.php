<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('draft'); // draft, agreement_signed, submitted, needs_revision, verified, awaiting_payment, paid, active
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
