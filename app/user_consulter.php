<?php
    include_once("controle_session.php");
    include_once("../connexion/connexion.php");
    include_once("user_db_manager.php");
    require_once '../security.php';

    // appel de certaines fonctions de certaines petites taches
    include_once("../fonction/fonctions.php");

    // fonction qui permet de controler le droit d'acces a la page
    verifier_droit_page();

    //enregistrement des données du formulaire dans la base
  if (isset($_POST['bouton_envoyer'])) {
    $id_profil = echapper($_POST['id_profil']);
    $nom = echapper($_POST['nom']);
    $prenom = echapper($_POST['prenom']);
    $login = echapper($_POST['login']);
    $password = echapper($_POST['password']);
    $password2 = echapper($_POST['password2']);

    $id_user_conn = $_SESSION['id_user'];
    $date = date("Y-m-d H:i:s");
    if($password==$password2){
        $result = insert_user($id_profil, $nom, $prenom, $login, md5($password), $id_user_conn, $date);

        if ($result == true) {
            $msg = "Enregistré avec succès!";
            header("location:user_consulter.php?msg=$msg&type_msg=1");
        } else {
            $msg = "Echec de l'enregistrement, veuillez reprendre svp.";
            header("location:user_consulter.php?msg=$msg&type_msg=0");
            //on arrête l'exécution s'il y a du code après
            exit();
        }
    }else{
        $msg = "Echec de l'enregistrement,les deux mots de passe sont différents. veuillez reprendre svp.";
        header("location:user_consulter.php?msg=$msg&type_msg=0");
    }

}//fin if isset bouton_enregistrer


    //mis à jour des infos de user
    if(isset($_POST['bouton_modifier'])){
        $id_user = echapper($_POST['id_user']);
        $id_profil = echapper($_POST['id_profil']);
        $nom = echapper($_POST['nom']);
        $prenom = echapper($_POST['prenom']);
        $login = echapper($_POST['login']);
        $password = echapper($_POST['password_modifier']);
        $password2 = echapper($_POST['password2_modifier']);

        $id_user_conn = $_SESSION['id_user'];
        $date = date("Y-m-d H:i:s");

        if($password==$password2){
            $result = update_user($id_user, $id_profil, $nom, $prenom, $login, $password, $id_user_conn, $date);
            // $result = insert_user($id_profil, $nom, $prenom, $login, md5($password), $id_user_conn, $date);

            if ($result == true) {
                $msg = "Enregistré avec succès!";
                header("location:user_consulter.php?msg=$msg&type_msg=1");
            } else {
                $msg = "Echec de l'enregistrement, veuillez reprendre svp.";
                header("location:user_consulter.php?msg=$msg&type_msg=0");
                //on arrête l'exécution s'il y a du code après
                exit();
            }
        }else{
            $msg = "Echec de l'enregistrement,les deux mots de passe sont différents. veuillez reprendre svp.";
            header("location:user_consulter.php?msg=$msg&type_msg=0");
        }
    }//fin if isset bouton_enregistrer

    // ENTETE
    $titre = "Liste des utilisateurs";
    include 'include/entete.php';
?>


<div class="container body">
<!--main_container-->
<div class="main_container">
 <?php include_once("menu.php"); ?>
 <!-- Page Content -->
 <div class="right_col" role="main">
    <ul class="breadcrumb" style="margin-left: 25px">
        <li><span class="fa fa-user"></span>&nbsp;
            Utilisateur
        </li>
        <li><span class="fa fa-bars"></span>&nbsp;
            Liste
        </li>
    </ul>
   <?php include '../message_confirmation.php'; ?>
    <div class="row table-responsive"> <!-- div bloc statistics -->
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
        <h2>
            <i class="fa fa-bars"></i>&nbsp;
            Liste de tous les utilisateurs
        </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li>
            <!--***********************************************************
             *****************AJOUTER UN UTILISATEUR**********************-->
             <?php
                    if(verifier_droit_action('user_nouveau.php')):
                ?>
            <button class="btn btn-success  btn-xs  navbar-right" type="button"
                    data-toggle="modal" data-target=".bs-example-modal-lg">
                <span class="fa fa-plus-square" style="color: #FFFFFF"></span>
                Ajouter utilisateur
            </button>
            <?php endif;?>
            <div tabindex="-1" class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header BackCollor">
                            <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Nouvel utilisateur
                            </h4>
                        </div>
                        <div class="modal-body">
                                <form id="demo-form2 form1" data-parsley-validate class="form-horizontal form-label-left reciept2"
                                      action="user_consulter.php" name="form1" method="post">
                                    <div class="form-group has-feedback">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2" style="padding-top: 8px">
                                            <!--==================================================
                                            ======================NOM============================
                                            ======================================================-->
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                                Nom utilisateur
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-male form-control-feedback left" aria-hidden="true">
                                            </span>
                                            <input type="text"  required="required"
                                                class="form-control has-feedback-left"
                                                name="nom" placeholder="Entrez le nom"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                        </div>
                                        <!--=====================================================
                                           ======================PRENOM=============================
                                           ======================================================-->
                                        <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                                Prénom utilisateur
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-male form-control-feedback right" aria-hidden="true">
                                            </span>
                                            <input type="text"  name="prenom" required
                                                class="form-control has-feedback-left"
                                                placeholder="Entrez le prénom de l'utilisateur"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                        </div>
                                    </div>
                                    <!--======================================================
                                       ======================LOGIN============================
                                       ======================================================-->
                                    <div class="form-group has-feedback">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2" style="padding-top: 8px">
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                                Login de l'utilisateur
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-user form-control-feedback left" aria-hidden="true">
                                            </span>
                                            <input type="text" id="login" name="login"
                                                required class="form-control has-feedback-left"
                                                placeholder="Entrez le login de l'utilisateur"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                        </div>
                                        <!--======================================================
                                            ======================MOT DE PASSE===================
                                            ======================================================-->
                                        <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                                Mot de passe
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-lock form-control-feedback right" aria-hidden="true">
                                            </span>
                                            <input type="password" id="password" name="password"
                                                required class="form-control has-feedback-left"
                                                placeholder="Entrez le mot de passe"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                            <b id="pass"></b>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2" style="padding-top: 8px">
                                            <!--******************************************
                                                   *****************PROFIL*******************
                                              ******************************************-->
                                            <label class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                                                Profil
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-user form-control-feedback left"
                                                  aria-hidden="true">
                                            </span>
                                            <?php
                                            //recuperation de la liste des profils user
                                            $sql = "SELECT id_profil, libelle_profil FROM profil WHERE true order by libelle_profil";
                                            $result_profil = $pdo->query($sql);
                                            ?>
                                            <select name="id_profil" id="id_profil" class="form-control"
                                                    required style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:2px">
                                                <option value="">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    --- Choisir le profil ---
                                                </option>
                                                <?php
                                                foreach ($result_profil as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['id_profil']; ?>">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?php echo $row['libelle_profil']; ?>
                                                    </option>
                                                    <?php
                                                }//fin foreach
                                                ?>
                                            </select>
                                        </div>
                                        <!--******************************************
                                                *****************CONFIRMER LE MOT DE PASSE*************
                                             *******************************************-->
                                        <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                                            <label class="col-md-12 col-sm-12 col-xs-12">
                                                Mot de passe de confirmation
                                                <em style="color:#d7082b">*</em>
                                            </label>
                                            <span class="fa fa-lock form-control-feedback right"
                                                  aria-hidden="true">
                                            </span>
                                            <input type="password" id="password2"name="password2"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                                                required class="form-control has-feedback-left"
                                                placeholder="Entrez mot de passe de confirmation">
                                            <b id="pass2"></b>
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
                                            Enregistrer
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
        <table class='table table-striped jambo_table bulk_action reciept' style="margin-left:0px" >
            <tr >
                <td>
            <label class="col-md-4 col-sm-4 col-xs-12">
                <span class="glyphicon glyphicon-option-vertical"></span>
                Nom
            </label>
                </td>
                <td>
            <label class="col-md-4 col-sm-4 col-xs-12">
                <span class="glyphicon glyphicon-option-vertical"></span>
                Prénom
            </label>
                </td>
                <td>
            <label class="col-md-4 col-sm-4 col-xs-12">
                    <span class="glyphicon glyphicon-option-vertical"></span>
                    Profil
            </label>
                </td>
                <td>
                </td>
            </tr>
            <tr>
            <div class="form-group has-feedback">
                <td>
                <!--==================================================
                  ======================NOM============================
                  ======================================================-->
                <div class="col-xs-12" style="padding-top:8px">
                 <span class="fa fa-male form-control-feedback left" aria-hidden="true">
                  </span>
                    <input type="text" id="nom" required="required"
                        class="form-control has-feedback-left"
                        name="nom" placeholder="Entrez le nom"
                        style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                </div>
                </td>
                <td>
                <!--==================================================
                ======================PRENOM============================
                ======================================================-->
                <div class="col-xs-12" style="padding-top:8px">
                 <span class="fa fa-male form-control-feedback left"
                       aria-hidden="true">
                  </span>
                    <input type="search" id="prenom" name="prenom" required="required"
                        class="form-control has-feedback-left"
                        placeholder="Entrez le prénom"
                        style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                </div>
            </div>
                </td>
                <!--==================================================
                   ======================PROFIL============================
                   ======================================================-->
                <td>
            <div class="col-xs-12" style="padding-top:8px">
                     <span class="fa fa-user form-control-feedback left" aria-hidden="true">
                      </span>
                    <?php
                    //recuperation de la liste des profils user
                    $sql = "SELECT id_profil, libelle_profil FROM profil WHERE true order by libelle_profil";
                    $result_profil = $pdo->query($sql);
                    ?>
                    <select name="profil" id="profil" class="form-control" required  style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:2px">
                        <option value="">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            --- Choisir le profil---
                        </option>
                        <?php
                        foreach ($result_profil as $row) {
                            ?>
                            <option value="<?php echo $row['id_profil']; ?>">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php echo $row['libelle_profil']; ?>
                            </option>
                            <?php
                        }//fin foreach
                        ?>
                    </select>
                </div>
                </td>
                <td>
                <div class="col-md-3 col-sm-3 col-xs-12" style="padding-top:9px">
                    <button class="btn btn-info btn-xs" id="btn_search" name="btn_search" type="button">
                        <span class="glyphicon glyphicon-search " style="color: #FFFFFF"></span>
                        Chercher
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
<script>
    //=========================================================
    //=========AUTOCOMPLETE DE NOM D'UTILISATEUR============
    //=========================================================
    <?php
    $sql = "SELECT DISTINCT nom_user FROM users";
    $result_nom = $pdo->query($sql);
    ?>
    var availableTags1 = [
        <?php
        foreach ($result_nom as $row1) {
        ?>
        "<?php echo $row1['nom_user']; ?>",<?php
        }//fin foreach
            " "
        ?>
    ];
    $( "#nom" ).autocomplete({
        source: availableTags1
    });
    //=========================================================
    //=========AUTOCOMPLETE DE PRENOM D'UTILISATEUR============
    //=========================================================
    <?php
    $sql = "SELECT DISTINCT prenom_user FROM users";
    $result_prenom = $pdo->query($sql);
    ?>
    var availableTags2 = [
        <?php
        foreach ($result_prenom as $row2) {
        ?>
        "<?php echo $row2['prenom_user']; ?>",<?php
        }//fin foreach
        " "
        ?>
    ];
    $( "#prenom" ).autocomplete({
        source: availableTags2
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        change_page('0');

        //gestion du click du btn rechercher
        $("#btn_search").click(function(){
            var page_id = 0;
            var nom = $("#nom").val();
            var prenom = $("#prenom").val();
            var profil = $("#profil").val();

            // au lancement de la fonction ajax
            $(document).ajaxStart(function(){
                $('.spinner').css('display','inline-table');
            });

            // au lancement de la fonction ajax
            $(document).ajaxStop(function(){
                $('.spinner').css('display','none');
            });

            var dataString = 'page_id='+page_id+'&nom='+nom+'&prenom='+prenom+'&profil='+profil ;
            $.ajax({
                type: "POST",
                url: "user_load_data.php",
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
        //$(".flash").show();
        //$(".flash").fadeIn(50).html('Loading <img src="../img/ajax-loader.gif" />');
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        var profil = $("#profil").val();
        var dataString = 'page_id='+page_id+'&nom='+nom+'&prenom='+prenom+'&profil='+profil ;

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
            url: "user_load_data.php",
            data: dataString,
            cache: false,
            success: function(result){
                $(".flash").hide();
                $("#page_data").html(result);
            }
        });
    } //fin fonction change_page
</script>
<script>
    $(document).ready(function(){
        // avec le mot passe
        $("#password").keyup(function(){
            //On vérifie si le mot de passe est ok
            if($("#password").val().length < 6){
                $("#pass").css("color", "red").html("Trop court (6 caractères minimum)");
            }else {
                $("#pass").html('');
            }
        });
        $("#password2").keyup(function(){
            if($("#password2").val() != "" && $("#password2").val() != $("#password").val()){
                $("#pass1").css("color", "red").html("Les deux mots de passe sont différents");
                $("#pass2").css("color", "red").html("Les deux mots de passe sont différents");
            } else {
                $("#pass2").html('');
            }
        });
    });

</script>

<!-- PIED DE LA PAGE -->
<?php include 'include/pied.php';?>
