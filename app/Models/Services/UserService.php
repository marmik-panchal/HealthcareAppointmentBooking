<?php

namespace App\Models\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Repositories\Interface\UserInterface;

/**
 * Our UserService, containing all useful methods for business logic around User
 */
class UserService
{
    private $user;

    /**
     * Loads our $user with the actual Repo associated with our userInterface
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user) {
        $this->user = $user;
    }

    /**
     * Method to register user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hc_users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status' => 0,
                'message' => config('constant.response.validationError'),
                'error' => $validator->errors()->all(),
            ]);
        }

        $userData = $request->all();
        $userData['password'] = bcrypt($userData['password']);
        $this->user->createUser($userData);

        return response()->json([
            'status' => 1,
            'message' => config('constant.response.registration.success'),
        ]);
    }

    /**
     * Method to Login user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginUser(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'message' => config('constant.response.validationError'),
                    'error' => $validator->errors()->all(),
                ]);
            }

            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();
                $token =  $user->createToken('HealthcareAppointmentBooking')->accessToken;
                return response()->json([
                    'status' => 1,
                    'token' => $token,
                    'message' => config('constant.response.login.success'),
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => config('constant.response.login.failed'),
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
