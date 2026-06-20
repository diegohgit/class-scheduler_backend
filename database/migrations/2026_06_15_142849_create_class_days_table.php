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
        Schema::create('class_days', function (Blueprint $table) {
            $table->foreignId('student_class_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->unsignedTinyInteger('day_id');

            //This is to treat the combination of this two columns as PK .
            //This way it won't be possible to store duplicated rows.
            $table->primary(['student_class_id', 'day_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_days');
    }
};
