<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartFuelStationWallet;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class StationWalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.fuel_stations.wallets.dashboard');
    }

    // add wallet
    public function addFuelStationWalletApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelStationWallet::where("custw_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelStationWallet::where("custw_id", $request->get('user_id'))->first();
            $message = "Successfully edited wallet";
        } else {
            $creatorForm = new PetrosmartFuelStationWallet();
            $message = "Wallet was created successfully";
        }

        $creatorForm->custw_id =  $request->get('user_id');
        $creatorForm->fuel_station_id =  $request->get('addStationWallet');
        $creatorForm->telco =  $request->get('addTelco');
        $creatorForm->wallet_num =  $request->get('addWalletNum');
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

    // get all data in wallets 
    public function getWalletFuelStationDataApi(Request $request)
    {
        $model = PetrosmartFuelStationWallet::query();

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
}
