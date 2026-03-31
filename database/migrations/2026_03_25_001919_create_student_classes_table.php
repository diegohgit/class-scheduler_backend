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
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            //1 (MON) - 7 (DOM) there's no days table,
            //the days list are included in a data file in the react project.
            $table->unsignedTinyInteger('day_id');

            $table->time('starts');
            $table->time('ends');
            $table->timestamps();

            $table->unique(['day_id', 'starts', 'ends' ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_classes');
    }
};
