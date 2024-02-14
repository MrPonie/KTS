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
        Schema::create('test_responses', function (Blueprint $table) {
            $table->id();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->foreignId('from_test')->constrained('tests');
            // $table->integer('from_test_id')->unsigned();
            $table->boolean('is_anonymous');
            $table->foreignId('created_by')->constrained('students');
            // $table->integer('created_by_id')->unsigned();
            $table->json('answers_json')->default('[]');
            $table->integer('answer_count')->unsigned();
            $table->integer('correct_count')->unsigned();
            $table->integer('incorrect_count')->unsigned();
            $table->integer('neutral_count')->unsigned();
            $table->float('max_points', 8, 2)->unsigned();
            $table->float('points', 8, 2)->unsigned();
            $table->string('grade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_responses');
    }
};
