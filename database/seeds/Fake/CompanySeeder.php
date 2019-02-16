<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \Faker\Generator $faker */
        $faker = resolve(\Faker\Generator::class);

        // create 10 parent company
        factory(Company::class, 10)->create()->each(function (Company $company) use ($faker) {
            // create random number of sub-companies for each company (0 to 20)
            factory(Company::class, $faker->numberBetween(0, 20))->create(['parent_company_id' => $company->id]);
        });
    }
}
