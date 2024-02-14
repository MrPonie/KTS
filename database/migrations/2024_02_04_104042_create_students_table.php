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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('username')->unque();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('assigned_tests')->constrained('tests');
            $table->foreignId('responses')->constrained('responses');
            // $table->json('assigned_tests_json')->default('[]');
            // $table->json('responses_json')->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
