<?php

use Illuminate\Database\Seeder;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون پرورش اندام و وزنه برداری';
        $federation->type = 'specialized';
        $federation->save();

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون دوو میدانی';
        $federation->type = 'public';
        $federation->save();

        $federation = new \App\Model\Federation();
        $federation->name = 'فدراسیون ژیمناستیک';
        $federation->type = 'specialized';
        $federation->save();

    }
}
