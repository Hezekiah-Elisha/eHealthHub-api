<?php

namespace App\Repositories;

use App\Interfaces\AppointmentRepositoryInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function all()
    {
        // pagnate
        return Appointment::paginate(10);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(array $data, $id)
    {
        return Appointment::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }

    public function getById($id)
    {
        return Appointment::find($id);
    }
}
