<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $list_devices = Devices::all();
        
        return response()->json([
            'success' => true,
            'devices' => $list_devices,
        ], response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $data = $request->all();
        $device = new Devices($data);
        $device->save();
        return response()->json([
            'success' => true,
            'devices' => $device,
        ], response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $device = Devices::findOrFail($id);
        return response()->json([
            'success' => true,
            'device' => $device,
        ], response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        //
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $device = Devices::findOrFail($id);
        $device->update($request->all());
        $device->save();
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $device = Devices::findOrFail($id);
        $device->update($request->all());
        $device->save();
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        //
        if(Auth::user()->role != 9999) {
            return response()->json([
                'success' => false
            ], response::HTTP_NOT_FOUND);
        }
        $device = Devices::findOrFail($id);
        $device->delete();
        return response()->json([
            'success' => true
        ], response::HTTP_OK);
    }
}
