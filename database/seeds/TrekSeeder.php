<?php

use Illuminate\Database\Seeder;
use App\Trek;

class TrekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trek::truncate();
        factory(Trek::class, 10)->create();
    }
}
