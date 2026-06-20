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
        Schema::table('student_classes', function (Blueprint $table){
            $table->dropUnique(['day_id', 'starts', 'ends']);

            $table->dropColumn('day_id');

            $table->unique(['student_id', 'starts', 'ends']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_classes', function (Blueprint $table){
            $table->dropUnique(['student_id', 'starts', 'ends']);

            $table->integer('day_id');

            $table->unique(['day_id', 'starts', 'ends']);
        });
    }
};
