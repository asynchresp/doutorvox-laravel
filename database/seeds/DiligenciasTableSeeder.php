<?php

use App\Diligencia;
use Illuminate\Database\Seeder;

class DiligenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diligencia::truncate();

        factory(Diligencia::class,3)->create();
    }
}
