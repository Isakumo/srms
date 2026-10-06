<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grade_level_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code');
            $table->unsignedInteger('capacity')->nullable();
            $table->string('status')->default('ACTIVE');
            $table->timestamps();

            $table->unique(['school_id', 'grade_level_id', 'code']);
            $table->index(['school_id', 'grade_level_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_groups');
    }
};
