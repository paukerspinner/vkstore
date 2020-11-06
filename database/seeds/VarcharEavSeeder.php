<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VarcharEavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('varchar_eavs')->insert([
            'entity_id' => 1,
            'attribute_id' => 1,
            'value' => 'Nâu'
        ]);

        DB::table('varchar_eavs')->insert([
            'entity_id' => 2,
            'attribute_id' => 1,
            'value' => 'Đen'
        ]);

        DB::table('varchar_eavs')->insert([
            'entity_id' => 3,
            'attribute_id' => 1,
            'value' => 'Hồng'
        ]);

        DB::table('varchar_eavs')->insert([
            'entity_id' => 4,
            'attribute_id' => 1,
            'value' => 'Đen'
        ]);

        DB::table('varchar_eavs')->insert([
            'entity_id' => 5,
            'attribute_id' => 1,
            'value' => 'Đen'
        ]);
    }
}
