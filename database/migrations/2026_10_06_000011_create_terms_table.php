<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_session_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('sequence')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->string('status')->default('ACTIVE');
            $table->timestamps();

            $table->unique(['academic_session_id', 'sequence']);
            $table->index(['academic_session_id', 'is_current', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
