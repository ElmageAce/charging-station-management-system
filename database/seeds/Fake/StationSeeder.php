<?php

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 100 stations
        factory(Station::class, 100)->state('with-company')->create();
    }
}
