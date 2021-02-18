<?php


use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker; 


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker ;
        foreach (range(0, 100) as $number) {
            Category::create([
                'name' => Str::random(5),
                'parent_id' =>  rand(1 , count(Category::all())),
                'description' => Str::random(50),
            ]);
        }
    }
}
