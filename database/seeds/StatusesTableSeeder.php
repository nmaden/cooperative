<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Заезд',
            ],
            [
                'name' => 'Проживание',
            ],
            [
                'name' => 'Выезд',
            ],
        ];

        foreach ($datas as $data) {
            $newData = \App\Models\Status::where('name', '=', $data['name'])->first();
            if ($newData === null) {
                $newData = \App\Models\Status::create(array(
                    'name' => $data['name'],
                ));
            }
        }
    }
}
