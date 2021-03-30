var addFleetManagerApi = "/addFleetManagerApi";
var editFleetManagerApi = "/editFleetManagerApi";
var deleteFleetManagerApi = "/deleteFleetManagerApi";

$(document).ready(function () {
    getCustomersArray();
    getAllDriversArray();
    getAdminUsersData();
});

/** ADD USER API **/

$("#addUserBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var fullName = $.trim($('#addFullName').val());
    var password = $.trim($('#addPassword').val());
    var email = $.trim($('#addEmailAddress').val());
    var phoneNumber = $.trim($('#addMobileNumber').val());
    var addFleetManagerCompanySelect = $.trim($('#addFleetManagerCompanySelect').val());
    var addBranchSelect = $.trim($('#addFleetManagerCompanyBranchSelect').val());
    var addFleetManagerDriverSelect = $.trim($('#addFleetManagerDriverSelect').val());

    if (email == "" || email == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    }

    else if (phoneNumber == "" || phoneNumber == undefined) {
        displayErrorMsgModal("Mobile number must be filled"); //display Error message
        return false;
    }

    else if (password == "" || password == undefined) {
        displayErrorMsgModal("Password must be filled"); //display Error message
        return false;
    }

    else if (addFleetManagerDriverSelect == "" || addFleetManagerDriverSelect == undefined) {
        displayErrorMsgModal("Please select driver"); //display Error message
        return false;
    } else if (addBranchSelect == "" || addBranchSelect == undefined) {
        displayErrorMsgModal("Please select branch"); //display Error message
        return false;
    } else if (addFleetManagerCompanySelect == "" || addFleetManagerCompanySelect == undefined) {
        displayErrorMsgModal("Please select company"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addUserBtn").prop("disabled", true);

        var formData = {
            "password": password,
            "fullName": fullName,
            "email": email,
            "phoneNumber": phoneNumber,
            "user_id": user_id,
            "addFleetManagerDriverSelect": addFleetManagerDriverSelect,
            "addBranchSelect": addBranchSelect,
            "addFleetManagerCompanySelect": addFleetManagerCompanySelect
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addFleetManagerApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addUserBtn").removeAttr('disabled');

                location.reload();
                $('#addUserModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addUserBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            //show the error message
            $("#addUserBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// Query admin forms Data
function getAdminUsersData() {
    var data_table = null;

    $('appUsersDataTable').DataTable().destroy();

    data_table = $('#appUsersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFleetManagersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-user-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit user'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-user-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete user'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}


//EDIT ADMIN USER ROLE
$(document).on('click', '[data-user-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-user-edit'));

    $('#displayEditUserName').html(toTitleCase(jsonDetails.name));
    $('#editFullName').val(jsonDetails.name);

    $('#editFleetManagerCompanySelect').val(jsonDetails.customer_id);
    $('#editFleetManagerCompanyBranchSelect').val(jsonDetails.branch_id);

    $('#editFleetManagerCompanySelect').change();

    show_loader();

    // hold process
    setTimeout(function () {
        $('#editFleetManagerCompanyBranchSelect').change();
    }, 3000);

    //hold process to allow the function set data
    setTimeout(function () {
        hide_loader();
        if (jsonDetails.drivers_selected == null || jsonDetails.drivers_selected == "" || jsonDetails.drivers_selected == undefined) {
            // do nothing
        } else {

            var hidValue = jsonDetails.drivers_selected;

            var selectedOptions = hidValue.split(",");
            for (var i in selectedOptions) {
                var optionVal = selectedOptions[i];
                $(".edit_fleet_manager_driver_picker").find("option[value=" + optionVal + "]").prop("selected", "selected");
            }
            $('.edit_fleet_manager_driver_picker').selectpicker('refresh')

        }
        $('#editUserModal').modal('show');
    }, 5000);




    // edit user fullName here

    $("#editUserBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var fullName = $.trim($('#editFullName').val());
        var addFleetManagerCompanySelect = $.trim($('#editFleetManagerCompanySelect').val());
        var addBranchSelect = $.trim($('#editFleetManagerCompanyBranchSelect').val());
        var addFleetManagerDriverSelect = $.trim($('#editFleetManagerDriverSelect').val());

        if (fullName == "" || fullName == undefined) {
            displayErrorMsgModal("Please enter full name"); //display Error message
            return false;
        }

        else if (addFleetManagerDriverSelect == "" || addFleetManagerDriverSelect == undefined) {
            displayErrorMsgModal("Please select driver"); //display Error message
            return false;
        } else if (addBranchSelect == "" || addBranchSelect == undefined) {
            displayErrorMsgModal("Please select branch"); //display Error message
            return false;
        } else if (addFleetManagerCompanySelect == "" || addFleetManagerCompanySelect == undefined) {
            displayErrorMsgModal("Please select company"); //display Error message
            return false;
        }

        else {

            $("#editUserBtn").prop("disabled", true);
            var formData = {
                "user_id": jsonDetails.user_id,
                "fullName": fullName,
                "addFleetManagerDriverSelect": addFleetManagerDriverSelect,
                "addBranchSelect": addBranchSelect,
                "addFleetManagerCompanySelect": addFleetManagerCompanySelect
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: editFleetManagerApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editUserBtn").removeAttr('disabled');

                    $('#editUserModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                    location.reload();

                }

                else {
                    $("#editUserBtn").removeAttr('disabled');

                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {

                //show the error message
                $("#editUserBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//DELETE ADMIN USER DATA
$(document).on('click', '[data-user-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-user-delete'));

    var formData = {
        "user_id": jsonDetails.user_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.name,
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
                url: deleteFleetManagerApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {

                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                    location.reload();
                }

                else {
                    hide_loader();

                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {

                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// This will make a call to get branches pertaining to a customer
function getCompanyBranches(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {

        // Clear the old data
        $('#addFleetManagerCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#editFleetManagerCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');
        return false;

    } else {
        //   lets get the voucher usage type
        show_modal_loader();

        var formData = {
            "customerId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getCustomerBranchesApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                // Clear the old data
                $('#addFleetManagerCompanyBranchSelect')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Branch </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');         

                // // Clear the old data
                // $('#editFleetManagerCompanyBranchSelect')
                //     .find('option')
                //     .remove()
                //     .end()
                //     .append('<option value="">Select Branch </option>')
                //     .val('')
                // // .append('<option value="new">New Supplier</option>')
                // // .val('new');              

                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata", allData);
                    var select = $('#addFleetManagerCompanyBranchSelect');
                    var select2 = $('#editFleetManagerCompanyBranchSelect');

                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select2.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));

                    }

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);


            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer branches");
        });

    }
}

// This will make a call to get drivers pertaining to a branch
function getCompanyBranchesDrivers(selectedValue) {
    var value = selectedValue.value;

    // console.log("selected branchhh-->  ", value);

    if (value == "" || value == undefined || value == null) {
        // Clear the old data
        $('#addFleetManagerDriverSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select driver </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#editFleetManagerDriverSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select driver </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');
        return false;


    } else {
        //   lets get the voucher usage type
        show_modal_loader();

        var formData = {
            "branchId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getCustomerBranchesDriversApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata maannn", allData);

                    // Clear the old data
                    $('#editFleetManagerDriverSelect')
                        .find('option')
                        .remove()
                        .end()
                        
                    // .append('<option value="new">New Supplier</option>')
                    // .val('new');

                    var select = $('#addFleetManagerDriverSelect');
                    var select2 = $('#editFleetManagerDriverSelect');

                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
                        select2.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));

                    }

                    $('.select_fleet_manager_driver_picker').selectpicker();
                    $('.edit_fleet_manager_driver_picker').selectpicker();

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);

            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer branches");
        });

    }
}