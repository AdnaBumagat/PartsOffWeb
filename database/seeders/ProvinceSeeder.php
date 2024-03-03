<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = array(
            array('code' => 'ILO', 'name' => 'Ilocos'),
            array('code' => 'LAU', 'name' => 'La Union'),
            array('code' => 'PAN', 'name' => 'Pangasinan'),
            array('code' => 'MAS', 'name' => 'Masbate'),
            array('code' => 'ZMB', 'name' => 'Zambales'),
            array('code' => 'QZN', 'name' => 'Quezon'),
            array('code' => 'RIZ', 'name' => 'Rizal'),
            array('code' => 'NUV', 'name' => 'Nueva Vizcaya'),
            array('code' => 'NUE', 'name' => 'Nueva Ecija'),
            array('code' => 'ISA', 'name' => 'Isabela'),
            array('code' => 'QUI', 'name' => 'Quirino'),
            array('code' => 'CAV', 'name' => 'Cavite'),
            array('code' => 'LUN', 'name' => 'Laguna'),
            array('code' => 'BUL', 'name' => 'Bulacan'),
            array('code' => 'PAM', 'name' => 'Pampanga'),
            array('code' => 'ALB', 'name' => 'Albay'),
            array('code' => 'CAI', 'name' => 'Camarines'),
            array('code' => 'CAS', 'name' => 'Camarines Sur'),
            array('code' => 'QUE', 'name' => 'Quirino'),
            array('code' => 'KAL', 'name' => 'Kalinga'),
            array('code' => 'IFU', 'name' => 'Ifugao'),
            array('code' => 'ILN', 'name' => 'Ilocos Norte'),
            array('code' => 'ILS', 'name' => 'Ilocos Sur'),
            array('code' => 'MOS', 'name' => 'Mountain Province'),
            array('code' => 'ABR', 'name' => 'Abra'),
            array('code' => 'CAT', 'name' => 'Catanduanes')
            
        );

        // Inserting the provinces into the provinces table
        DB::table('provinces')->insert($provinces);
    }
}
