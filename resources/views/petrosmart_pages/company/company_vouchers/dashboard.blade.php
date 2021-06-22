@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Manage Wallets')

@section('content')

<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">

                @if(strtoupper(session('userRole')) !== "OMC")
                <li>
                    <a href="/companyList">
                        <i class="ti ti-layers"></i>
                        <span class="text">Companies</span>
                    </a>
                </li>
                <li>
                    <a href="/companyBranchList">
                        <i class="ti ti-layout"></i>
                        <span class="text">Branches</span>
                    </a>
                </li>
                <li>
                    <a href="/companyDriversList">
                        <i class="ti ti-id-badge"></i>
                        <span class="text">Drivers</span>
                    </a>
                </li>
                <li>
                    <a href="/companyVehiclesList">
                        <i class="ti ti-car"></i>
                        <span class="text">Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="/companyWalletsList">
                        <i class="ti ti-wallet"></i>
                        <span class="text">Wallets</span>
                    </a>
                </li>
                <li><a href="#dropdown-voucher-tables" aria-expanded="true" data-toggle="collapse" class="active"><i class="ti-medall"></i>
                        <span>Vouchers</span>
                    </a>
                    <ul id="dropdown-voucher-tables" class="list-unstyled pt-0">
                        <li><a href="/companyVouchersList" class="sub_active">Company</a></li>
                        <li><a href="/driverVouchersList">Drivers</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/companyContactsList">
                        <i class="ti ti-mobile"></i>
                        <span class="text">Contacts</span>
                    </a>
                </li>
                <li><a href="#dropdown-settings-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-settings"></i>
                        <span>Settings</span>
                    </a>
                    <ul id="dropdown-settings-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/countryList">Countries</a></li>
                        <li><a href="/industryList">Industries</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "OMC")
                <li><a href="#dropdown-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-world"></i>
                        <span>OMC</span>
                    </a>
                    <ul id="dropdown-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/omcList">All OMC</a></li>
                        <li><a href="/applicationUsers">Manage Users</a></li>
                    </ul>
                </li>
                <li><a href="#dropdown-fuel-stations" aria-expanded="false" data-toggle="collapse"><i class="ti-bolt"></i>
                        <span>Fuel Stations</span>
                    </a>
                    <ul id="dropdown-fuel-stations" class="collapse list-unstyled pt-0">
                        <li><a href="/stationsList">Stations</a></li>
                        <li><a href="/clusteredStationsList">Clustered Stations</a></li>
                        <li><a href="/stationAttendantsList">Attendants</a></li>
                        <li><a href="/stationWalletsList">Wallets</a></li>
                        <li><a href="/stationPosList">POS Machines</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                <li><a href="#dropdown-fleet-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-id-badge"></i>
                        <span>Fleet Manager</span>
                    </a>
                    <ul id="dropdown-fleet-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/fleetManagerRequests">All Requests</a></li>
                        <li><a href="/manageFleetManagers">Manage Users</a></li>
                    </ul>
                </li>
                @endif


                @if(strtoupper(session('userRole')) !== "OMC")
                <li>
                    <a href="/petrosmartNotifications">

                        <i class="ti ti-bell"></i>
                        <span class="text">Notifications</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/chartDashboard" role="button">
                        <i class="ti ti-pie-chart"></i>
                        <span class="text">CHART-DASHBOARD</span>
                    </a>
                </li>


            </ul>


        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">
            <div class="give-space"></div>

            <!-- Export -->
            <div class="row">
                <!-- Begin Row -->

                <div class="col-12">
                    <div class="w3-card-2 w3-white panel widget has-shadow">
                        <div class="widget-header bordered no-actions">
                            <div class="row">
                                <div class="col-10">
                                    <h4>All Company Vouchers</h4>
                                </div>

                                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")

                                <div class="col-2">
                                    <h4><a href="#" data-toggle="modal" data-target="#addVoucherModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Voucher</a></h4>
                                </div>
                                @endif

                            </div>

                        </div>

                        <div class="widget-body sliding-tabs">

                            <div class="table-responsive">
                                <table id="voucherFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                            </th>
                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Unit Amount
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Total Amount
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Drivers
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Expiry Date
                                            </th>

                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                            </th>
                                            @endif

                                            @if(strtoupper(session('userRole')) == "USER")
                                            <th>
                                            </th>
                                            @endif
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- End Row -->

        </div>
        <!-- End Container -->
        <!-- Begin Page Footer-->
        <footer class="main-footer fixed-footer">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
                    <p class="text-gradient-02"><b>&copy; 2019 - <?php echo date("Y"); ?> , Petrosmart </b> | All Rights Reserved</p>

                </div>
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">

                </div>
            </div>
        </footer>
        <!-- End Page Footer -->
        <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
        <!-- Offcanvas Sidebar -->

        <!-- End Offcanvas Sidebar -->
    </div>
    <!-- End Content -->

    <!-- add fuel vouchers -->
    <div id="addVoucherModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_voucher_customer_contact" onchange="getCompanyBranches(this)" data-live-search="true" id="addCustomerVoucherContact" name="addCustomerVoucherContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVoucherCompanyBranchSelect" name="addVoucherCompanyBranchSelect" onchange="getCompanyBranchesDrivers(this)">
                                        <!-- <option value="allBranch">All Branch</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Drivers</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_drivers_per_branch_picker" multiple data-live-search="true" id="addVoucherCompanyDriverBranchSelect" name="addVoucherCompanyDriverBranchSelect">
                                    </select>
                                </div>
                            </div>



                            <div class="col-6">
                                <label class="form-control-label">Select Voucher Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVoucherType" name="addVoucherType">
                                        <option value="">Select type</option>
                                        <option value="single_use">Single Use</option>
                                        <option value="multiple_use">Multiple Use</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Unit Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            GHS
                                        </span> -->
                                        <input type="number" class="form-control" id="addVoucherAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select expiry date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="voucherExpiryDate" placeholder="Select when the voucher will expire">
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addVoucherBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit fuel vouchers -->
    <div id="editVoucherModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayVoucherName"></span></b> Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCustomerVoucherContact" name="editCustomerVoucherContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Voucher Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVoucherType" name="editVoucherType">
                                        <option value="">Select type</option>
                                        <option value="single_use">Single Use</option>
                                        <option value="multiple_use">Multiple Use</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            GHS
                                        </span> -->
                                        <input type="number" class="form-control" id="editVoucherAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select expiry date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="editVoucherExpiryDate" placeholder="Select when the voucher will expire">
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editVoucherBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- view voucher info -->
    <div id="viewVoucherInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="displayVoucherInfoName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Company:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayCompanyVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Branch:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayBranchVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Voucher Type:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayTypeVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Total Amount:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayTotalAmountVname"></span></label></p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="voucherInfoDisplayTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Driver Name
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Code
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Unit Amount
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Expiry Date
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody id="populateVoucherInfoBody"></tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/custom/company/vouchers.js')}}"></script>
@endpush