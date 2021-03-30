<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartContact;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.contacts.dashboard');
    }

    // get all data in contacts 
    public function getContactUsersDataApi(Request $request)
    {
        $model = PetrosmartContact::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // add contact
    public function addPetrosmartContactApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartContact::where("custc_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartContact::where("custc_id", $request->get('user_id'))->first();
            $message = "Successfully edited contact";
        } else {
            $creatorForm = new PetrosmartContact();
            $message = "Contact was created successfully";
        }

        $creatorForm->custc_id =  $request->get('user_id');
        $creatorForm->cust_id =  $request->get('addCustomerContact');
        $creatorForm->full_name =  $request->get('addCustomerContact');
        $creatorForm->email =  $request->get('addEmailContact');
        $creatorForm->tel =  $request->get('addTelephoneContact');
        $creatorForm->mob =  $request->get('addMobileContact');
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
