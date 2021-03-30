$(document).ready(function () {
    getFuelVouchersData();
    getAllDriversArray();
    getCustomersArray();
    voucherExpiryDatePicker();
});

// Query fuel vouchers forms Data
function getFuelVouchersData() {
    var data_table = null;

    $('voucherFormDataTable').DataTable().destroy();

    data_table = $('#voucherFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFuelVouchersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'type_chosen', name: 'type_chosen' },
            { data: 'unit_amount', name: 'unit_amount' },
            { data: 'amount', name: 'amount' },
            { data: 'driver_chosen', name: 'driver_chosen' },
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

                    // var edit_action = "<a href='#' rel='tooltip' data-voucher-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit voucher'><i class='ti-pencil'></i></a>";
                    var edit_action = "";
                    var view_voucher_info = "<a href='#' rel='tooltip' data-voucher-info='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='view voucher info'><i class='ti-receipt'></i></a>";
                    // var delete_action = "<a href='#' rel='tooltip' data-voucher-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete voucher'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + view_voucher_info;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

/** ADD FUEL VOUCHERS API **/
$("#addVoucherBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCustomerContact = $.trim($('#addCustomerVoucherContact').val());
    var addVoucherType = $.trim($('#addVoucherType').val());
    var addVoucherAmount = $.trim($('#addVoucherAmount').val());
    var addVoucherCompanyBranchSelect = $.trim($('#addVoucherCompanyBranchSelect').val());
    var addVoucherCompanyDriverBranchSelect = $.trim($('#addVoucherCompanyDriverBranchSelect').val());
    var addVoucherExpiryDate = $.trim($('#voucherExpiryDate').val());


    if (addCustomerContact == "" || addCustomerContact == undefined) {
        displayErrorMsgModal("Please Select Company"); //display Error message
        return false;
    } else if (addVoucherType == "" || addVoucherType == undefined) {
        displayErrorMsgModal("Please select voucher type"); //display Error message
        return false;
    } else if (addVoucherAmount == "" || addVoucherAmount == undefined) {
        displayErrorMsgModal("Please enter voucher amount"); //display Error message
        return false;
    } else if (addVoucherCompanyBranchSelect == "" || addVoucherCompanyBranchSelect == undefined) {
        displayErrorMsgModal("Please select branch"); //display Error message
        return false;
    } else if (addVoucherCompanyDriverBranchSelect == "" || addVoucherCompanyDriverBranchSelect == undefined) {
        displayErrorMsgModal("Please select driver"); //display Error message
        return false;
    } else if (addVoucherExpiryDate == "" || addVoucherExpiryDate == undefined) {
        displayErrorMsgModal("Please select expiry date"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // based on the number of drivers
        var allDrivers = addVoucherCompanyDriverBranchSelect.split(",");
        var driverCount = allDrivers.length;
        var totalAmount;
        var jsonDriver = {};
        var driverArray = [];
        if (driverCount > 0) {

            // calculate total amount from the unit amount from the number of drivers
            totalAmount = addVoucherAmount * driverCount;

            // let generate voucher codes for the selected drivers
            for (i = 0; i < driverCount; i++) {
                jsonDriver = {}

                jsonDriver["parent_voucher_id"] = user_id;
                jsonDriver["voucher_id"] = userRandomString();
                jsonDriver["voucher_code"] = itemRandomString();
                jsonDriver["voucher_type"] = addVoucherType;
                jsonDriver["driver_id"] = allDrivers[i];
                jsonDriver["unit_amount"] = addVoucherAmount;
                jsonDriver["expiry_date"] = addVoucherExpiryDate;

                driverArray.push(jsonDriver);
            }

        }

        $("#addVoucherBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addVoucherCode": utoa(JSON.stringify(driverArray)),
            "driverVouchersList": JSON.stringify(driverArray),
            "addCustomerContact": addCustomerContact,
            "addVoucherType": addVoucherType,
            "addVoucherAmount": addVoucherAmount,
            "totalAmount": totalAmount,
            "addVoucherCompanyBranchSelect": addVoucherCompanyBranchSelect,
            "addVoucherCompanyDriverBranchSelect": addVoucherCompanyDriverBranchSelect,
            "addVoucherExpiryDate": addVoucherExpiryDate
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartFuelVouchersApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addVoucherBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'voucherTab');

                // console.log(data);
                location.reload();

                $('#addVoucherModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addVoucherBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addVoucherBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// handle voucher button
$(document).on('click', '[data-voucher-info]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-info'));

    $('#displayVoucherInfoName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#displayCompanyVname').html(jsonDetails.customer_chosen);
    $('#displayBranchVname').html(jsonDetails.branch_chosen);
    $('#displayTypeVname').html(jsonDetails.type_chosen);
    $('#displayTotalAmountVname').html(jsonDetails.amount);

    // lets generate the table

    var table_list = "";
    var driver_name;

    // lets get the driver name
    var driverNames = jsonDetails.driver_chosen.split(",");
    var driverIds = jsonDetails.drivers.split(",");

    var allData = JSON.parse(atou(jsonDetails.voucher_code));

    for (i = 0; i < allData.length; i++) {
        mainData = allData[i];

        table_list +=
            "<tr width='100%'>" +
            "<td>" + parseInt(i + 1) + "</td>" +
            "<td>" + driverNames[i] + "</td>" +
            "<td>" + mainData.voucher_code + "</td>" +
            "<td>" + mainData.unit_amount + "</td>" +
            "<td>" + jsonDetails.date_created + "</td>" +
            "<td>" + jsonDetails.voucher_expiry_date + "</td>"
    }


    $('#populateVoucherInfoBody').html(table_list);

    $('#voucherInfoDisplayTable').DataTable();

    $('#viewVoucherInfoModal').modal('show');


});
// handle voucher button
$(document).on('click', '[data-voucher-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-edit'));

    $('#displayVoucherName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editCustomerVoucherContact').val(jsonDetails.customer);
    $('#editVoucherType').val(jsonDetails.voucher_type);
    $('#editVoucherAmount').val(jsonDetails.amount);
    $('#editVoucherExpiryDate').html(jsonDetails.expiry_date);


    $('#editVoucherModal').modal('show');

    /** EDIT FUEL VOUCHERS API **/

    $("#editVoucherBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCustomerContact = $.trim($('#editCustomerVoucherContact').val());
        var addVoucherType = $.trim($('#editVoucherType').val());
        var addVoucherAmount = $.trim($('#editVoucherAmount').val());
        var addVoucherExpiryDate = $.trim($('#editVoucherExpiryDate').val());


        if (addCustomerContact == "" || addCustomerContact == undefined) {
            displayErrorMsgModal("Please Select Company"); //display Error message
            return false;
        } else if (addVoucherType == "" || addVoucherType == undefined) {
            displayErrorMsgModal("Please select voucher type"); //display Error message
            return false;
        } else if (addVoucherAmount == "" || addVoucherAmount == undefined) {
            displayErrorMsgModal("Please enter voucher amount"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();
            addVoucherCode = itemRandomString();

            $("#editVoucherBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.fv_id,
                "addVoucherCode": addVoucherCode,
                "addCustomerContact": addCustomerContact,
                "addVoucherType": addVoucherType,
                "addVoucherAmount": addVoucherAmount,
                "addVoucherExpiryDate": addVoucherExpiryDate
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartFuelVouchersApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editVoucherBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'voucherTab');

                    // console.log(data);
                    location.reload();

                    $('#editVoucherModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editVoucherBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editVoucherBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });
});

// Date Picker Component
function voucherExpiryDatePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#voucherExpiryDate span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#voucherExpiryDate').daterangepicker({
        parentEl: $('#addVoucherModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#voucherExpiryDate').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}