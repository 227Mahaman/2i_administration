host = $(location).attr('hostname');
protocol = $(location).attr('protocol');
folder = '';
if (host == 'localhost') {
    folder = '/slim3';
}
//myurl= "http://localhost/2i_administration/";
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
    $mr = getDataWith2Param('profil_has_action', 'id_action', $(v).val(), 'id_profil', $_GET['profil']);

    $mr.done(function ($mr) {
        console.log($mr, "res");
        if ($mr.length!=0) {//Si le menu existe pour le profil
            $(v).attr('checked', true);
        }
    });

    $mr.fail(function ($mr) {
        $(v).attr('checked', false);

    });
});




function addMenuRole(chec) {
    $data = "id_profil=" + $_GET['role'] + "&id_action=" + $(chec).val();
    //$data = JSON.stringify($($data).serializeObject());
    $mr = getDataWith2Param('profil_has_action', 'id_action', $(chec).val(), 'id_profil', $_GET['role']);
    console.log($data, $mr, "ci");
    if ($(chec).prop('checked') == true) {
        $mr.done(function ($mr) {
            console.log($mr, $mr.length==0);
            if ($mr.length==0) {
                console.log($mr, $mr.length==0);
                $.ajax({
                    url: myurl + "addMenuToProfilAjax",
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
            console.log($mr, $mr.length==0);
            $.ajax({
                url: myurl + "addMenuToProfilAjax",
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
        deleteDataWith2Param('profil_has_action', 'id_action', $(chec).val(), 'id_profil', $_GET['role']);
    }
}

function getModuleRole() {

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