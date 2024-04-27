<?php

namespace App\Models\Repositories\Interface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * A simple interface to set the methods in our User repository, nothing much happening here
 */
interface AppointmentInterface
{
    public function bookAppointment(array $appointmentData): Model;

    public function checkAvailability(int $professionalId, string $startTime, string $endTime): bool;

    public function getAppointmentByUserId(int $userId): Collection;

    public function changeAppointmentStatus(int $appointmentId, int $status);

    public function getAppointmentByAppointmentId(int $appointmentId): Model;
}
