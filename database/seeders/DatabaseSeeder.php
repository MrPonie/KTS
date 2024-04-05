<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        if(\App\Models\Role::where('name', 'administrator')->count() <= 0){
            \App\Models\Role::factory()->create([
                'name' => 'administrator',
                'description' => 'Administrator role.',
                'permissions_json' => json_encode((object)[
                    'view_permissions' => true,
                    'edit_permissions' => true,
                    'view_users' => true, 
                    'edit_users' => true,
                    'view_questions' => true, 
                    'edit_questions' => true,
                    'view_test_forms' => true, 
                    'edit_test_forms' => true,
                    'view_tests' => true, 
                    'edit_tests' => true,
                    'view_responses' => true, 
                    'edit_responses' => false,
                    'has_question_bank' => false,
                    'has_test_form_vault' => false,
                    'has_tests_list' => false,
                    'can_receive_tests' => false,
                ]),
            ]);
        }
        if(\App\Models\Role::where('name', 'teacher')->count() <= 0){
            \App\Models\Role::factory()->create([
                'name' => 'teacher',
                'description' => 'Teacher role.',
                'permissions_json' => json_encode((object)[
                    'view_permissions' => false,
                    'edit_permissions' => false,
                    'view_users' => false, 
                    'edit_users' => false,
                    'view_questions' => false, 
                    'edit_questions' => false,
                    'view_test_forms' => false, 
                    'edit_test_forms' => false,
                    'view_tests' => false, 
                    'edit_tests' => false,
                    'view_responses' => false,
                    'edit_responses' => false,
                    'has_question_bank' => true,
                    'has_test_form_vault' => true,
                    'has_tests_list' => true,
                    'can_receive_tests' => false,
                ]),
            ]);
        }
        if(\App\Models\Role::where('name', 'student')->count() <= 0) {
            \App\Models\Role::factory()->create([
                'name' => 'student',
                'description' => 'Student role.',
                'permissions_json' => json_encode((object)[
                    'view_permissions' => false,
                    'edit_permissions' => false,
                    'view_users' => false,
                    'edit_users' => false,
                    'view_questions' => false, 
                    'edit_questions' => false,
                    'view_test_forms' => false, 
                    'edit_test_forms' => false,
                    'view_tests' => false, 
                    'edit_tests' => false,
                    'view_responses' => false, 
                    'edit_responses' => false,
                    'has_question_bank' => false,
                    'has_test_form_vault' => false,
                    'has_tests_list' => false,
                    'can_receive_tests' => true,
                ]),
            ]);
        }

        \App\Models\User::factory()->create(['username' => 'admin', 'role_id' => 1, 'is_active' => true]);
        \App\Models\User::factory()->create(['username' => 'teacher', 'role_id' => 2, 'is_active' => true]);
        \App\Models\User::factory()->create(['role_id' => 2, 'is_active' => true]);
        \App\Models\User::factory()->create(['role_id' => 3, 'is_active' => true]);
    }
}
