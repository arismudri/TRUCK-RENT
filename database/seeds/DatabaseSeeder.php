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
        // $this->call(UserSeeder::class);
        $faker = Faker\Factory::create(); //import lib

        $limit = 10;


        for ($i=0; $i < $limit; $i++) {
            DB::table('items')->insert([
                'nama'      =>  $faker->city,
                'berat'     =>  $faker->randomNumber,
                'jumlah'    =>  $faker->randomNumber
            ]);
        }        
        for ($i=0; $i < $limit; $i++) {
            DB::table('trucks')->insert([
                'model'      =>  $faker->city,
                'plat_no'     =>  $faker->numerify('E ### DC')
            ]);
        }
    }
}
