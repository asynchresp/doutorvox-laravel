<?php

use App\Feed;
use Illuminate\Database\Seeder;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feed::truncate();

        factory(Feed::class,10)->create();
    }
}
