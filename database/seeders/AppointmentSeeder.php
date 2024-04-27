<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entities\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create(
            [
                'user_id' => 1,
                'healthcare_professional_id' => 1,
                'appointment_start_time' => '2024-04-26 10:00:00',
                'appointment_end_time' => '2024-04-26 10:30:00',
                'status' => 1
            ],
        );
    }
}
