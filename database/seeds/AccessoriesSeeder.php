<?php

use Illuminate\Database\Seeder;

class AccessoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'دمبل';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'دوچرخه';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'تردمیل';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'توپ';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'راکت تنیس';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'کفش ورزشی';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'دستکش بوکس';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();

        $accessory = new \App\Model\Accessory();
        $accessory->name = 'کفش رانینگ';
        $accessory->img = '/images/accessories.jpg';
        $accessory->save();



    }
}
