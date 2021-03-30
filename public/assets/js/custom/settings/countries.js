var addPetrosmartCountryApi = "/addPetrosmartCountryApi";

$(document).ready(function () {
    getCountriesUsersData();
});

// Query contact forms Data
function getCountriesUsersData() {
    var data_table = null;

    $('countriesFormDataTable').DataTable().destroy();

    data_table = $('#countriesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getCountriesUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'country', name: 'country' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-country-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit country'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-country-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete country'><i class='ti-trash'></i></a>";

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

/** ADD COUNTRY API **/
$("#addCountryBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCountryName = $('#addCountryName').val();

    if (addCountryName == "" || addCountryName == undefined) {
        displayErrorMsgModal("Country name must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addCountryBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCountryName": addCountryName
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartCountryApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addCountryForm").reset();
                $("#addCountryBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'countryTab');

                console.log(data);
                location.reload();

                $('#addCountryModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addCountryBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addCountryBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// handle country button
$(document).on('click', '[data-country-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-country-edit'));

    $('#displayCountryName').html(toTitleCase(jsonDetails.country));
    $('#editCountryName').val(jsonDetails.country);

    $('#editCountryModal').modal('show');


    /** EDIT COUNTRY API **/
    $("#editCountryBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCountryName = $('#editCountryName').val();

        if (addCountryName == "" || addCountryName == undefined) {
            displayErrorMsgModal("Country name must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editCountryBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.ccountry_id,
                "addCountryName": addCountryName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartCountryApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addCountryForm").reset();
                    $("#editCountryBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'countryTab');

                    // console.log(data);
                    location.reload();

                    $('#editCountryModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editCountryBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editCountryBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });





});

//DELETE COUNTRY DATA
$(document).on('click', '[data-country-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-country-delete'));

    var formData = {
        "deleteType": "country",
        "deleteId": jsonDetails.ccountry_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.country + "?",
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
                    sessionStorage.setItem('tabToGoto', 'countryTab');

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