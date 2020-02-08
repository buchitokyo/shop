<?php

use Illuminate\Database\Seeder;
use App\Model\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i ++) {
            $product = new Product();
            $product->name = $i .'番目の商品名';
            // ランダム
            $array = [500, 1000, 1500];
            $key = array_rand($array);
            $product->amount = $array[$key];
            // ランダム
            $array2 = [
                ['M'],
                ['M', 'L'],
                ['S', 'M', 'L']
            ];
            $key2 = array_rand($array2);
            $product->sizes = $array2[$key2];
            $product->save();
        }
    }
}
