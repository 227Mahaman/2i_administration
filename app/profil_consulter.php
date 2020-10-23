<?php
include_once("controle_session.php");
include_once("profil_db_manager.php");
require_once '../security.php';
include_once("../connexion/connexion.php");

//enregistrement des données du formulaire dans la base
if (isset($_POST['bouton_envoyer'])) {
$libelle_profil = echapper($_POST['libelle_profil']);

$id_user_conn = $_SESSION['id_user'];
$date = date("Y-m-d H:i:s");

$result = insert_profil($libelle_profil, $id_user_conn, $date);

if ($result == true) {
//recuperation de l'id du profil créé
$records = $pdo->query("SELECT max(id_profil) as id_profil
FROM profil
WHERE libelle_profil='$libelle_profil' ");
$row_id_profil = $records->fetch();
$id_profil = $row_id_profil['id_profil'];

//redirection vers la page de definition des privileges des profils
header("location:profil_definir_action.php?id_profil=$id_profil&libelle_profil=$libelle_profil");
} else {
$msg = "Echec de l'enregistrement, veuillez reprendre svp.";
header("location:profil_nouveau.php?msg=$msg&type_msg=0");
//on arrête l'exécution s'il y a du code après
exit();
}
}//fin if isset bouton_enregistrer


//enregistrement des modifications des actions definis
if(isset($_POST['bouton_modifier'])){
$id_profil = $_POST['id_profil'];
$libelle_profil = $_POST['libelle_profil3'];
$liste_action = $_POST['liste_action'];
$nbr_action_coche = sizeof($liste_action);

$id_user_conn = $_SESSION['id_user'];
$date = date("Y-m-d H:i:s");

//update du libelle profil
update_profil($id_profil, $libelle_profil, $id_user_conn, $date);

try
{
$pdo->beginTransaction();
//suppression des anciens privileges avant d'insérer les nouveaux
$pdo->exec("DELETE FROM profil_has_action WHERE id_profil=$id_profil");

//on insere les nouveaux privileges definis
for($i=0; $i<$nbr_action_coche; $i++){
$id_action = $liste_action[$i];
$pdo->exec("INSERT INTO profil_has_action(id_profil, id_action) VALUES ($id_profil, $id_action)");
}//fin for
$pdo->commit();

$msg = "Enregistré avec succès.";
header("location:profil_consulter.php?msg=$msg&type_msg=1");

}
catch(Exception $e) //en cas d'erreur
{
//on annule la transation
$pdo->rollback();

$msg = "Echec de l'enregistrement, veuillez reprendre svp.";
header("location:profil_consulter.php?msg=$msg&type_msg=0");
//on arrête l'exécution s'il y a du code après
exit();
}

}//fin if isset bouton_envoyer

// ENTETE
$titre = "Liste des profils";
include 'include/entete.php';
?>

<!-- container body -->
<div class="container body">
<!--main_container-->
<div class="main_container">
<?php include_once("menu.php"); ?>
<!-- Page Content -->
<div class="right_col" role="main">
<ul class="breadcrumb" style="margin-left: 25px">
<li> <span class="fa fa-file-text"></span>&nbsp; Profil</li>
<li><span class="fa fa-bars"></span>&nbsp; consulter</li>
</ul>
<?php include '../message_confirmation.php'; ?>
<div class="row table-responsive"> <!-- div bloc statistics -->
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>
<i class="fa fa-bars"></i>&nbsp;Liste des profils
</h2>
<ul class="nav navbar-right panel_toolbox">
<li>
<!--***********************************************************
*****************AJOUTER UN PROFIL**********************-->
<button class="btn btn-success  btn-xs  navbar-right" type="button"
data-toggle="modal" data-target=".bs-example-modal-lg">
<span class="fa fa-plus-square" style="color: #FFFFFF"></span> Nouveau profil
</button>
<div tabindex="-1" class="modal fade bs-example-modal-sm bs-example-modal-lg" role="dialog" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header BackCollor">
    <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">Ajouter un profil</h4>
</div>
<div class="modal-body">
    <form id="demo-form2 form1" data-parsley-validate class="form-horizontal form-label-left reciept2"
            action="profil_consulter.php" name="form1" method="post">
        <div class="form-group has-feedback">
            <div class="col-md-4 col-sm-4 col-xs-12 col-sm-offset-4" style="padding-top:8px">
                <!--======================================================
                    ===============LIBELLE  PROFIL=================
                    ======================================================-->
                <label class="col-md-8 col-sm-8 col-xs-12">
                    Nom du profil
                    <em style="color:#d7082b">*</em>
                </label>
                <span class="fa fa-user form-control-feedback left "
                        aria-hidden="true">
                </span>
                <input type="text" id="libelle_profil" required="required"
                        class="form-control has-feedback-left"
                        style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                        name="libelle_profil" placeholder="Entrez le nom du profil">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-dark btn-xs navbar-left" type="button" data-dismiss="modal">
                <span class="fa fa-times" style="color: #FFFFFF"></span>
                Fermer
            </button>
            <button class="btn btn-primary btn-xs" type="reset">
                <span class="fa fa-refresh" style="color: #FFFFFF"></span>
                Réinitialiser
            </button>
            <button type="submit" id="bouton_envoyer" name="bouton_envoyer"
                    class="btn btn-success btn-xs">
                <span class="glyphicon glyphicon-floppy-save" style="color: #FFFFFF"></span>
                Soumettre
            </button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</li>
<li>
<a class="collapse-link">
<i class="fa fa-chevron-up"></i>
</a>
</li>
</ul>
<div class="clearfix"></div>
<form class="x_content" action="#" id="form_search" name="form_search" method="post">
<br />
<table class='table table-striped table-condensed' style="margin-left:0px">
<tr>
<td>
<label class="col-md-6 col-sm-6 col-xs-12">
<span class="glyphicon glyphicon-option-vertical"></span> Nom du profil
</label>
</td>
</tr>
<tr class="reciept">
<div class="form-group has-feedback">
<td>
<!--==================================================
    ======================NOM PROFIL=============
    ======================================================-->
<div class="col-md-3 col-sm-3 col-xs-12" style="padding-top: 8px">
        <span class="fa fa-user form-control-feedback left"
            aria-hidden="true">
        </span>
    <input type="text" id="libelle_profil2" required="required"
            class="form-control has-feedback-left" style="height: 23px;width:250px;border-radius: 3px 3px 3px 3px;padding-top:1px"
            name="libelle_profil2" placeholder="Entrez le nom  du profil">
</div>
<div class="col-md-3 col-sm-3 col-xs-12" style="padding-top:9px">
    <button class="btn btn-info btn-xs" id="btn_search" name="btn_search" type="button">
        <span class="glyphicon glyphicon-search " style="color: #FFFFFF"></span> Rechercher
    </button>
</div>
</td>
</tr>
</tbody>
</table>
</form>
<!--div qui contiendra le tableau des données à afficher-->
<div id="page_data" class="x_content"></div>
<span class="flash"></span>
</div>
</div>

</div>
</div>
</div>
</div> <!-- fin div bloc statistics -->
</div>

<!--/main_container-->
</div>
<!--/container body-->
</div>

<script type="text/javascript">
$(document).ready(function(){
change_page('0');

//gestion du click du btn rechercher
$("#btn_search").click(function(){
var page_id = 0;
var libelle_profil2 = $("#libelle_profil2").val();

// au lancement de la fonction ajax
$(document).ajaxStart(function(){
$('.spinner').css('display','inline-table');
});

// au lancement de la fonction ajax
$(document).ajaxStop(function(){
$('.spinner').css('display','none');
});

var dataString = 'page_id='+page_id+'&libelle_profil2='+libelle_profil2;
$.ajax({
type: "POST",
url: "profil_load_data.php",
data: dataString,
cache: false,
success: function(result){
$(".flash").hide();
$("#page_data").html(result);
}
});//fin ajax
}); //fin click btn_search
});

function change_page(page_id){
var dataString = 'page_id='+ page_id;

// au lancement de la fonction ajax
$(document).ajaxStart(function(){
$('.spinner').css('display','inline-table');
});

// au lancement de la fonction ajax
$(document).ajaxStop(function(){
$('.spinner').css('display','none');
});

$.ajax({
type: "POST",
url: "profil_load_data.php",
data: dataString,
cache: false,
success: function(result){
$(".flash").hide();
$("#page_data").html(result);
}
});
} //fin fonction change_page
</script>

<!-- PIED DE LA PAGE -->
<?php include 'include/pied.php';?>
