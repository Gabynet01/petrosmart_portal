var addPetrosmartWalletApi = "/addPetrosmartWalletApi";

$(document).ready(function () {
    getWalletUsersData();
    getCustomersArray();

});

// Query wallet forms Data
function getWalletUsersData() {
    var data_table = null;

    $('walletsFormDataTable').DataTable().destroy();

    data_table = $('#walletsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getWalletUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'telco', name: 'telco' },
            { data: 'wallet_num', name: 'wallet_num' },
            { data: 'authorization_key', name: 'authorization_key' },
            { data: 'merchant_token', name: 'merchant_token' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-wallet-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit wallet'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-wallet-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete wallet'><i class='ti-trash'></i></a>";

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
/** ADD WALLET API **/
$("#addWalletBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCompanyWallet = $.trim($('#addCompanyWallet').val());
    var addBranchSelect = $.trim($('#addWalletBranchSelect').val());
    var addTelco = $.trim($('#addTelco').val());
    var addWalletNum = $.trim($('#addWalletNum').val());
    var addAuthKey = $.trim($('#addAuthKey').val());
    var addMerchantToken = $.trim($('#addMerchantToken').val());

    if (addCompanyWallet == "" || addCompanyWallet == undefined) {
        displayErrorMsgModal("Please select a company"); //display Error message
        return false;
    }

    if (addBranchSelect == "" || addBranchSelect == undefined) {
        displayErrorMsgModal("Please select a branch"); //display Error message
        return false;
    } else if (addTelco == "" || addTelco == undefined) {
        displayErrorMsgModal("Please select a Telco"); //display Error message
        return false;
    } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
        displayErrorMsgModal("Wallet Number must be filled"); //display Error message
        return false;
    } else if (addAuthKey == "" || addAuthKey == undefined) {
        displayErrorMsgModal("Authorization key must be filled"); //display Error message
        return false;
    } else if (addMerchantToken == "" || addMerchantToken == undefined) {
        displayErrorMsgModal("Merchant Token must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addWalletBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCompanyWallet": addCompanyWallet,
            "addBranchSelect": addBranchSelect,
            "addTelco": addTelco,
            "addWalletNum": addWalletNum,
            "addAuthKey": addAuthKey,
            "addMerchantToken": addMerchantToken
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartWalletApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addWalletForm").reset();
                $("#addWalletBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'walletTab');

                console.log(data);
                location.reload();

                $('#addWalletModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addWalletBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addWalletBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// handle wallets button
$(document).on('click', '[data-wallet-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-wallet-edit'));

    $('#displayWalletName').html(toTitleCase(jsonDetails.wallet_num));
    $('#editCompanyWallet').val(jsonDetails.customer_selected);
    $('#editWalletBranchSelect').val(jsonDetails.custb_id);
    $('#editTelco').val(jsonDetails.telco);
    $('#editWalletNum').val(jsonDetails.wallet_num);
    $('#editAuthKey').val(jsonDetails.authorization_key);
    $('#editMerchantToken').val(jsonDetails.merchant_token);

    $('#editCompanyWallet').change();

    $('#editWalletModal').modal('show');

    /** EDIT WALLET API **/
    $("#editWalletBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCompanyWallet = $.trim($('#editCompanyWallet').val());
        var addBranchSelect = $.trim($('#editWalletBranchSelect').val());
        var addTelco = $.trim($('#editTelco').val());
        var addWalletNum = $.trim($('#editWalletNum').val());
        var addAuthKey = $.trim($('#editAuthKey').val());
        var addMerchantToken = $.trim($('#editMerchantToken').val());

        if (addBranchSelect == "" || addBranchSelect == undefined) {
            displayErrorMsgModal("Please select a branch"); //display Error message
            return false;
        } else if (addTelco == "" || addTelco == undefined) {
            displayErrorMsgModal("Please select a Telco"); //display Error message
            return false;
        } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
            displayErrorMsgModal("Wallet Number must be filled"); //display Error message
            return false;
        } else if (addAuthKey == "" || addAuthKey == undefined) {
            displayErrorMsgModal("Authorization key must be filled"); //display Error message
            return false;
        } else if (addMerchantToken == "" || addMerchantToken == undefined) {
            displayErrorMsgModal("Merchant Token must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editWalletBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custw_id,
                "addCompanyWallet": addCompanyWallet,
                "addBranchSelect": addBranchSelect,
                "addTelco": addTelco,
                "addWalletNum": addWalletNum,
                "addAuthKey": addAuthKey,
                "addMerchantToken": addMerchantToken
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartWalletApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addWalletForm").reset();
                    $("#editWalletBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'walletTab');

                    // console.log(data);
                    location.reload();

                    $('#editWalletModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editWalletBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editWalletBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });




});

//DELETE WALLET DATA
$(document).on('click', '[data-wallet-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-wallet-delete'));

    var formData = {
        "deleteType": "wallet",
        "deleteId": jsonDetails.custw_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.wallet_num + "?",
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
                    sessionStorage.setItem('tabToGoto', 'walletTab');

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