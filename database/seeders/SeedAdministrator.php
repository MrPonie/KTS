<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SeedAdministrator extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administrators')->insert([
            'username' => 'administrator',
            'email' => 'administrator@'.env('APP_NAME').'.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);
        //temp
        DB::table('teachers')->insert([
            'username' => 'teacher',
            'email' => 'teacher@'.env('APP_NAME').'.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);
        DB::table('students')->insert([
            'username' => 'student',
            'email' => 'student@'.env('APP_NAME').'.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);
    }
}
