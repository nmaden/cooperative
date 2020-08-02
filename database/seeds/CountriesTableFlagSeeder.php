<?php


use Illuminate\Database\Seeder;

class CountriesTableFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api = file_get_contents('https://restcountries.eu/rest/v2/all');
        $items = json_decode($api);
        foreach ($items as $item) {
            \App\Models\Country::where('country_code',$item->alpha2Code)->update(['flag' => $item->flag]);
        }
    }
}
