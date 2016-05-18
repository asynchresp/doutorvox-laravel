<?php

use App\Andamento;
use Illuminate\Database\Seeder;

class AndamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Andamento::truncate();

        factory(Andamento::class,10)->create();
    }
}
