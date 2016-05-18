<?php

use App\Cidade;
use Illuminate\Database\Seeder;

class CidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cidade::truncate();

        factory(Cidade::class,10)->create();
    }
}
