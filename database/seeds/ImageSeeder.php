<?php

use Illuminate\Database\Seeder;
use App\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::truncate();
        Image::insert(
            [
                'large',
                'medium',
                'small',
                'full',
                'user_id' => 1,
                'imageable_type' => 'user',
                'imageable_id' => 1,
            ]
        );
    }
}
