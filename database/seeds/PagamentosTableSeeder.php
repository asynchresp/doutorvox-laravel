<?php

use App\Pagamento;
use Illuminate\Database\Seeder;

class PagamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pagamento::truncate();

        factory(Pagamento::class,10)->create();
    }
}
