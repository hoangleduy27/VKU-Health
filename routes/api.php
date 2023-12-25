<?php

use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MedicalRecordController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);

Route::post('add-medical-record', [MedicalRecordController::class, 'addNewMedicalNotAuth']);

Route::get('user-by-rfid/{rfid}/', [UserController::class, 'get_user_by_rfid']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('show-all-users', [UserController::class, 'index']);
    
    Route::post('register', [UserController::class, 'register']);
    
    Route::post('details', [UserController::class, 'details']);
    
    Route::post('change-password', [UserController::class, 'change_password']);

    Route::delete('delete-user/{user_id}/', [UserController::class, 'delete_user']);

    Route::put('update-infomation', [UserController::class, 'update_self_info']);
    
    Route::patch('update-infomation', [UserController::class, 'update_self_info']);

    Route::put('update-infomation/{user_id}', [UserController::class, 'update_user_info']);

    Route::patch('update-infomation/{user_id}', [UserController::class, 'update_user_info']);

    Route::put('reset-password', [UserController::class, 'reset_password']);

    Route::put('update-rfid', [UserController::class, 'update_rfid']);

    Route::delete('medical-records/{id}/', [MedicalRecordController::class, 'delete_record']);

    Route::resource('medical_records', MedicalRecordController::class);

    Route::get('show-all-medical-records', [MedicalRecordController::class, 'get_all_medical_records']);

    Route::get('medical-records-by-uid/{uid}/', [MedicalRecordController::class, 'get_records_by_uid'])->middleware('cors');

    Route::resource('devices', DeviceController::class);
});
