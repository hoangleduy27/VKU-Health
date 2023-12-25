<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MedicalRecordController extends Controller
{
    private const ADMIN_ROLE = 9999;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->role != self::ADMIN_ROLE) {
            $user_id = Auth::user()->id;
            $list_medical_records = MedicalRecord::with('user')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        } else {
            $list_medical_records = MedicalRecord::with('user')->orderBy('created_at', 'desc')->get();
        }
        return response()->json(['success' => true, 'records' => $list_medical_records], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $medical_record = new MedicalRecord;
        if (Auth::user()) {
            $medical_record->user_id = Auth::user()->id;
        } else {
            $medical_record->user_id = $request->user_id;
        }
        $medical_record->body_temperature = $request->body_temperature;
        $medical_record->co2 = $request->co2;
        $medical_record->heart_beat = $request->heart_beat;
        $medical_record->oxy = $request->oxy;
        $medical_record->image = $request->image;
        $medical_record->save();
        return response()->json(['success' => true, 'record' => $medical_record], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalRecord $medicalRecord)
    {
        //
        $medical_record = MedicalRecord::with('user')->findOrFail($medicalRecord->id);
        if ($medical_record->user_id == Auth::user()->id || Auth::user()->role == self::ADMIN_ROLE) {
            return response()->json(['success' => $medical_record]);
        }
        return response()->json(['success' => false], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        //
        if (Auth::user()->id == $medicalRecord->user_id || Auth::user()->role == self::ADMIN_ROLE) {
            $medicalRecord->body_temperature = $request->body_temperature;
            $medicalRecord->co2 = $request->co2;
            $medicalRecord->heart_beat = $request->heart_beat;
            $medicalRecord->blood_pressure = $request->blood_pressure;
            $medicalRecord->save();
            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        //
        if ($medicalRecord) {
            if (Auth::user()->id == $medicalRecord->user_id || Auth::user()->role == self::ADMIN_ROLE) {
                MedicalRecord::destroy($medicalRecord->id);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success', false], 404);
            }
        } else {
            return response()->json(['success', false], 404);
        }
    }

    public function get_all_medical_records()
    {
        if (Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }

        $list_records = MedicalRecord::with('user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'records' => $list_records,
        ], response::HTTP_OK);
    }

    public function addNewMedicalNotAuth(Request $request)
    {
        $medical_record = new MedicalRecord;
        $user = User::where('rfid', $request->rfid)->first();

        if ($user != null) {
            $medical_record->user_id = $user->id;
            $medical_record->body_temperature = $request->body_temperature;
            $medical_record->co2 = $request->co2;
            $medical_record->heart_beat = $request->heart_beat;
            $medical_record->oxy = $request->oxy;
            $medical_record->image = $request->image;
            $medical_record->save();
            return response()->json(['success' => "true"], response::HTTP_OK);
        }

        return response()->json([
            'success' => "false"
        ], response::HTTP_OK);
    }

    public function delete_record(int $id)
    {
        if (Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], $this->successStatus);
        }
        $record = MedicalRecord::findOrFail($id);
        $record->delete();
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }

    public function get_records_by_uid(string $uid)
    {
        if (Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], $this->successStatus);
        }

        $records = MedicalRecord::where('user_id', $uid)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' =>  $records
        ], response::HTTP_OK);
    }
}
