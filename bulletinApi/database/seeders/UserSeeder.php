<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'type' => '0',
            'password' => Hash::make('password'),
            'phone' => '09756013203',
            'dob' => '2022-02-21',
            'address' => 'grgigrpihaeipee',
            'profile' => 'https://127.0.0.1:8000/storage/1/image/jvY9FPe1rR6iV0x0JgtC0bWvXGdZxnB5YMSEd1dd.jpg',
            'created_user_id' => '1',
            'updated_user_id' => '1',
            'created_at' => '2022-10-21 12:11:00',
            'updated_at' => '2022-10-21 12:11:00',
        ]);
    }
}
