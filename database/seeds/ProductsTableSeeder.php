<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class)->times(10)->states('gear')->create(['photo_url' => 'https://vignette.wikia.nocookie.net/heroesofthestorm/images/6/65/Gul%27dan.jpg/revision/latest?cb=20150502084657']);
    }
}
