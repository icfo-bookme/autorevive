<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      for($i=0;$i<=15;$i++){
        $product = new App\Product([
          'imagePath'   =>'/img/product/p1.png',
          'title'       => 'Cheese Garlic Toast Pizza',
          'categoryId'  => 1,
          'brandId'  => 1,
          'description' => 'This is a great food to have it as snacks',
          'price'       => 500.00

        ]);
        $product->save();
      }
    }
}
