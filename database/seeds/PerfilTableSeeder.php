<?php

use App\Perfil;
use Illuminate\Database\Seeder;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfil::truncate();

        factory(Perfil::class,10)->create();
    }
}
