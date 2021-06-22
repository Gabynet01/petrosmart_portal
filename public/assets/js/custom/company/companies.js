var addPetrosmartCustomerApi = "/addPetrosmartCustomerApi";

$(document).ready(function () {
    getAdminUsersData();
    getCountriesArray();
    getIndustriesArray();
    getAllManagersArray();
});

// Get Company Data
function getAdminUsersData() {
    var data_table = null;

    $('appCustomersDataTable').DataTable().destroy();

    data_table = $('#appCustomersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getAdminUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'full_name', name: 'full_name' },
            { data: 'address', name: 'address' },
            { data: 'gps', name: 'gps' },
            { data: 'country_chosen', name: 'country_chosen' },
            { data: 'industry_chosen', name: 'industry_chosen' },
            { data: 'manager_chosen', name: 'manager_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-customer-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit customer'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-customer-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete customer'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}


/** ADD USER API **/

$("#addUserBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var full_name = $.trim($('#addFullname').val());
    var address = $.trim($('#addAddress').val());
    var industry = $.trim($('#addIndustry').val());
    var gps = $.trim($('#addGps').val());
    var country = $.trim($('#addCountry').val());
    var assignedManagers = $.trim($('#addManagerSelect').val());


    if ((full_name == "" || full_name == undefined) && (address == "" || address == undefined) && (industry == "" || industry == undefined)) {
        displayErrorMsgModal("All fields are required"); //display Error message
        return false;
    } else if (full_name == "" || full_name == undefined) {
        displayErrorMsgModal("Fullname must be filled"); //display Error message
        return false;
    } else if (address == "" || address == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    } else if (industry == "" || industry == undefined) {
        displayErrorMsgModal("Industry must be filled"); //display Error message
        return false;
    } else if (gps == "" || gps == undefined) {
        displayErrorMsgModal("GPS must be filled"); //display Error message
        return false;
    } else if (country == "" || country == undefined) {
        displayErrorMsgModal("Country must be filled"); //display Error message
        return false;
    } else if (assignedManagers.length == 0 || assignedManagers.length == undefined) {
        displayErrorMsgModal("Assign at least one manager"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addUserBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "address": address,
            "industry": industry,
            "full_name": full_name,
            "gps": gps,
            "country": country,
            "assignedManagers": assignedManagers,
            "app_user_id": user_id
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartCustomerApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addUserBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'customerTab');

                console.log(data);
                location.reload();

                $('#addUserModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addUserBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addUserBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// EDIT AND DELETE BUTTONS 

// handle branch button
$(document).on('click', '[data-customer-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-customer-edit'));

    $('#displayCustomerName').html(toTitleCase(jsonDetails.full_name));
    $('#editFullname').val(jsonDetails.full_name);
    $('#editAddress').val(jsonDetails.address);
    $('#editIndustry').val(jsonDetails.industry);
    $('#editGps').val(jsonDetails.gps);
    $('#editCountry').val(jsonDetails.country);

    //fetch all assigned managers 
    if (jsonDetails.assigned_managers == null || jsonDetails.assigned_managers == "" || jsonDetails.assigned_managers == undefined) {
        // do nothing
    } else {

        var hidValue = jsonDetails.assigned_managers;

        var selectedOptions = hidValue.split(",");
        for (var i in selectedOptions) {
            var optionVal = selectedOptions[i];
            $(".edit_manager_selected_picker").find("option[value=" + optionVal + "]").prop("selected", "selected");
        }
        $('.edit_manager_selected_picker').selectpicker('refresh')

    }


    $('#editUserModal').modal('show');

    /** EDIT USER API **/

    $("#editUserBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var user_id;
        var full_name = $('#editFullname').val();
        var address = $('#editAddress').val();
        var industry = $('#editIndustry').val();
        var gps = $('#editGps').val();
        var country = $('#editCountry').val();
        var assignedManagers = $.trim($('#editManagerSelect').val());

        if ((full_name == "" || full_name == undefined) && (address == "" || address == undefined) && (industry == "" || industry == undefined)) {
            displayErrorMsgModal("All fields are required"); //display Error message
            return false;
        } else if (full_name == "" || full_name == undefined) {
            displayErrorMsgModal("Fullname must be filled"); //display Error message
            return false;
        } else if (address == "" || address == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        } else if (industry == "" || industry == undefined) {
            displayErrorMsgModal("Industry must be filled"); //display Error message
            return false;
        } else if (gps == "" || gps == undefined) {
            displayErrorMsgModal("GPS must be filled"); //display Error message
            return false;
        } else if (country == "" || country == undefined) {
            displayErrorMsgModal("Country must be filled"); //display Error message
            return false;
        }  else if (assignedManagers.length == 0 || assignedManagers.length == undefined) {
            displayErrorMsgModal("Assign at least one manager"); //display Error message
            return false;
        } else {
            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editUserBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.cust_id,
                "address": address,
                "industry": industry,
                "full_name": full_name,
                "gps": gps,
                "country": country,
                "assignedManagers": assignedManagers,
                "app_user_id": user_id
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartCustomerApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editUserBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerTab');

                    console.log(data);
                    location.reload();

                    $('#editUserModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editUserBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editUserBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE CUSTOMER DATA
$(document).on('click', '[data-customer-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-customer-delete'));

    var formData = {
        "deleteType": "customer",
        "deleteId": jsonDetails.cust_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.full_name + "?",
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
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerTab');

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