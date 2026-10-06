<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
            $table->string('relationship')->default('PARENT');
            $table->boolean('is_primary')->default(false);
            $table->boolean('can_pickup')->default(false);
            $table->boolean('receives_notifications')->default(true);
            $table->timestamps();

            $table->unique(['student_id', 'guardian_id']);
            $table->index(['student_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_guardians');
    }
};
