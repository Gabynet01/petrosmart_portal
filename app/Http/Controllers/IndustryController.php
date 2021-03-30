<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartIndustries;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.settings.industries.dashboard');
    }

    // get all data in industries 
    public function getIndustriesUsersDataApi(Request $request)
    {
        $model = PetrosmartIndustries::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // add industries
    public function addPetrosmartIndustryApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartIndustries::where("industry_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartIndustries::where("industry_id", $request->get('user_id'))->first();
            $message = "Successfully edited industry";
        } else {
            $creatorForm = new PetrosmartIndustries();
            $message = "Industry was created successfully";
        }

        $creatorForm->industry_id =  $request->get('user_id');
        $creatorForm->industry_name =  $request->get('addIndustryName');
        $creatorForm->created_by =  $session_email;

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = $message;
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }
}
