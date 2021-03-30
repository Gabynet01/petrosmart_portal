<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartOMC;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class OmcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.omc.dashboard');
    }

    // add OMC
    public function addPetrosmartOmcApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartOMC::where("omc_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartOMC::where("omc_id", $request->get('user_id'))->first();
            $message = "Successfully edited omc";
        } else {
            $creatorForm = new PetrosmartOMC();
            $message = "OMC was created successfully";
        }

        $creatorForm->omc_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('addOmcName');
        $creatorForm->address =  $request->get('addOmcAddress');
        $creatorForm->country =  $request->get('addOmcCountry');
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
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in OMC 
    public function getOmcDataApi(Request $request)
    {
        $model = PetrosmartOMC::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
