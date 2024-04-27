<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services\AppointmentService;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * @OA\Post(
     ** path="/api/bookAppointment",
     *   tags={"Appointment"},
     *   summary="Book Appointment",
     *   operationId="bookAppointment",
     *   security={
     *      {"passport": {}},
     *   },
     *  @OA\Parameter(
     *      name="professionalId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="startTime",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="endTime",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function bookAppointment(Request $request): JsonResponse
    {
        return $this->appointmentService->bookAppointment($request);
    }

    /**
     * @OA\Post(
     ** path="/api/appointment",
     *   tags={"Appointment"},
     *   summary="Appointment List",
     *   operationId="Appointment List",
     *   security={
     *      {"passport": {}},
     *   },
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function getAppointmentList(): JsonResponse
    {
        return $this->appointmentService->appointmentList();
    }


    /**
     * @OA\Post(
     ** path="/api/cancelAppointment",
     *   tags={"Appointment"},
     *   summary="Cancel Appointment",
     *   operationId="cancelAppointment",
     *   security={
     *      {"passport": {}},
     *   },
     *  @OA\Parameter(
     *      name="appointmentId",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integar"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function cancelAppointment(Request $request): JsonResponse
    {
        return $this->appointmentService->cancelAppointment($request);
    }
}
