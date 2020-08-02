<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //    Изменить потом на VMP API
        $json = file_get_contents('http://eqonaq.api/country.json');
        $result = json_decode($json);
        foreach ($result->_embedded->countries as $item) {
            $find = \App\Models\Country::query()->where('vmp_id', '=', $item->id)->first();
            if ($find === null) {
                \App\Models\Country::create(array(
                    'vmp_id' => $item->id,
                    'code' => $item->code,
                    'vmpVisible' => $item->vmpVisible,
                    'name_kaz' => $item->nameKz,
                    'name_rus' => $item->nameRu,
                    'name_eng' => $item->nameEn,
                    'max_period_registration' => $item->maxPeriodRegistration,
                    'visa_required' => $item->visaRequired,
                    'allowed_days_without_registration' => $item->allowedDaysWithoutRegistration,
                    'country_code' => $item->countryCode,
                ));
            }
        }
    }
}
