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
        Schema::create('test_forms', function (Blueprint $table) {
            $table->id();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->integer('created_by_id')->unsigned()->nullable();
            $table->string('name');
            $table->json('form_json')->default('[]');
            $table->integer('question_count')->unsigned();
            $table->float('max_points', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_forms');
    }
};
