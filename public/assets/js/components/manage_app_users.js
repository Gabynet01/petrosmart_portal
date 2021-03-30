var addAdminUserApi = "/addAdminUserApi";
var editAdminUserApi = "/editAdminUserApi";
var deleteAdminUserApi = "/deleteAdminUserApi";

$(document).ready(function () {
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

    if (email == "" || email == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    }

    else if (password == "" || password == undefined) {
        displayErrorMsgModal("Password must be filled"); //display Error message
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
            "user_id": user_id,
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addAdminUserApi,
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
            url: '/getOmcUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
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

    $('#editUserModal').modal('show');

    // edit user fullName here

    $("#editUserBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var fullName = $.trim($('#editFullName').val());

        if (fullName == "" || fullName == undefined) {
            displayErrorMsgModal("Please enter full name"); //display Error message
            return false;
        }

        else {

            $("#editUserBtn").prop("disabled", true);
            var formData = {
                "user_id": jsonDetails.user_id,
                "fullName": fullName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: editAdminUserApi,
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
                url: deleteAdminUserApi,
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