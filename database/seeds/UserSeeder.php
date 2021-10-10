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
        User::truncate();
        User::insert([[
            'email' => 'ekenemadunagu@gmail.com',
            'password' => Hash::make('mercy'),
            'name' => 'Ekene Madunagu'
        ],
        [
            'email' => 'stanleysuccess2@gmail.com',
            'password' => Hash::make('stanley'),
            'name' => 'Stanley Ezeh'
        ],]);
        factory(User::class, 20)->create();
    }
}
