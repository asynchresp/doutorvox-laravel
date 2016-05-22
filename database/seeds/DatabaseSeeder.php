<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(FeedsTableSeeder::class);
        $this->call(NoticiasTableSeeder::class);
        $this->call(DiligenciasTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(CidadesTableSeeder::class);
        $this->call(AndamentosTableSeeder::class);
        $this->call(PagamentosTableSeeder::class);
        $this->call(AssinaturasTableSeeder::class);
        $this->call(AvaliacoesTableSeeder::class);
        $menus = App\Menu::all();
        foreach ($menus as $menu) {
            $menu->menusFilhos()->save(factory(App\Menu::class)->make());
        }
       $this->call(CandidatosTableSeeder::class);




        // habilitar a verificação de violação ao deletar tabela com chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
