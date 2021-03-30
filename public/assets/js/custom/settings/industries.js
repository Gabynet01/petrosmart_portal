var addPetrosmartIndustryApi = "/addPetrosmartIndustryApi";

$(document).ready(function () {
    getIndustriesUsersData();
});

// Query industries forms Data
function getIndustriesUsersData() {
    var data_table = null;

    $('industriesFormDataTable').DataTable().destroy();

    data_table = $('#industriesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getIndustriesUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'industry_name', name: 'industry_name' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-industry-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit industry'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-industry-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete industry'><i class='ti-trash'></i></a>";

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

/** ADD INDUSTRY API **/
$("#addIndustryBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addIndustryName = $('#addIndustryName').val();

    if (addIndustryName == "" || addIndustryName == undefined) {
        displayErrorMsgModal("Industry name must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addIndustryBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addIndustryName": addIndustryName
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartIndustryApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addIndustryForm").reset();
                $("#addIndustryBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'industryTab');

                console.log(data);
                location.reload();

                $('#addIndustryModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addIndustryBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addIndustryBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


// handle industry button
$(document).on('click', '[data-industry-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-industry-edit'));

    $('#displayIndustryName').html(toTitleCase(jsonDetails.industry_name));
    $('#editIndustryName').val(jsonDetails.industry_name);

    $('#editIndustryModal').modal('show');

    /** EDIT INDUSTRY API **/
    $("#editIndustryBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addIndustryName = $('#editIndustryName').val();

        if (addIndustryName == "" || addIndustryName == undefined) {
            displayErrorMsgModal("Industry name must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editIndustryBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.industry_id,
                "addIndustryName": addIndustryName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartIndustryApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addIndustryForm").reset();
                    $("#editIndustryBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'industryTab');

                    // console.log(data);
                    location.reload();

                    $('#editIndustryModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editIndustryBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editIndustryBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });


});

//DELETE INDUSTRY DATA
$(document).on('click', '[data-industry-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-industry-delete'));

    var formData = {
        "deleteType": "industry",
        "deleteId": jsonDetails.industry_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.industry_name + "?",
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
                    sessionStorage.setItem('tabToGoto', 'industryTab');

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

