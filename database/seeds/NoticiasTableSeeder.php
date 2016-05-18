<?php

use App\Noticia;
use Illuminate\Database\Seeder;

class NoticiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Noticia::truncate();

        factory(Noticia::class,10)->create();
    }
}
