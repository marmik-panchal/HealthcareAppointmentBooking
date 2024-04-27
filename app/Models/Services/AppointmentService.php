<?php

namespace App\Models\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Repositories\Interface\AppointmentInterface;

/**
 * Our UserService, containing all useful methods for business logic around User
 */
class AppointmentService
{
    private $professional;

    /**
     * Loads our $appointment with the actual Repo associated with our AppointmentInterface
     *
     * @param AppointmentInterface $appointment
     */
    public function __construct(AppointmentInterface $appointment) {
        $this->appointment = $appointment;
    }

    /**
     * Method to get all professionals
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bookAppointment(Request $request): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'professionalId' => 'required|integer|exists:hc_professional,id',
                'startTime' => 'required|date|date_format:Y-m-d H:i:s|after:' . Carbon::now()->format('Y-m-d H:i:s'),
                'endTime' => 'required|string|after_or_equal:startTime|date_format:Y-m-d H:i:s',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.validationError'),
                    'error' => $validator->errors()->all(),
                ]);
            }

            // Check availability
            $checkAvailability = $this->appointment->checkAvailability($request->get('professionalId'), $request->get('startTime'), $request->get('endTime'));
            if($checkAvailability) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.appointment.noAvailability'),
                ]);
            }

            $appointmentData['user_id'] = Auth::user()->id;
            $appointmentData['healthcare_professional_id'] = $request->get('professionalId');
            $appointmentData['appointment_start_time'] = $request->get('startTime');
            $appointmentData['appointment_end_time'] = $request->get('endTime');
            $appointmentData['status'] = config('constant.appointmentStatus.booked');

            $appointment = $this->appointment->bookAppointment($appointmentData);

            return response()->json([
                'status' => 1,
                'data' => ['appointmentId' => $appointment->id],
                'message' => config('constant.response.appointment.success'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => config('constant.response.exception'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Method to get all appointments
     *
     * @return JsonResponse
     */
    public function appointmentList(): JsonResponse
    {
        try{
            $appointments = $this->appointment->getAppointmentByUserId(Auth::user()->id);
            $currentDate = date('Y-m-d H:i:s');
            if ($appointments->isNotEmpty()) {
                foreach ($appointments as $item) {
                    if ($currentDate > $item->appointment_end_time) {
                       // Change the appointment status to complete
                        $this->appointment->changeAppointmentStatus($item->id, config('constant.appointmentStatus.completed'));
                    }
                }
            }
            return response()->json([
                'status' => 1,
                'data' => [$appointments->isNotEmpty() ? $appointments->toArray() : []],
                'message' => config('constant.response.success'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => config('constant.response.exception'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Method to cancel appointment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cancelAppointment(Request $request): JsonResponse
    {
        try{
            $validator = Validator::make($request->all(), [
                'appointmentId' => 'required|integer|exists:hc_appointment,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.validationError'),
                    'error' => $validator->errors()->all(),
                ]);
            }
            $currentDate = Carbon::now();
            $getAppointmentDetails = $this->appointment->getAppointmentByAppointmentId($request->get('appointmentId'));
            if(!empty($getAppointmentDetails) && Auth::user()->id !== $getAppointmentDetails->user_id) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.appointment.cancelFailed'),
                ]);
            } else if(!empty($getAppointmentDetails) && $getAppointmentDetails->status === config('constant.appointmentStatus.completed')) {

                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.appointment.alreadyCompleted'),
                ]);
            } else if(!empty($getAppointmentDetails) && $currentDate->diffInDays(Carbon::parse($getAppointmentDetails->appointment_start_time)) < 1) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.appointment.noCancel'),
                ]);
            }

            $this->appointment->changeAppointmentStatus($getAppointmentDetails->id, config('constant.appointmentStatus.cancelled'));

            return response()->json([
                'status' => 1,
                'message' => config('constant.response.appointment.cancelSuccess'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => config('constant.response.exception'),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
