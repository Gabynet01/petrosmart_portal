var addPetrosmartWalletApi = "/addPetrosmartWalletApi";

$(document).ready(function () {
    getOmcData();
    getCountriesArray();
});

// Query OMC forms Data
function getOmcData() {
    var data_table = null;

    $('omcFormDataTable').DataTable().destroy();

    data_table = $('#omcFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getOmcDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'country_chosen', name: 'country_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-omc-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit omc'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-omc-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete omc'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

/** ADD OMC API **/
$("#addOmcBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addOmcName = $.trim($('#addOmcName').val());
    var addOmcAddress = $.trim($('#addOmcAddress').val());
    var addOmcCountry = $.trim($('#addOmcCountry').val());


    if (addOmcName == "" || addOmcName == undefined) {
        displayErrorMsgModal("Please enter OMC name"); //display Error message
        return false;
    }
    else if (addOmcAddress == "" || addOmcAddress == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    }
    else if (addOmcCountry == "" || addOmcCountry == undefined) {
        displayErrorMsgModal("Please select country"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addOmcBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addOmcName": addOmcName,
            "addOmcAddress": addOmcAddress,
            "addOmcCountry": addOmcCountry
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartOmcApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addOmcBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'omcTab');

                // console.log(data);
                location.reload();

                $('#addOmcModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addOmcBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addOmcBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// handle omc button
$(document).on('click', '[data-omc-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-omc-edit'));

    $('#displayOmcName').html(toTitleCase(jsonDetails.name));
    $('#editOmcName').val(jsonDetails.name);
    $('#editOmcAddress').val(jsonDetails.address);
    $('#editOmcCountry').val(jsonDetails.country);

    $('#editOmcModal').modal('show');

    /** Edit OMC API **/
    $("#editOmcBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addOmcName = $.trim($('#editOmcName').val());
        var addOmcAddress = $.trim($('#editOmcAddress').val());
        var addOmcCountry = $.trim($('#editOmcCountry').val());


        if (addOmcName == "" || addOmcName == undefined) {
            displayErrorMsgModal("Please enter OMC name"); //display Error message
            return false;
        }
        else if (addOmcAddress == "" || addOmcAddress == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        }
        else if (addOmcCountry == "" || addOmcCountry == undefined) {
            displayErrorMsgModal("Please select country"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editOmcBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.omc_id,
                "addOmcName": addOmcName,
                "addOmcAddress": addOmcAddress,
                "addOmcCountry": addOmcCountry
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartOmcApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editOmcBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'omcTab');

                    // console.log(data);
                    location.reload();

                    $('#editOmcModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editOmcBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editOmcBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE OMC DATA
$(document).on('click', '[data-omc-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-omc-delete'));

    var formData = {
        "deleteType": "omc",
        "deleteId": jsonDetails.omc_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.name + "?",
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
                    sessionStorage.setItem('tabToGoto', 'omcTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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