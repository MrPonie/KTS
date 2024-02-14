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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->foreignId('questions')->constrain('questions');
            $table->foreignId('test_forms')->constrain('test_forms');
            $table->foreignId('tests')->constrain('tests');
            // $table->json('questions_json')->default('[]');
            // $table->json('test_forms_json')->default('[]');
            // $table->json('tests_json')->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
