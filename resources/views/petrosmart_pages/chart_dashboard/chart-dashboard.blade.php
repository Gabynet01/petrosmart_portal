@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Chart Dashboard')

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
                    <a href="/chartDashboard" role="button" class="active">
                        <i class="ti ti-pie-chart"></i>
                        <span class="text">CHART-DASHBOARD</span>
                    </a>
                </li>


            </ul>


            <!-- End Main Navigation -->
        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">
            <div class="give-space"></div>
            <!-- Begin Page Header-->
            <div class="row">
                <div class="page-header">
                    <div class="d-flex align-items-center">
                        <!-- <h2 class="page-header-title">Dashboard</h2> -->
                        <!-- <div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="db-default.html"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Charts</a></li>
                                <li class="breadcrumb-item active">Chart Js</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
            <div class="row flex-row">
                <div class="col-xl-6">
                    <!-- Line Chart 01 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Line Chart 01</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="line-chart-01"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Line Chart 01 -->
                </div>
                <div class="col-xl-6">
                    <!-- Line Chart 02 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Line Chart 02</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="line-chart-02"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Line Chart 02 -->
                </div>
                <div class="col-xl-6">
                    <!-- Area Chart 01 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Area Chart 01</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="area-chart-01"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Area Chart 01 -->
                </div>
                <div class="col-xl-6">
                    <!-- Area Chart 02 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Area Chart 02</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="area-chart-02"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Area Chart 02 -->
                </div>
                <div class="col-xl-6">
                    <!-- Vertical Bar 01 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Vertical Bar 01</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="vertical-chart-01"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Vertical Bar 01 -->
                </div>
                <div class="col-xl-6">
                    <!-- Vertical Bar 02 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Vertical Bar 02</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="vertical-chart-02"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Vertical Bar 02 -->
                </div>
                <div class="col-xl-6">
                    <!-- Horizontal Bar 01 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Horizontal Bar 01</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="horizontal-chart-01"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Horizontal Bar 01 -->
                </div>
                <div class="col-xl-6">
                    <!-- Horizontal Bar 02 -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Horizontal Bar 02</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="horizontal-chart-02"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Horizontal Bar 02 -->
                </div>
                <div class="col-xl-6">
                    <!-- Doughnut Chart -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Doughnut Chart</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="doughnut-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Doughnut Chart -->
                </div>
                <div class="col-xl-6">
                    <!-- Pie Chart -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Pie Chart</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="pie-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Pie Chart -->
                </div>
                <div class="col-xl-6">
                    <!-- Radar Chart -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Radar Chart</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="radar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Radar Chart -->
                </div>
                <div class="col-xl-6">
                    <!-- Polar Chart -->
                    <div class="widget has-shadow">
                        <div class="widget-header bordered no-actions d-flex align-items-center">
                            <h4>Polar Chart</h4>
                        </div>
                        <div class="widget-body">
                            <div class="chart">
                                <canvas id="polar-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Polar Chart -->
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



</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<!-- <script src="{{asset('assets/js/components/manage_app_customers.js')}}"></script> -->
@endpush