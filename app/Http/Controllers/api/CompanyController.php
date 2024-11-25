<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyCreated;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
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
        $companies = Company::all();
        return CompanyResource::collection($companies);
    }
    public function index_pag()
    {
        $companies = Company::paginate(10);
        return CompanyResource::collection($companies);
    }
    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $company = Company::create($validated);

        Mail::to('recipient@example.com')->send(new CompanyCreated($company));

        $message=__('messages.succ_created');


        return response()->json([
            'data' => new CompanyResource($company),
            'message' => $message
        ], 201);


    }

    public function show($id)
    {
        $company = Company::findOrFail($id);

        return new CompanyResource($company);
    }
    public function update(CompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validated();


        if ($request->hasFile('logo')) {
            if ($company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $company->update($validated);
        $message=__('messages.succ_updated');


        return response()->json([
            'data' => new CompanyResource($company),
            'message' => $message
        ], 201);
    }
    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        $message=__('messages.delete');
        return response()->json($message, 200);
    }


}

