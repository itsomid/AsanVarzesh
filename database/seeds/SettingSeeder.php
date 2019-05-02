<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $setting = new \App\Model\Setting();
        $setting->title = 'coach_commission';
        $setting->display_name = 'کمیسیون مربی';
        $setting->value = 20;
        $setting->save();

        $setting = new \App\Model\Setting();
        $setting->title = 'tax_percentage';
        $setting->display_name = 'درصد مالیات';
        $setting->value = 18;
        $setting->save();

    }
}
