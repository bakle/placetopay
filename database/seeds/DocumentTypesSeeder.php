<?php

use Illuminate\Database\Seeder;

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentTypes = [
            'CC' => 'Cédula de ciudanía colombiana',
            'CE' => 'Cédula de extranjería',
            'TI' => 'Tarjeta de identidad',
            'PPN' => 'Pasaporte',
            'NIT' => 'Número de identificación tributaria',
            'SSN' => 'Social Security Number',
        ];

        foreach ($documentTypes as $key => $value) {
            DB::table('document_types')->insert([
                'name' => $key,
                'description' => $value
            ]);
        }
        
    }
}
