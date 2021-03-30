<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartCountries;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.settings.countries.dashboard');
    }

    // add countries
    public function addPetrosmartCountryApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartCountries::where("ccountry_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartCountries::where("ccountry_id", $request->get('user_id'))->first();
            $message = "Successfully edited country";
        } else {
            $creatorForm = new PetrosmartCountries();
            $message = "Country was created successfully";
        }

        $creatorForm->ccountry_id =  $request->get('user_id');
        $creatorForm->country =  $request->get('addCountryName');
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

    // get all data in countries 
    public function getCountriesUsersDataApi(Request $request)
    {
        $model = PetrosmartCountries::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')

                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
