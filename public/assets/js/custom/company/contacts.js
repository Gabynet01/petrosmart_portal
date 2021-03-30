var addPetrosmartContactApi = "/addPetrosmartContactApi";

$(document).ready(function () {
    getContactUsersData();
    getCustomersArray();
});

// Query contact forms Data
function getContactUsersData() {
    var data_table = null;

    $('contactsFormDataTable').DataTable().destroy();

    data_table = $('#contactsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getContactUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'email', name: 'email' },
            { data: 'tel', name: 'tel' },
            { data: 'mob', name: 'mob' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-contact-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit contact'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-contact-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete contact'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

/** ADD CONTACT API **/
$("#addContactBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCustomerContact = $('#addCustomerContact').val();
    var addEmailContact = $('#addEmailContact').val();
    var addTelephoneContact = $('#addTelephoneContact').val();
    var addMobileContact = $('#addMobileContact').val();

    if (addCustomerContact == "" || addCustomerContact == undefined) {
        displayErrorMsgModal("Please select a customer"); //display Error message
        return false;
    } else if (addEmailContact == "" || addEmailContact == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    } else if (addTelephoneContact == "" || addTelephoneContact == undefined || addTelephoneContact == NaN) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    } else if (addMobileContact == "" || addMobileContact == undefined || addMobileContact == NaN) {
        displayErrorMsgModal("Mobile must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addContactBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCustomerContact": addCustomerContact,
            "addEmailContact": addEmailContact,
            "addTelephoneContact": addTelephoneContact,
            "addMobileContact": addMobileContact
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartContactApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addContactForm").reset();
                $("#addContactBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'contactTab');

                console.log(data);
                location.reload();

                $('#addContactModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addContactBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addContactBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// handle contact button
$(document).on('click', '[data-contact-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-contact-edit'));

    $('#displayContactName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editCustomerContact').val(jsonDetails.full_name);
    $('#editEmailContact').val(jsonDetails.email);
    $('#editTelephoneContact').val(jsonDetails.tel);
    $('#editMobileContact').val(jsonDetails.mob);

    $('#editContactModal').modal('show');

    /** EDIT CONTACT API **/
    $("#editContactBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCustomerContact = $('#editCustomerContact').val();
        var addEmailContact = $('#editEmailContact').val();
        var addTelephoneContact = $('#editTelephoneContact').val();
        var addMobileContact = $('#editMobileContact').val();

        if (addCustomerContact == "" || addCustomerContact == undefined) {
            displayErrorMsgModal("Please select a customer"); //display Error message
            return false;
        } else if (addEmailContact == "" || addEmailContact == undefined) {
            displayErrorMsgModal("Email must be filled"); //display Error message
            return false;
        } else if (addTelephoneContact == "" || addTelephoneContact == undefined || addTelephoneContact == NaN) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        } else if (addMobileContact == "" || addMobileContact == undefined || addMobileContact == NaN) {
            displayErrorMsgModal("Mobile must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editContactBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custc_id,
                "addCustomerContact": addCustomerContact,
                "addEmailContact": addEmailContact,
                "addTelephoneContact": addTelephoneContact,
                "addMobileContact": addMobileContact
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartContactApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addContactForm").reset();
                    $("#editContactBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'contactTab');

                    // console.log(data);
                    location.reload();

                    $('#editContactModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editContactBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editContactBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });




});

//DELETE CONTACT DATA
$(document).on('click', '[data-contact-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-contact-delete'));

    var formData = {
        "deleteType": "contact",
        "deleteId": jsonDetails.custc_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.customer_chosen + "?",
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
                    sessionStorage.setItem('tabToGoto', 'contactTab');

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
