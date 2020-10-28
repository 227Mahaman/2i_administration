host = $(location).attr('hostname');
protocol = $(location).attr('protocol');
folder = '';
if (host == 'localhost') {
    folder = '/2i_administration';
}
myurl= "http://localhost/2i_administration/";
//Recuperer les données enget
var $_GET = {};
document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});
// getPermission();
$('input:checkbox.module_is_checked').each(function (i, v) {
    // $mr = getDataWith2Param('profil_has_action', 'id_action', $(v).val(), 'id_profil', $_GET['profil']);
    $data = "id_profil=" + $_GET['profil'] + "&id_action=" + $(v).val();
    $mr = $.ajax({
        url: myurl+"/app/ajax/getMenuRole.php?"+$data,
        type: "GET",
        contentType: 'application/json',
        dataType: "json",
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
    $mr.done(function ($mr) {
        console.log($mr, "res");
        if (!$mr.error) {//Si le menu existe pour le profil
            $(v).attr('checked', true);
        }
    });

    $mr.fail(function ($mr) {
        $(v).attr('checked', false);

    });
});




function addMenuRole(chec) {
    $data = "id_profil=" + $_GET['profil'] + "&id_action=" + $(chec).val();
    //$data = JSON.stringify($($data).serializeObject());
    $mr =  $.ajax({
        url: myurl+"/app/ajax/getMenuRole.php?"+$data,
        type: "GET",
        contentType: 'application/json',
        dataType: "json",
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
    // console.log($data, $mr, "ci");
    if ($(chec).prop('checked') == true) {
        $mr.done(function ($mr) {
            
            if (!$mr.error) {
                console.log($mr, $mr.error);
                $.ajax({
                    url: myurl + "handleMenuRole.php?action=add",
                    type: "POST",
                    contentType: 'application/x-www-form-urlencoded',
                    dataType: "json",
                    data: $data,
                    success: function (result) {
                        console.log(result);
                    },
                    error: function (xhr, resp, text) {
                        // show error to console
                        console.log(xhr, resp, text);
                    }
                });
            }
        });

        $mr.fail(function ($mr) {
            console.log($mr, $mr.error);
            $.ajax({
                url: myurl + "app/ajax/handleMenuRole.php?action=add",
                type: "POST",
                contentType: 'application/x-www-form-urlencoded',
                dataType: "json",
                data: $data,
                success: function (result) {
                    console.log(result);
                },
                error: function (xhr, resp, text) {
                    // show error to console
                    console.log(xhr, resp, text);
                }
            });
        });
    } else {
        $.ajax({
            url: myurl + "app/ajax/handleMenuRole.php?action=delete",
            type: "POST",
            contentType: 'application/x-www-form-urlencoded',
            dataType: "json",
            data: $data,
            success: function (result) {
                console.log(result);
            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
    }
}

function getDataWith2Param(table, field, value, $field2, $value2) {
    console.log(myurl + table + '/' + field + '/' + value + '/' + $field2 + '/' + $value2);

    return $.ajax({
        url: myurl + table + '/' + field + '/' + value + "/" + $field2 + "/" + $value2,
        type: "GET",
        contentType: 'application/json',
        dataType: "json",
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
}

function deleteDataWith2Param(table, field, value, $field2, $value2) {
    return $.ajax({
        url: myurl + table + '/' + field + '/' + value + "/" + $field2 + "/" + $value2,
        type: "POST",
        contentType: 'application/json',
        dataType: "json",
        error: function (xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
}

/**
 * Hides "Please wait" overlay. See function showPleaseWait().
 */
function hidePleaseWait() {
    $("#pleaseWaitDialog").modal("hide");
}