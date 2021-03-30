var mainApiUrl = "http://test.petrosmartgh.com:7777";
$(document).ready(function () {
    getPendingRequests();

    setTimeout(() => {
        getApprovedRequests();
    }, 3000);
});


// Query manager forms Data
function getPendingRequests() {
    var data_table = null;

    $('pendingRequestsDataTable').DataTable().destroy();

    data_table = $('#pendingRequestsDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFleetManagersRequestsDataApi',
            "data": function (d) {
                d.request_status = "pending";
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'payment_code', name: 'payment_code' },
            { data: 'amount', name: 'amount' },
            { data: 'station_wallet_chosen', name: 'station_wallet_chosen' },
            { data: 'company_wallet_chosen', name: 'company_wallet_chosen' },
            { data: 'approval_flag', name: 'approval_flag' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var approve_action = "<a href='#' rel='tooltip' data-request-approve='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='approve request'><i class='ti-check-box'></i></a>";
                    // var more_action = "<a href='#' rel='tooltip' data-request-approve='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='view details'><i class='ti-eye'></i></a>";

                    return approve_action;

                }
            },
        ]
    });

}

// Query manager forms Data
function getApprovedRequests() {
    var data_table = null;

    $('approvedRequestsDataTable').DataTable().destroy();

    data_table = $('#approvedRequestsDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFleetManagersRequestsDataApi',
            "data": function (d) {
                d.request_status = "approved";
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'payment_code', name: 'payment_code' },
            { data: 'amount', name: 'amount' },
            { data: 'station_wallet_chosen', name: 'station_wallet_chosen' },
            { data: 'company_wallet_chosen', name: 'company_wallet_chosen' },
            { data: 'approval_flag', name: 'approval_flag' },
            { data: 'date_created', name: 'date_created' },

        ]
    });

}

//approval from fleet manager
$(document).on('click', '[data-request-approve]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-request-approve'));

    console.log(jsonDetails)

    var formData = {
        "requestId": jsonDetails.request_id,
        "fleetManagerId": jsonDetails.fleet_manager_id,
        "stationId": jsonDetails.station_id_chosen,
        "paymentCode": jsonDetails.payment_code,
        "driverId": jsonDetails.driver_id
    };

    formData = JSON.stringify(formData);
    console.log("formData --> ", formData);

    swal({
        title: "Approve " + jsonDetails.driver_chosen + " Payment of GHC" + jsonDetails.amount + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            console.log("am about to call--->>>")
            show_loader();

            var request = $.ajax({
                url: "/makeApiCallToApprove",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                console.log("data-->>>", data);
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'fleetPendingRequestTab');
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else if (data.RESPONSE_CODE == "201") {
                    displaySuccessMsg(toTitleCase(data.RESPONSE_MESSAGE));
                    location.reload();
                }

                else {
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});