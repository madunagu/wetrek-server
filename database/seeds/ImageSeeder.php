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
        Image::create(
            [
                'large'=>'https://picsum.photos/500',
                'medium'=>'https://picsum.photos/200',
                'small'=>'https://picsum.photos/100',
                'full'=>'https://picsum.photos/200',
                'user_id' => 1,
                'imageable_type' => 'user',
                'imageable_id' => 1,
            ]
        );
    }
}
