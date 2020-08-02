<?php

use Illuminate\Database\Seeder;

class DoctypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //    Изменить потом на VMP API
        $json = file_get_contents('http://eqonaq.api/doctype.json');
        $result = json_decode($json);
        foreach ($result->_embedded->doctypes as $item) {
            $find = \App\Models\Doctype::query()->where('vmp_id', '=', $item->id)->first();
            if ($find === null) {
                \App\Models\Doctype::create(array(
                    'vmp_id' => $item->id,
                    'code' => $item->code,
                    'vmpVisible' => $item->vmpVisible,
                    'name_kaz' => $item->nameKz,
                    'name_rus' => $item->nameRu,
                    'name_eng' => $item->nameEn,
                ));
            }
        }
    }
}
