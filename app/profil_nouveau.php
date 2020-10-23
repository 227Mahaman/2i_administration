<?php
    include_once("controle_session.php");
    include_once("profil_db_manager.php");
    require_once '../security.php';
    include_once("../connexion/connexion.php");

    // appel de certaines fonctions de certaines petites taches
    include_once("../fonction/fonctions.php");

    // verifier si la personne a droit a d'acces a la page
    verifier_droit_page();

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
        }
        else
        {
            $msg = "Echec de l'enregistrement, veuillez reprendre svp.";
            nouveau_alert('danger', $msg);
        }
    }//fin if isset bouton_enregistrer

    // ENTETE
    $titre = "Nouveau profil";
    include 'include/entete.php';
?>

<div class="container body">
    <div class="main_container">
        <?php include_once("menu.php"); ?>
        <div class="right_col" role="main">
            <ul class="breadcrumb" style="margin-left: 25px">
                <li> <span class="fa fa-user"></span> Profil</li>
                <li><span class="fa fa fa-plus-square"></span>&nbsp; Ajouter</li>
            </ul>

            <!-- fonction alert -->
            <?php include '../fonction/alert-message.php'; ?>
            <!-- fin fonction alert -->

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <span class="fa fa-plus-square"></span>&nbsp;Nouveau profil
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" >
                            <form id="demo-form2 form1" data-parsley-validate class="form-horizontal form-label-left reciept2"
                                action="profil_nouveau.php" name="form1" method="post">
                                <div class="form-group has-feedback">
                                    <div class="col-md-4 col-sm-4 col-xs-12 col-sm-offset-4"
                                        style="padding-top:8px">

                                        <!--======================================================
                                         ===============LIBELLE  PROFIL=================
                                         ======================================================-->
                                        <label class="col-md-8 col-sm-8 col-xs-12">
                                            Profil
                                            <i class="text-danger">*</i>
                                        </label>
                                        <span class="fa fa-user form-control-feedback left"></span>
                                        <input type="text" id="libelle_profil" required="required"
                                            class="form-control has-feedback-left"
                                            style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                                            name="libelle_profil" placeholder="Entrez le profil"
                                            value="<?php set_value('libelle_profil');?>">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                                        <button class="btn btn-primary btn-xs" type="reset">
                                            <span class="fa fa-refresh"></span>
                                            Réinitialiser
                                        </button>
                                        <button type="submit" id="bouton_envoyer"
                                                name="bouton_envoyer" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-floppy-save"></span> Soumettre
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PIED DE LA PAGE -->
<?php include 'include/pied.php';?>
