<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::post('register', 'Auth\AuthController@register');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('professional', 'ProfessionalController@getAllProfessionals');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('bookAppointment', 'AppointmentController@bookAppointment');
        Route::get('appointment', 'AppointmentController@getAppointmentList');
        Route::post('cancelAppointment', 'AppointmentController@cancelAppointment');
    });
});


