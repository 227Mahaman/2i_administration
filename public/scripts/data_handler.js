host = $(location).attr('hostname');
protocol = $(location).attr('protocol');
folder = '';
if (host == 'localhost') {
    folder = '/2i_administration';
}
myurl= "http://localhost/2i_administration/";
//Recuperer les données GET
var $_GET = {};
document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});
$('input:checkbox.module_is_checked').each(function (i, v) {
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



/**
 * Fonction d'ajout et de suppression de menu
 * @param {*} chec 
 */
function addMenuRole(chec) {
    $data = "id_profil=" + $_GET['profil'] + "&id_action=" + $(chec).val();
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
    
    if ($(chec).prop('checked') == true) {
        
        $mr.done(function ($mr) {
            console.log($data, $mr, "ci");
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

        $mr.fail(function ($mr) {//Ajout du menu
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
    } else {//Delete Menu
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
/**
 * Hides "Please wait" overlay. See function showPleaseWait().
 */
function hidePleaseWait() {
    $("#pleaseWaitDialog").modal("hide");
}