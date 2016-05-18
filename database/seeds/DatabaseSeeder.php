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

        /*$this->call(FeedsTableSeeder::class);
        $this->call(NoticiasTableSeeder::class);
        $this->call(PerfilTableSeeder::class);
        $this->call(EstadoTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(CidadesTableSeeder::class);
        $this->call(PedidosTableSeeder::class);
        $this->call(AndamentosTableSeeder::class);
        $this->call(PagamentosTableSeeder::class);
        $this->call(AssinaturasTableSeeder::class);
        $this->call(AvaliacoesTableSeeder::class);
        $menus = App\Menu::all();
        foreach($menus as $menu){
            $menu->menusFilhos()->save(factory(App\Menu::class)->make());
        }
        $estados = App\Estado::all();
        foreach($estados as $estado){
            $estado->usuarios()->save(factory(App\Usuario::class)->make());
        }
                factory(App\Diligencia::class, 5)->create()->each(function($foo) {
            $foo->pedidos()->save(factory(App\Pedido::class)->make());
        });
        */


        factory('App\Usuario')->create(
            [
                    'nome' => 'Mayckon',
                    'email' => 'mayckonxp@gmail.com',
                    'password' => '123456',
                    'idcidade' => 1,
                    'idestado' => 1,
                    'remember_token' => str_random(10),
            ]


    );

        //$this->call(CandidatosTableSeeder::class);


        // habilitar a verificação de violação ao deletar tabela com chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
