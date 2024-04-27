<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entities\Professional;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Professional::create(
            [
                'name' => 'Dr. Chris Scrogham',
                'email' => 'Chris@gmail.com',
                'specialty' => 'Neurologist'
            ],
            [
                'name' => 'Dr. Marion Cloney',
                'email' => 'Marion@gmail.com',
                'specialty' => 'Pediatrician'
            ],
            [
                'name' => 'Dr. Marley Enderson',
                'email' => 'Marion@gmail.com',
                'specialty' => 'General Physician'
            ],
        );
    }
}
