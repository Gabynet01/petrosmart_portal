<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartVoucherList;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class DriverVouchersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.driver_vouchers.dashboard');
    }

    // get all data in fuel vouchers 
    public function getDriverFuelVouchersDataApi(Request $request)
    {
        $model = PetrosmartVoucherList::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
