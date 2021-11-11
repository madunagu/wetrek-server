<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();
        Setting::insert([
            [
                'user_id' => 1,
                'name' => 'show_location',
                'point' => 1
            ],
            [
                'user_id' => 1,
                'name' => 'show_age',
                'point' => 1
            ],
        ]);
        DB::table('settings_title')->truncate();
        DB::table('settings_title')->insert(
            [
                'name' => 'show_location',
                'display' => 'Show Location'
            ],
            [
                'name' => 'show_places',
                'display' => 'Show Favorite Places'
            ],
            [
                'name' => 'show_age',
                'display' => 'Show Age'
            ],
            [
                'name' => 'show_address',
                'display' => 'Show Address'
            ],
        );
    }
}
