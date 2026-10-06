<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('school_sections')->cascadeOnDelete();
            $table->string('name');
            $table->string('code');
            $table->unsignedInteger('sequence')->default(0);
            $table->string('status')->default('ACTIVE');
            $table->timestamps();

            $table->unique(['school_id', 'section_id', 'code']);
            $table->index(['school_id', 'section_id', 'sequence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_levels');
    }
};
