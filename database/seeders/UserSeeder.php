<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'teacher1',
            'password' => Hash::make('123456a@A'),
            'fullname' => 'Teacher Number One'
        ]);

        DB::table('users')->insert([
            'username' => 'teacher2',
            'password' => Hash::make('123456a@A'),
            'fullname' => 'Teacher Number Two'
        ]);

        DB::table('users')->insert([
            'username' => 'student1',
            'password' => Hash::make('123456a@A'),
            'fullname' => 'Student Number One'
        ]);

        DB::table('users')->insert([
            'username' => 'student2',
            'password' => Hash::make('123456a@A'),
            'fullname' => 'Student Number Two',
        ]);
    }
}
