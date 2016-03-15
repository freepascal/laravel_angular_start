<?php

use Illuminate\Database\Seeder;
//http://stackoverflow.com/questions/31088292/laravel-php-artisan-dbseed-leads-to-use-statement-error
//use DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     // truncate the database
     // reset the index to zero 
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create();
        foreach(range(0, 100) as $index) {
            DB::table('members')->insert(array(
                'name'      => $faker->name,
                'address'   => $faker->address,
                'age'       => rand(1, 99)
            ));
        }

        DB::table('members')->truncate();
    }
}
