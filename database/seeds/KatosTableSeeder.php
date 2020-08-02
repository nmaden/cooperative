<?php

use Illuminate\Database\Seeder;

class KatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        egov отдаёт 10к даже если запросить больше.
        $kato_egov_list_1 = file_get_contents('https://data.egov.kz/api/v4/kato/data?apiKey=16bc1540ff1d4aa7b95afd49555a1183&source={%22from%22:0,%20%22size%22:%2029000}');
        $kato_egov_list_2 = file_get_contents('https://data.egov.kz/api/v4/kato/data?apiKey=16bc1540ff1d4aa7b95afd49555a1183&source={%22from%22:10000,%20%22size%22:%2029000}');
        $obj = json_decode($kato_egov_list_1);
        $obj2 = json_decode($kato_egov_list_2);
        $json = array();
        foreach ($obj as $item) {
//        if ($item->IsMarkedToDelete === false) {
            $json[] = $item;
//        }
        }
        foreach ($obj2 as $item) {
//        if ($item->IsMarkedToDelete === false) {
            $json[] = $item;
//        }
        }
        foreach ($json as $item) {
            $find = \App\Models\Kato::query()->where('egov_id', $item->Id)->first();
            if ($find === null) {
                if ($item->Parent == '') {
                    \App\Models\Kato::create(
                        array(
                            'egov_id' => $item->Id,
                            'egov_parent_id' => null,
                            'level' => $item->Level,
                            'area_type' => $item->AreaType,
                            'name_kaz' => $item->NameKaz,
                            'name_rus' => $item->NameRus,
                            'code' => $item->Code,
                            'is_marked_to_delete' => $item->IsMarkedToDelete,
                        )
                    );
                }
                else {
                    \App\Models\Kato::create(
                        array(
                            'egov_id' => $item->Id,
                            'egov_parent_id' => $item->Parent,
                            'level' => $item->Level,
                            'area_type' => $item->AreaType,
                            'name_kaz' => $item->NameKaz,
                            'name_rus' => $item->NameRus,
                            'code' => $item->Code,
                            'is_marked_to_delete' => $item->IsMarkedToDelete,
                        )
                    );
                }

            }
        }
//        Выставление parent_id
        $parent = \App\Models\Kato::query()->whereNotNull('egov_parent_id')->get();
            foreach ($parent as $item) {
               $first =  \App\Models\Kato::query()->where('egov_id',$item->egov_parent_id)->first();
                $item->parent_id = $first->id;
                $item->save();
            }
    }
}
