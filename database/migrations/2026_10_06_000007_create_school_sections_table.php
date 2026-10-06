<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedInteger('display_order')->default(0);
            $table->string('status')->default('ACTIVE');
            $table->timestamps();
            $table->index(['school_id', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_sections');
    }
};
