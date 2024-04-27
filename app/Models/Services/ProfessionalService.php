<?php

namespace App\Models\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Repositories\Interface\ProfessionalInterface;

/**
 * Our UserService, containing all useful methods for business logic around User
 */
class ProfessionalService
{
    private $professional;

    /**
     * Loads our $professional with the actual Repo associated with our ProfessionalInterface
     *
     * @param ProfessionalInterface $professional
     */
    public function __construct(ProfessionalInterface $professional) {
        $this->professional = $professional;
    }

    /**
     * Method to get all professionals
     *
     * @return JsonResponse
     */
    public function getProfessionalList(): JsonResponse
    {
        try {
            $list = $this->professional->getAll();
            return response()->json([
                'status' => 1,
                'data' => $list->isNotEmpty() ? $list->toArray() : [],
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

}
