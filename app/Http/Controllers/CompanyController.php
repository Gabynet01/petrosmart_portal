<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartCountries;
use App\PetrosmartCustomers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.companies.dashboard');
    }

    // add customer
    public function addPetrosmartCustomerApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartCustomers::where("cust_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartCustomers::where("cust_id", $request->get('user_id'))->first();
            $message = "Successfully edited customer";
        } else {
            $creatorForm = new PetrosmartCustomers();
            $message = "Customer was created successfully";
        }

        $creatorForm->cust_id =  $request->get('user_id');
        $creatorForm->address =  $request->get('address');
        $creatorForm->industry =  $request->get('industry');
        $creatorForm->full_name =  $request->get('full_name');
        $creatorForm->gps =  $request->get('gps');
        $creatorForm->country =  $request->get('country');
        $creatorForm->assigned_managers =  $request->get('assignedManagers');
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

    // get all data in users 
    public function getAdminUsersDataApi(Request $request)
    {
        $model = PetrosmartCustomers::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->where('assigned_managers', 'like', '%'.Session::get('email').'%')  
                        // ->where('assigned_managers', Session::get('email'))                     
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->where('assigned_managers', 'like', '%'.Session::get('managerEmail').'%')
                        // ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
