<?php

use Illuminate\Database\Seeder;

class PersonTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $personTypes = [
            'Persona',
            'Empresa'
        ];

        foreach ($personTypes as $type) {
            DB::table('person_types')->insert([
                'name' => $type
            ]);
        }
    }
}
