$(document).ready(function () {
    getDriverFuelVouchersData();
});

// Query fuel vouchers forms Data
function getDriverFuelVouchersData() {
    var data_table = null;

    $('driverVoucherFormDataTable').DataTable().destroy();

    data_table = $('#driverVoucherFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getDriverFuelVouchersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'type_chosen', name: 'type_chosen' },
            { data: 'amount', name: 'amount' },
            { data: 'balance', name: 'balance' },
            { data: 'usage_status', name: 'usage_status' },
            { data: 'date_created', name: 'date_created' },
            { data: 'voucher_expiry_date', name: 'voucher_expiry_date' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    //check if voucher status is deactivated
                    var voucherStatus = data.usage_status;

                    var inactive_action = "<a href='#' rel='tooltip' data-voucher-inactive='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='make voucher inactive'><i class='ti-cut'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        if (voucherStatus.toUpperCase() == "DEACTIVATED") {
                            return "";
                        } else {
                            return inactive_action;
                        }

                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

//MAKE VOUCHER DATA INACTIVE
$(document).on('click', '[data-voucher-inactive]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-inactive'));

    var formData = {
        "voucherId": jsonDetails.voucher_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Deactivate " + jsonDetails.driver_chosen + " Vocuher?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deactivateDriverVoucherApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'driverVoucherTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
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