<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Return all programs belonging to a department as JSON
     */
    public function getByDepartment(Department $department)
{
    return response()->json($department->programs);
}

}
