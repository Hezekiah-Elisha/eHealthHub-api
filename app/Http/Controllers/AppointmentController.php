<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Interfaces\AppointmentRepositoryInterface;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    private AppointmentRepositoryInterface $appointmentRepositoryInterface;


    public function __construct(AppointmentRepositoryInterface $appointmentRepositoryInterface)
    {
        $this->appointmentRepositoryInterface = $appointmentRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $data = $this->appointmentRepositoryInterface->all();

       return ApiResponseClass::sendResponse($data, 'Appointments retrieved successfully.', 200);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \App\Http\Requests\StoreAppointmentRequest  $request
     */
    public function store(StoreAppointmentRequest $request)
    {
        $data = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ];

        DB::beginTransaction();
        try {
            $appointment = $this->appointmentRepositoryInterface->create($data);
            DB::commit();
            return ApiResponseClass::sendResponse(new AppointmentResource($appointment), 'Appointments created successfully.', 201);
        } catch (\Exception $e) {
            // DB::rollBack();
            return ApiResponseClass::rollback('Appointment creation failed.', 500);
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\Appointment  $appointment
     */
    public function show(Appointment $appointment)
    {
        $appointment = $this->appointmentRepositoryInterface->getById($appointment->id);
        return ApiResponseClass::sendResponse(new AppointmentResource($appointment), 'Appointment retrieved successfully.', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ];

        DB::beginTransaction();
        try {
            $appointment = $this->appointmentRepositoryInterface->update($data, $appointment->id);
            DB::commit();
            return ApiResponseClass::sendResponse(new AppointmentResource($appointment), 'Appointment updated successfully.', 200);
        } catch (\Exception $e) {
            return ApiResponseClass::rollback('Appointment update failed.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        DB::beginTransaction();
        try {
            $this->appointmentRepositoryInterface->delete($appointment->id);
            DB::commit();
            return ApiResponseClass::sendResponse([], 'Appointment deleted successfully.', 200);
        } catch (\Exception $e) {
            return ApiResponseClass::rollback('Appointment deletion failed.', 500);
        }
    }
}
