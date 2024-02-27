<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            array('code' => 'ABR', 'name' => 'Abra'),
            array('code' => 'ALB', 'name' => 'Albay'),
            array('code' => 'ANT', 'name' => 'Antique'),
            array('code' => 'APY', 'name' => 'Apayao'),
            array('code' => 'AUR', 'name' => 'Aurora'),
            array('code' => 'BEN', 'name' => 'Benguet'),
            array('code' => 'BUL', 'name' => 'Bulacan'),
            array('code' => 'CAG', 'name' => 'Cagayan'),
            array('code' => 'CAM', 'name' => 'Camarines Norte'),
            array('code' => 'CAS', 'name' => 'Camarines Sur'),
            array('code' => 'CAT', 'name' => 'Catanduanes'),
            array('code' => 'CAV', 'name' => 'Cavite'),
            array('code' => 'CEB', 'name' => 'Cebu'),
            array('code' => 'COM', 'name' => 'Compostela Valley'),
            array('code' => 'DAV', 'name' => 'Davao del Norte'),
            array('code' => 'DAS', 'name' => 'Davao del Sur'),
            array('code' => 'DAO', 'name' => 'Davao Oriental'),
            array('code' => 'GUI', 'name' => 'Guimaras'),
            array('code' => 'IFU', 'name' => 'Ifugao'),
            array('code' => 'ILN', 'name' => 'Ilocos Norte'),
            array('code' => 'ILS', 'name' => 'Ilocos Sur'),
            array('code' => 'ILY', 'name' => 'Iloilo'),
            array('code' => 'ISA', 'name' => 'Isabela'),
            array('code' => 'KAL', 'name' => 'Kalinga'),
            array('code' => 'LAG', 'name' => 'Laguna'),
            array('code' => 'LAN', 'name' => 'Lanao del Norte'),
            array('code' => 'LAS', 'name' => 'Lanao del Sur'),
            array('code' => 'LEY', 'name' => 'Leyte'),
            array('code' => 'LUN', 'name' => 'La Union'),
            array('code' => 'MAS', 'name' => 'Masbate'),
            array('code' => 'MDC', 'name' => 'Mindoro Occidental'),
            array('code' => 'MDR', 'name' => 'Mindoro Oriental'),
            array('code' => 'MOS', 'name' => 'Mountain Province'),
            array('code' => 'NCR', 'name' => 'National Capital Region (NCR)'),
            array('code' => 'NEC', 'name' => 'Negros Occidental'),
            array('code' => 'NER', 'name' => 'Negros Oriental'),
            array('code' => 'NSA', 'name' => 'Northern Samar'),
            array('code' => 'NUE', 'name' => 'Nueva Ecija'),
            array('code' => 'NUV', 'name' => 'Nueva Vizcaya'),
            array('code' => 'PAM', 'name' => 'Pampanga'),
            array('code' => 'PAN', 'name' => 'Pangasinan'),
            array('code' => 'QUE', 'name' => 'Quezon'),
            array('code' => 'QUI', 'name' => 'Quirino'),
            array('code' => 'RIZ', 'name' => 'Rizal'),
            array('code' => 'ROM', 'name' => 'Romblon'),
            array('code' => 'SAR', 'name' => 'Sarangani'),
            array('code' => 'SCO', 'name' => 'Siquijor'),
            array('code' => 'SLE', 'name' => 'Sorsogon'),
            array('code' => 'SUK', 'name' => 'South Cotabato'),
            array('code' => 'SLE', 'name' => 'Southern Leyte'),
            array('code' => 'SUL', 'name' => 'Sulu'),
            array('code' => 'SUN', 'name' => 'Surigao del Norte'),
            array('code' => 'SUR', 'name' => 'Surigao del Sur'),
            array('code' => 'TAR', 'name' => 'Tarlac'),
            array('code' => 'TAW', 'name' => 'Tawi-Tawi'),
            array('code' => 'ZAN', 'name' => 'Zamboanga del Norte'),
            array('code' => 'ZAS', 'name' => 'Zamboanga del Sur'),
            array('code' => 'ZMB', 'name' => 'Zambales'),
            array('code' => 'ZSI', 'name' => 'Zamboanga Sibugay')
        );
        
        // Inserting the provinces into the provinces table
        DB::table('provinces')->insert($provinces);
    }
}
