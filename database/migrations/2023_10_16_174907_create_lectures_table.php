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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade')->onUpdate('cascade'); // Foreign key for course
            $table->foreignId('classroom_id')->constrained('class_rooms')->onDelete('cascade')->onUpdate('cascade'); // Foreign key for classroom
            $table->foreignId('tutor_id')->constrained('tutors')->onDelete('cascade')->onUpdate('cascade'); // Foreign key for tutor
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
