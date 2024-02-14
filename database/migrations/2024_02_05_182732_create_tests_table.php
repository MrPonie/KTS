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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->integer('created_by_id')->unsigned()->nullable();
            $table->string('name');
            $table->foreignId('based_on_form')->constrained('test_forms');
            // $table->integer('based_on_form_id')->unsigned()->nullable();
            $table->json('test_content_json')->default('[]');
            $table->boolean('is_public');
            $table->foreignId('assigned_students')->constrained('students');
            // $table->json('assigned_students_json')->default('[]');
            // $table->integer('assigned_students_count')->unsigned();
            $table->boolean('is_active');
            $table->datetime('activated_at')->nullable();
            $table->datetime('deactivated_at')->nullable();
            $table->foreignId('responses')->constrained('responses');
            // $table->json('results_json')->default('[]');
            // $table->integer('results_count')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
