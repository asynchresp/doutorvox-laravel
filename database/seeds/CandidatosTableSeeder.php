<?php

use App\Candidato;
use Illuminate\Database\Seeder;

class CandidatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidato::truncate();

        factory(Candidato::class,10)->create();
    }
}
