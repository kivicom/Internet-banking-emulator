<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            'code' => '980',
            'currency' => 'UAH',
            'name' => 'Украинская гривна',
        ]);

        DB::table('currency')->insert([
            'code' => '840',
            'currency' => 'USD',
            'name' => 'Доллар США',
        ]);

        DB::table('currency')->insert([
            'code' => '978',
            'currency' => 'EUR',
            'name' => 'Евро',
        ]);
    }
}
