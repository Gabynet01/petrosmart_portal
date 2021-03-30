<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartWallet;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyWalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.wallets.dashboard');
    }

    // get all data in wallets 
    public function getWalletUsersDataApi(Request $request)
    {
        $model = PetrosmartWallet::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')

                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // add wallet
    public function addPetrosmartWalletApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartWallet::where("custw_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartWallet::where("custw_id", $request->get('user_id'))->first();
            $message = "Successfully edited wallet";
        } else {
            $creatorForm = new PetrosmartWallet();
            $message = "Wallet was created successfully";
        }

        $creatorForm->custw_id =  $request->get('user_id');
        $creatorForm->custb_id =  $request->get('addBranchSelect');
        $creatorForm->customer_selected =  $request->get('addCompanyWallet');
        $creatorForm->telco =  $request->get('addTelco');
        $creatorForm->wallet_num =  $request->get('addWalletNum');
        $creatorForm->authorization_key =  $request->get('addAuthKey');
        $creatorForm->merchant_token =  $request->get('addMerchantToken');
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
}
