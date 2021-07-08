<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'email' => 'ekenemadunagu@gmail.com',
            'password' => Hash::make('mercy'),
            'name' => 'Ekene Madunagu'
        ]);
        factory(User::class, 20)->create();
    }
}
