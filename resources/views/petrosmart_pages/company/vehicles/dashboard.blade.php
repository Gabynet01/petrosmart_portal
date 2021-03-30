@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Manage Company Drivers')

@section('content')

<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">

                @if(strtoupper(session('userRole')) !== "OMC")
                <!-- <li>
                    <a href="/petrosmartCompanyList" class="active">
                        <i class="ti ti-user"></i>
                        <span class="text">Companies</span>
                    </a>
                </li> -->
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
                    <a href="/companyVehiclesList" class="active">
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
                <li><a href="#dropdown-voucher-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-medall"></i>
                        <span>Vouchers</span>
                    </a>
                    <ul id="dropdown-voucher-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/companyVouchersList">Company</a></li>
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

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "FLEETMANAGER")
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
                                    <h4>All Vehicles</h4>
                                </div>

                                <div class="col-2">
                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                    <h4><a href="#" data-toggle="modal" data-target="#addVehiclesModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Vehicle</a></h4>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="widget-body sliding-tabs">

                            <div class="table-responsive">
                                <table id="vehiclesFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Drivers
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Make
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Model
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Vehicle Type
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Plate No.
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Type
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Registration Date
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
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

    <!-- add Vehicles -->
    <div id="addVehiclesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-car"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleName" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Number Plate</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehiclePlate" placeholder="Enter Plate Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVehicleType" name="addVehicleType">
                                        <option value="">Select type</option>
                                        <option value="Saloon">Saloon</option>
                                        <option value="Estate">Estate</option>
                                        <option value="Motorbike">Motorbike</option>
                                        <option value="Bus">Bus</option>
                                        <option value="MiniBus">MiniBus</option>
                                        <option value="Excavator">Excavator</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVehicleFuelType" name="addVehicleFuelType">
                                        <option value="">Select type</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Registration Date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="addVehicleRegistrationDate" placeholder="Select Date of Registration">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_driver_picker" multiple data-live-search="true" id="addVehicleDriverSelect" name="addVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_company_vehicle_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="addVehicleCompanySelect" name="addVehicleCompanySelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="addVehicleCompanyBranchSelect" name="addVehicleCompanyBranchSelect">
                                    </select>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addVehicleBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit Vehicles -->
    <div id="editVehiclesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayVehicleName"></span> Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-car"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleName" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Number Plate</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehiclePlate" placeholder="Enter Plate Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVehicleType" name="addVehicleType">
                                        <option value="">Select type</option>
                                        <option value="Saloon">Saloon</option>
                                        <option value="Estate">Estate</option>
                                        <option value="Motorbike">Motorbike</option>
                                        <option value="Bus">Bus</option>
                                        <option value="MiniBus">MiniBus</option>
                                        <option value="Excavator">Excavator</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVehicleFuelType" name="addVehicleFuelType">
                                        <option value="">Select type</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Registration Date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="editVehicleRegistrationDate" placeholder="Select Date of Registration">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control edit_driver_selected_picker" multiple data-live-search="true" id="editVehicleDriverSelect" name="editVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_company_edit_vehicle_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="editVehicleCompanySelect" name="editVehicleCompanySelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editVehicleCompanyBranchSelect" name="editVehicleCompanyBranchSelect">
                                    </select>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editVehicleBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Drivers Rules Modal -->
    <div id="DriverRulesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="driverDisplayRulesName"><span>'s Limits</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per transaction</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="transactionVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyTransactionLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per Day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyAmountLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyTransactionLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyAmountLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3"><label class="form-control-label">Purchase Week Days</label></div>
                                    <div class="col-3">


                                        <div class="mb-3">
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-1" value="Sunday">
                                                <label for="check-1">Sunday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-2" value="Monday">
                                                <label for="check-2">Monday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-3" value="Tuesday">
                                                <label for="check-3">Tuesday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-4" value="Wednessday">
                                                <label for="check-4">Wednessday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-5" value="Thursday">
                                                <label for="check-5">Thursday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-6" value="Friday">
                                                <label for="check-6">Friday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-7" value="Saturday">
                                                <label for="check-7">Saturday</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Daily Purchase Period</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>

                                                <input type="text" class="form-control" id="addTimeOfDayToCard" placeholder="Select time card can be used">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkFillingStation">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Filling Stations</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control select_picker_rules_omc" multiple data-live-search="true" id="allowedOmcRules">
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkProducts">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Products</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="allowedProductRules">
                                                <option value="">Select product</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Petrol">Petrol</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkIncorrectPin">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Incorrect PIN entries maximum</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="incorrectPinEntry">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkPurchase">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Purchase lock-out Period</label>

                                    </div>

                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="cardLockPeriodType">
                                                <option value="">Period type</option>
                                                <option value="Minutes">Minutes</option>
                                                <option value="Hours">Hours</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="cardLockPeriodValue">
                                            </div>
                                        </div>
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

                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addDriverRulesBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- show Drivers Rules Modal -->
    <div id="showDriverRulesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="showDriverDisplayRulesName"><span>'s Limits</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editDriverRulesForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per transaction</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="transactionVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyTransactionLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per Day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyAmountLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyTransactionLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyAmountLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3"><label class="form-control-label">Purchase Week Days</label></div>
                                    <div class="col-3">


                                        <div class="mb-3">
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-1" value="Sunday">
                                                <label for="checkShow-1">Sunday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-2" value="Monday">
                                                <label for="checkShow-2">Monday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-3" value="Tuesday">
                                                <label for="checkShow-3">Tuesday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-4" value="Wednessday">
                                                <label for="checkShow-4">Wednessday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-5" value="Thursday">
                                                <label for="checkShow-5">Thursday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-6" value="Friday">
                                                <label for="checkShow-6">Friday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-7" value="Saturday">
                                                <label for="checkShow-7">Saturday</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Daily Purchase Period</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>

                                                <input type="text" class="form-control" id="addTimeOfDayToCardShow" placeholder="Select time card can be used">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Filling Stations</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control select_picker_rules_omc_update" multiple data-live-search="true" id="allowedOmcRulesShow">
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Products</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="allowedProductRulesShow">
                                                <option value="">Select product</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Petrol">Petrol</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Incorrect PIN entries maximum</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="incorrectPinEntryShow">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Purchase lock-out Period</label>

                                    </div>

                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="cardLockPeriodTypeShow">
                                                <option value="">Period type</option>
                                                <option value="Minutes">Minutes</option>
                                                <option value="Hours">Hours</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="cardLockPeriodValueShow">
                                            </div>
                                        </div>
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

                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editDriverRulesBtn">Update Rules</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/custom/company/vehicles.js')}}"></script>
@endpush