<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDevicesRequest;
use App\Http\Requests\UpdateDevicesRequest;
use App\Models\Devices;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list_devices = Devices::all();
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
     * @param  \App\Http\Requests\StoreDevicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDevicesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function show(Devices $devices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function edit(Devices $devices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDevicesRequest  $request
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDevicesRequest $request, Devices $devices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devices  $devices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Devices $devices)
    {
        //
    }
}
