<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = array(
            array(
                'name' => 'GPU',
                'slug' => 'GPU',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Processor',
                'slug' => 'Processor',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'RAM Stick',
                'slug' => 'RAM Stick',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'PC Case',
                'slug' => 'PC Case',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Storage',
                'slug' => 'Storage',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Monitors',
                'slug' => 'Monitors',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Keyboards',
                'slug' => 'Keyboards',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Mouse',
                'slug' => 'Mouse',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            ),
            array(
                'name' => 'Cables',
                'slug' => 'Cables',
                'image' => null,
                'status' => '1',
                'showHome' => 'Yes'
            )
        );

    }
}
