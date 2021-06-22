<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartFuelVouchers;
use App\PetrosmartVoucherList;
use App\PetrosmartWallet;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class CompanyVouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.company_vouchers.dashboard');
    }

    //check wallet balance 
    public function checkWalletBalanceApi(Request $request)
    {
        //lets get the company wallet info
        if (PetrosmartWallet::where("customer_selected", $request->get('addCustomerContact'))->exists()) {
            $fetchWalletItems = PetrosmartWallet::where("customer_selected", $request->get('addCustomerContact'))->first();

            //get authorization key and merchant token 
            $authorization_key = $fetchWalletItems->authorization_key;
            $merchant_token = $fetchWalletItems->merchant_token;
        }

        $response = Http::post('http://test.petrosmartgh.com:7777/api/check/wallet/balance', [
            "merchant_token" =>  $merchant_token,
            "authorization_key" =>  $authorization_key
        ]);

        $responseApi = $response->json();

        if ($responseApi["code"] == "200") {
            //now that we have a successful response
            //lets compare the wallet balance to the voucher amount to be purchased

            $responseBalance = $responseApi["data"];
            $floatBalance = (float) $responseBalance["floatBalance"];
            $totalAmount = (float) $request->get('totalAmount');

            // dd($totalAmount <= $floatBalance);

            if ($totalAmount <= $floatBalance) {
                $response_code = $responseApi["code"];
                $response_message = $responseApi["message"];
            } else {
                $response_code = "207";
                $response_message = "Your wallet balance is too low";
            }
        } else {
            $response_code = $responseApi["code"];
            $response_message = $responseApi["message"];
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $responseApi, "RESPONSE_CODE" => $response_code]);
    }

    // add fuel vouchers
    public function addPetrosmartFuelVouchersApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelVouchers::where("fv_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelVouchers::where("fv_id", $request->get('user_id'))->first();
            $message = "Successfully edited voucher";
        } else {
            $creatorForm = new PetrosmartFuelVouchers();
            $message = "Voucher was created successfully";

            //    we need to decode the json array string so that we can push it into the db
            $voucherList = json_decode($request->get('driverVouchersList'), true);

            //loop through the list and create the 
            foreach ($voucherList as $voucher) {
                $voucherForm = new PetrosmartVoucherList();
                $voucherForm->parent_voucher_id = $voucher["parent_voucher_id"];
                $voucherForm->voucher_id = $voucher["voucher_id"];
                $voucherForm->driver_id = $voucher["driver_id"];
                $voucherForm->voucher_code = $voucher["voucher_code"];
                $voucherForm->voucher_type = $voucher["voucher_type"];
                $voucherForm->amount = $voucher["unit_amount"];
                $voucherForm->balance = $voucher["unit_amount"];
                $voucherForm->usage_status = "unused";
                $voucherForm->expiry_date = Carbon::parse($voucher["expiry_date"])->utc();
                $voucherForm->created_by =  $session_email;

                //save the form to db
                $saveVoucherResults = 0;
                DB::beginTransaction();
                $saveVoucherResults = $voucherForm->save();
                DB::commit();
            }
        }

        // check if the voucher forms were saved before executing the others
        if ($saveVoucherResults) {
            if ($request->get('addVoucherExpiryDate') !== NULL) {
                $expiry_date =  Carbon::parse($request->get('addVoucherExpiryDate'))->utc();
                $creatorForm->expiry_date =  $expiry_date;
            }

            $creatorForm->fv_id =  $request->get('user_id');
            $creatorForm->customer =  $request->get('addCustomerContact');
            $creatorForm->voucher_type =  $request->get('addVoucherType');
            $creatorForm->unit_amount =  $request->get('addVoucherAmount');
            $creatorForm->amount =  $request->get('totalAmount');
            $creatorForm->voucher_code =  $request->get('addVoucherCode');
            $creatorForm->branch_id =  $request->get('addVoucherCompanyBranchSelect');
            $creatorForm->drivers =  $request->get('addVoucherCompanyDriverBranchSelect');
            $creatorForm->usage_status =  "unused";
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
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in fuel vouchers 
    public function getFuelVouchersDataApi(Request $request)
    {
        $model = PetrosmartFuelVouchers::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // get voucher usage type array
    public function getVoucherUsageTypeApi(Request $request)
    {
        $responseObj = [];
        $data = PetrosmartFuelVouchers::where(strtoupper('fv_id'), strtoupper($request->get('voucherId')))
            // ->where('created_by', Session::get('email'))
            ->first();

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Voucher type pulled successfully";

        return $responseObj;
    }
}
