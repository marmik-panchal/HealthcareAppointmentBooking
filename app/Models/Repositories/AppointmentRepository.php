<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Appointment;
use App\Models\Repositories\Interface\AppointmentInterface;
use Illuminate\Support\Facades\DB;

/**
 * Our repository, containing commonly used queries
 */
class AppointmentRepository implements AppointmentInterface
{
    // Our Eloquent model
    protected $model;

    /**
     * Setting our class $model to the injected model
     *
     * @param Appointment $model
     */
    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the created data
     *
     * @param array $appointmentData
     * @return Model
     */
    public function bookAppointment(array $appointmentData): Model
    {
        return $this->model->create($appointmentData);
    }

    /**
     *
     * @param int $professionalId
     * @param string $startTime
     * @param string $endTime
     * @return bool
     */
    public function checkAvailability(int $professionalId, string $startTime, string $endTime): bool
    {
        return $this->model
            ->where('healthcare_professional_id', $professionalId)
            ->where('appointment_start_time', '>=', $startTime)
            ->where('appointment_start_time', '<=', $endTime)
            ->exists();
    }

    /**
     * Returns the getAppointmentByUserId object associated with the passed id
     *
     * @param int $userId
     * @return Collection
     */
    public function getAppointmentByUserId(int $userId): Collection
    {
        return $this->model->select('hc_appointment.id', 'hc_professional.name', 'hc_appointment.appointment_start_time',
            'hc_appointment.appointment_end_time',
            DB::raw('CASE
                WHEN hc_appointment.status = 1 THEN "Booked"
                WHEN hc_appointment.status = 2 THEN "Completed"
                ELSE "Cancelled"
            END AS status'))
        ->leftJoin('hc_professional', 'hc_professional.id', '=', 'hc_appointment.healthcare_professional_id')
        ->where('hc_appointment.user_id', $userId)
        ->get();
    }

    /**
     *
     * @param int $appointmentId
     * @param int $status
     * @return mixed
     */
    public function changeAppointmentStatus(int $appointmentId, int $status)
    {
        return $this->model
            ->where('id', $appointmentId)
            ->update(['status' => $status]);
    }

    /**
     * Returns the AppointmentById
     *
     * @param int $appointmentId
     * @return Model
     */
    public function getAppointmentByAppointmentId(int $appointmentId): Model
    {
        return $this->model
            ->where('hc_appointment.id', $appointmentId)
            ->first();
    }
}
