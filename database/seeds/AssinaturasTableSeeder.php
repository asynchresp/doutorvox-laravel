<?php

use App\Assinatura;
use Illuminate\Database\Seeder;

class AssinaturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assinatura::truncate();

        factory(Assinatura::class,10)->create();
    }
}
