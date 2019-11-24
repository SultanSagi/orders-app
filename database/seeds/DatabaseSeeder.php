<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory('App\User', 10)->create();
        factory('App\Product')->create(['name' => 'Fanta', 'price' => 140]);
        factory('App\Product')->create(['name' => 'Coca Cola', 'price' => 180]);
        factory('App\Product')->create(['name' => 'Pepsi Cola', 'price' => 160, 'discount' => 20]);
        factory('App\Product')->create(['name' => 'Sprite', 'price' => 120]);
        factory('App\Product')->create(['name' => 'Limonade', 'price' => 200]);
    }
}
