<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services\ProfessionalService;
use Illuminate\Http\JsonResponse;

class ProfessionalController extends Controller
{
    protected $professionalService;

    public function __construct(ProfessionalService $professionalService)
    {
        $this->professionalService = $professionalService;
    }

    /**
     * @OA\Get(
     ** path="/api/professional",
     *   tags={"Professional"},
     *   summary="Professional List",
     *   operationId="professional",
     *
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
     *   @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *   )
     *)
     **/
    public function getAllProfessionals(): JsonResponse
    {
        return $this->professionalService->getProfessionalList();
    }
}
