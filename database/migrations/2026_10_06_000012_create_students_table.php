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
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('admission_no')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('photo_path')->nullable();
            $table->text('address')->nullable();
            $table->date('admission_date');
            $table->string('status')->default('ADMITTED');
            $table->timestamps();

            $table->index(['school_id', 'status']);
            $table->index(['school_id', 'admission_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
