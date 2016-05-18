<?php

use App\Avaliacao;
use Illuminate\Database\Seeder;

class AvaliacoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Avaliacao::truncate();

        factory(Avaliacao::class,10)->create();
    }
}
