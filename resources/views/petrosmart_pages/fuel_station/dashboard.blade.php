@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Manage Fuel Station')

@section('content')

<!-- ADMIN ONLY -->
@if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "OMC")
<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">
                <!-- <li>
                    <a href="/objects" role="button">
                        <i class="ti ti-location-pin"></i>
                        <p class="text">MAP</p>
                    </a>
                </li> -->
                @if(strtoupper(session('userRole')) !== "OMC")
                <li>
                    <a href="/petrosmartCompanyList">
                        <i class="ti ti-user"></i>
                        <p class="text">Companies</p>
                    </a>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "OMC")
                <li><a href="#dropdown-tables" aria-expanded="true" data-toggle="collapse" class="active"><i class="ti-spray"></i>
                        <p>OMC</p>
                    </a>
                    <ul id="dropdown-tables" class="list-unstyled pt-0">
                        <li><a href="/petrosmartOmcList" class="sub_active">All OMC</a></li>
                        <li><a href="/applicationUsers">Manage Users</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                <li><a href="#dropdown-fleet-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-id-badge"></i>
                        <p>Fleet Manager</p>
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
                        <p class="text">Notifications</p>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/chartDashboard" role="button">
                        <i class="ti ti-pie-chart"></i>
                        <p class="text">CHART-DASHBOARD</p>
                    </a>
                </li>


            </ul>

        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">

            <br>
            <!-- Dashboards Cards-->
            <div class="row">

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">OMC</div>
                                    <div class="number">{{ $omc }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Fuel Stations</div>
                                    <div class="number">{{ $fuelStations }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Clustered Stations</div>
                                    <div class="number">{{ $clusteredStations }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Attendants</div>
                                    <div class="number">{{ $attendants }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">POS</div>
                                    <div class="number">{{ $pos }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Payments</div>
                                    <div class="number">{{ $payments }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Purchase</div>
                                    <div class="number">{{ $purchase }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Wallets</div>
                                    <div class="number">{{ $wallet }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <br>

            <!-- Export -->
            <div class="row">
                <div class="col-12">
                    <div class="w3-card-2 w3-white panel widget has-shadow">

                        <div class="widget-body sliding-tabs">
                            <ul class="nav nav-tabs" id="example-one" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab-2d" data-toggle="tab" href="#tab-2d" role="tab" aria-controls="tab-2d" aria-selected="false">OMC</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Fuel Stations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2J" data-toggle="tab" href="#tab-2J" role="tab" aria-controls="tab-2J" aria-selected="false">Clustered Stations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2a" data-toggle="tab" href="#tab-2a" role="tab" aria-controls="tab-2a" aria-selected="false">Attendants</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2k" data-toggle="tab" href="#tab-2k" role="tab" aria-controls="tab-2k" aria-selected="false">Wallets</a>
                                </li>

                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2b" data-toggle="tab" href="#tab-2b" role="tab" aria-controls="tab-2b" aria-selected="false">Vouchers</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2c" data-toggle="tab" href="#tab-2c" role="tab" aria-controls="tab-2c" aria-selected="false">POS</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2e" data-toggle="tab" href="#tab-2e" role="tab" aria-controls="tab-2e" aria-selected="false">Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2f" data-toggle="tab" href="#tab-2f" role="tab" aria-controls="tab-2f" aria-selected="false">Purchase</a>
                                </li>


                            </ul>
                            <div class="tab-content pt-3">
                                <!-- FUEL STATIONS -->
                                <div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="base-tab-1">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Fuel Stations</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addFuelStationModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Fuel Station</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="appFuelStationsDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Name: activate to sort column ascending">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Address: activate to sort column ascending">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="gps: activate to sort column ascending">GPS
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="gpsradius: activate to sort column ascending">GPS Radius
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="POS: activate to sort column ascending">POS
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="OMC: activate to sort column ascending">OMC
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Industry: activate to sort column ascending">Country
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Date: activate to sort column ascending">Created Date
                                                                    </th>
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
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

                                <!-- wallets -->
                                <div class="tab-pane fade" id="tab-2k" role="tabpanel" aria-labelledby="base-tab-2k">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Wallets</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addWalletModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Wallet</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">

                                                        <table id="walletsFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Station Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Telco
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Wallet Number
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


                                </div>


                                <!-- CLUSTERED STATIONS -->
                                <div class="tab-pane fade" id="tab-2J" role="tabpanel" aria-labelledby="base-tab-2J">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Clustered Stations</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addClusteredStationModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Clustered Station</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="appClusteredStationsDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Stations
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Actions
                                                                    </th>
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

                                <!-- Attendants-->
                                <div class="tab-pane fade" id="tab-2a" role="tabpanel" aria-labelledby="base-tab-2a">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Attendants</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addAttendantsModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Attendants</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="appFuelAttendantsDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Station
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">POS
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Date of Birth
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Email Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Telephone
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Mobile
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">PIN
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- Vouchers -->
                                <!-- <div class="tab-pane fade" id="tab-2b" role="tabpanel" aria-labelledby="base-tab-2b">

                                    <div class="row">
                                        

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Vouchers</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addVoucherModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Voucher</a></h4>
                                                        </div>
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

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Code
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div> -->

                                <!-- POS -->
                                <div class="tab-pane fade" id="tab-2c" role="tabpanel" aria-labelledby="base-tab-2c">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All POS</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addPosModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add POS</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="posFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <!-- <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Station
                                                                    </th> -->

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Make
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Model
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Serial Number
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- OMC -->
                                <div class="tab-pane fade show active" id="tab-2d" role="tabpanel" aria-labelledby="base-tab-2d">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All OMC</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addOmcModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add OMC</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">

                                                        <table id="omcFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Country
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                </div>

                                <!-- Payments-->
                                <div class="tab-pane fade" id="tab-2e" role="tabpanel" aria-labelledby="base-tab-2e">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Payments</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addPaymentModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Payment</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="paymentsFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Station
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Payment Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Code
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Payment Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Purchase-->
                                <div class="tab-pane fade" id="tab-2f" role="tabpanel" aria-labelledby="base-tab-2f">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Purchases</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addPurchaseModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Purchase</a></h4>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="purchaseFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Station
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Purchase Items
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Driver
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Vehicle
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Purchase Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Drivers-->
                                <div class="tab-pane fade" id="tab-2g" role="tabpanel" aria-labelledby="base-tab-2g">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Drivers</h4>
                                                        </div>

                                                        <!-- <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addDriversModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Driver</a></h4>
                                                        </div> -->
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="driversFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Date of Birth
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">E-mail Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Phone
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Device
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Vehicles-->
                                <div class="tab-pane fade" id="tab-2h" role="tabpanel" aria-labelledby="base-tab-2h">
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
                                                            <h4><a href="#" data-toggle="modal" data-target="#addVehiclesModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Vehicle</a></h4>
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

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Driver
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

                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

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

    <!--View add user modal-->
    <div id="addFuelStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Fuel Station</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addName" placeholder="Fuel Station Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addGps" placeholder="Enter GPS info">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS Radius</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addGpsRadius" placeholder="Enter GPS radius">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label class="form-control-label"></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addEmailAddress" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_station_pos_add" multiple data-live-search="true" id="addStationPos" name="addStationPos">
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select OMC</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_omc" data-live-search="true" id="addStationOMC" name="addStationOMC">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_country" data-live-search="true" id="addCountry" name="addCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <div id="addClusteredStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Clustered Station</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addClusterName" placeholder="Cluster Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Select Multiple Fuel Stations</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_clustered_fuel_stations" multiple data-actions-box="true" data-live-search="true" id="addClusteredFuelStations" name="addClusteredFuelStations">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addClusteredFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editClusteredStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayClusterName"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editClusterName" placeholder="Cluster Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Select Multiple Fuel Stations</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_clustered_edit_fuel_stations" multiple data-actions-box="true" data-live-search="true" id="editClusteredFuelStations" name="editClusteredFuelStations">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editClusteredFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--edit station modal-->
    <div id="editFuelStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayStationName"></span></b> Station</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editName" placeholder="Fuel Station Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editGps" placeholder="Enter GPS info">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS Radius</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editGpsRadius" placeholder="Enter GPS radius">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label class="form-control-label"></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addEmailAddress" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_station_pos_edit" multiple data-live-search="true" id="editStationPos" name="editStationPos">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select OMC</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStationOmc" name="editFuelStationOmc">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCountry" name="editCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add attendants -->
    <div id="addAttendantsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Attendants</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuel_stations_picker" data-live-search="true" id="addFuelStations" name="addFuelStations">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control selected_picker_attendant_pos" data-live-search="true" id="addSelectedPos" name="addSelectedPos">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addAttendantName" placeholder="Attendant Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addAttendantAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>


                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select Date of Birth</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="addDob" placeholder="Select Date of Birth">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">E-mail Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addAttendantEmail" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Telephone Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addAttendantTel" placeholder="Telephone">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Mobile Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addAttendantMob" placeholder="Mobile">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">PIN</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-lock"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addAttendantPin" placeholder="PIN">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addFuelAttendantsBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit attendants -->
    <div id="editAttendantsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayAttendantName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStations" name="editFuelStations">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editSelectedPos" name="editSelectedPos">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editAttendantName" placeholder="Attendant Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editAttendantAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>


                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select Date of Birth</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="editDob" placeholder="Select Date of Birth">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">E-mail Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="editAttendantEmail" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Telephone Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editAttendantTel" placeholder="Telephone">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Mobile Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editAttendantMob" placeholder="Mobile">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">PIN</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-lock"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editAttendantPin" placeholder="PIN">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editFuelAttendantsBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add wallet modal-->
    <div id="addWalletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addWalletForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuelStation_wallet_picker" data-live-search="true" id="addStationWallet" name="addStationWallet">
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-6">
                                <label class="form-control-label">Select Network</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addTelco" name="addTelco">
                                        <option value="">Select Telco</option>
                                        <option value="mtn">MTN</option>
                                        <option value="vodafone">Vodafone</option>
                                        <option value="airtelTigo">Airtel-Tigo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Wallet Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addWalletNum" placeholder="Enter wallet number">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addWalletBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit wallet modal-->
    <div id="editWalletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayWalletName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addWalletForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control edit_fuelStation_wallet_picker" data-live-search="true" id="editStationWallet" name="editStationWallet">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Network</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editTelco" name="editTelco">
                                        <option value="">Select Telco</option>
                                        <option value="mtn">MTN</option>
                                        <option value="vodafone">Vodafone</option>
                                        <option value="airtelTigo">Airtel-Tigo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Wallet Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editWalletNum" placeholder="Enter wallet number">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editWalletBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add POS -->
    <div id="addPosModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add POS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <!-- <div class="col-12">
                                <label class="form-control-label">Select Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuel_stations_picker_pos" data-live-search="true" id="addFuelStationsPos" name="addFuelStationsPos">
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Enter Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-tablet"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addPosMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-tablet"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addPosModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Serial No.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-ruler-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addPosSerial" placeholder="Enter Serial Number">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addPosBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit POS -->
    <div id="editPosModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayPosName"></span></b> POS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <!-- <div class="col-12">
                                <label class="form-control-label">Select Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStationsPos" name="editFuelStationsPos">
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Enter Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-tablet"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editPosMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-tablet"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editPosModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Serial No.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-ruler-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editPosSerial" placeholder="Enter Serial Number">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editPosBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add OMC -->
    <div id="addOmcModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add OMC</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-id-badge"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addOmcName" placeholder="Enter OMC Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Enter Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addOmcAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_omc_country" data-live-search="true" id="addOmcCountry" name="addOmcCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addOmcBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit OMC -->
    <div id="editOmcModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayOmcName"></span></b> OMC</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-id-badge"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editOmcName" placeholder="Enter OMC Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Enter Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editOmcAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editOmcCountry" name="editOmcCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editOmcBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Payments -->
    <div id="addPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control paymentCustomerSelectpicker" onchange="getCustomerVouchers(this)" data-live-search="true" id="addPaymentCustomer" name="addPaymentCustomer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control paymentDriverSelectpicker" data-live-search="true" id="addPaymentDriver" name="addPaymentDriver">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuel_stations_picker_payment" data-live-search="true" id="addFuelStationsPayment" name="addFuelStationsPayment">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Payment Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addPaymentType" name="addPaymentType" onchange="getPaymentType(this)">
                                        <option value="">Select type</option>
                                        <option value="Voucher">Voucher</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6" id="voucherDiv">
                                <label class="form-control-label">Select Voucher</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_voucher_picker" onchange="getVoucherUsageType(this)" data-live-search="true" id="addCustomerVoucherCode" name="addCustomerVoucherCode">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6" id="companyAmountDiv">
                                <label class="form-control-label">Enter Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                        <input type="text" class="form-control" id="addCompanyAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12" id="multipleAmountDiv">
                                <div class="row">

                                    <div class="col-6" align="right">
                                        <div style="padding-top: 30px;"></div>
                                        <input id="addVoucherType" hidden />
                                        <label class="form-control-label"><span id="voucherTypeIdentified"></span> Voucher Total (<b><span id="totalVoucherAmount"></span></b>)</label>
                                    </div>
                                    <div class="col-6" id="multipleOnlyDiv">
                                        <label class="form-control-label">Enter Amount</label>
                                        <br>
                                        <label class="form-control-label">Voucher Balance (<b><span id="totalVoucherBalance"></span></b>)</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                                <input type="text" class="form-control" id="addMultipleUseAmount" placeholder="Enter Amount">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addPaymentBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- edit Payments -->
    <div id="editPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayPaymentName"></span></b> Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editPaymentCustomer" name="editPaymentCustomer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editPaymentDriver" name="editPaymentDriver">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStationsPayment" name="editFuelStationsPayment">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Payment Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editPaymentType" name="editPaymentType" onchange="getPaymentType(this)">
                                        <option value="">Select type</option>
                                        <option value="Voucher">Voucher</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6" id="editVoucherDiv">
                                <label class="form-control-label">Select Voucher</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editPaymentVoucherCode" name="editPaymentVoucherCode">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editPaymentBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Purchase -->
    <div id="addPurchaseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Purchase</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control purchaseCustomerSelectpicker" data-live-search="true" id="addPurchaseCustomer" name="addPurchaseCustomer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control purchaseDriverSelectpicker" onchange="getPurchaseDriverVehicles(this)" data-live-search="true" id="addPurchaseDriver" name="addPurchaseDriver">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control purchaseVehicleSelectpicker" data-live-search="true" id="addPurchaseVehicle" name="addPurchaseVehicle">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuel_stations_picker_purchase" data-live-search="true" id="addFuelStationsPurchase" name="addFuelStationsPurchase">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                        <input type="text" class="form-control" id="addPurchaseAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Purchase Items</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-shopping-cart-full"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addPurchaseItems" placeholder="Enter Purchase Items">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addPurchaseBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit Purchase -->
    <div id="editPurchaseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayPurchaseName"></span> Purchase</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editPurchaseCustomer" name="editPurchaseCustomer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" onchange="getPurchaseDriverVehicles(this)" id="editPurchaseDriver" name="editPurchaseDriver">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editPurchaseVehicle" name="editPurchaseVehicle">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStationsPurchase" name="editFuelStationsPurchase">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                        <input type="text" class="form-control" id="editPurchaseAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Enter Purchase Items</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-shopping-cart-full"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editPurchaseItems" placeholder="Enter Purchase Items">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editPurchaseBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Drivers -->
    <div id="addDriversModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="driverDisplayName"><span>'s Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverName" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Phone</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverPhone" placeholder="Enter Phone">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Email</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverEmail" placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Device</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="addDeviceSelect" name="addDeviceSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="addBranchSelect" name="addBranchSelect">
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">

                                <label class="form-control-label d-flex ">Date of Birth</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="addDobDriver" placeholder="Select Date of Birth">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addDriverBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

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
                                    <select class="custom-select-roletype form-control select_driver_picker" data-live-search="true" id="addVehicleDriverSelect" name="addVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_vehicle_branch_picker" data-live-search="true" id="addVehicleBranchSelect" name="addVehicleBranchSelect">
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
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editVehicleDriverSelect" name="editVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editVehicleBranchSelect" name="editVehicleBranchSelect">
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


    <!-- Show more details of user -->
    <div id="moreDetailsAdminUserData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <p>Full Name:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminFullname"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Username:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminUsername"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Email:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminEmail"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created By:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedBy"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created Date:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedDate"></p>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal to edit users-->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayEditUserName"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editFullName" placeholder="Full Name">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->
@endif

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/components/manage_app_fuel_station.js')}}"></script>
@endpush