<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // Set locale based on request parameter or header
        $locale = request()->header('Accept-Language', 'en'); // Default to 'en'
        App::setLocale($locale); // Dynamically set the locale
        Session::put('locale', $locale); // Optionally, store in session
    }
    public function index()
    {
        $employees = Employee::all();
        return EmployeeResource::collection($employees);
    }
    public function index_pag()
    {
        $employees = Employee::paginate(10);
        return EmployeeResource::collection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();


        $employee = Employee::create($validated);
        $message=__('messages.succ_created');


        return response()->json([
            'data' => new EmployeeResource($employee),
            'message' => $message
        ], 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return new EmployeeResource($employee);
    }


    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validated();


        $employee->update($validated);
        $message=__('messages.succ_updated');


        return response()->json([
            'data' => new EmployeeResource($employee),
            'message' => $message
        ], 201);
    }


    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        $message=__('messages.delete');
        return response()->json($message, 200);
    }
}
