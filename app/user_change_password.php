<?php
    require_once '../security.php';
    include_once("action_db_manager.php");
    include_once("user_db_manager.php");

    // appel de certaines fonctions de certaines petites taches
    include_once("../fonction/fonctions.php");

    //enregistrement des données du formulaire dans la base
    if (isset($_POST['Enregistrer'])){

        // controle sur les champs obligatoires
        if(not_empty_group(['passe_actuel', 'passe_nouveau', 'passe_confirm'])){

            // recuperation des differentes valeurs
            $login          =   echapper($_SESSION['login']);
            $passe_actuel   =   echapper($_POST['passe_actuel']);
            $passe_nouveau  =   echapper($_POST['passe_nouveau']);
            $passe_confirm  =   echapper($_POST['passe_confirm']);

            // recuperation des information de l'ancien compte
            $compte = verify_user($login, md5($passe_actuel))->fetch();

            // si le compte est valide
            if(!empty($compte))
            {
                // verification des deux mots de passe
                if($passe_nouveau != $passe_confirm)
                {
                    nouveau_alert('danger', 'Mot de passe nouveau et confirmation ne concordent pas');
                    header("location:user_change_password.php");
                    die();
                }
                else
                {
                    $update = update_password_user($login, md5($passe_nouveau));

                    if($update)
                    {
                        nouveau_alert('success', 'Mot de passe mis à jour');
                        header("location:user_change_password.php");
                        die();
                    }
                    else
                    {
                        nouveau_alert('warning', 'Impossible de mettre à jour le mot de passe');
                        header("location:user_change_password.php");
                        die();
                    }
                }
            }
            else
            {
                nouveau_alert('danger', 'Mot de passe actuel incorrect');
                header("location:user_change_password.php");
                die();
            }
        }
        else{
            // envoi du message d'erreur
            nouveau_alert('danger', "Veuillez bien remplir tous les champs !!!");
        }

    }//fin  bouton_enregistrer

    // ENTETE
    $titre = 'Changer mot de passe';
    include 'include/entete.php';
?>

<div class="container body">
    <div class="main_container">
        <!-- menu -->
        <?php include_once("menu.php"); ?>
        <!-- fin menu -->
        <div class="right_col" role="main">
            <ul class="breadcrumb" style="margin-left: 25px">
                <li>
                    <span class="fa fa-user"></span>&nbsp;
                    User
                </li>
                <li>
                    <span class="fa fa-key"></span>&nbsp;
                    Mot de passe
                </li>
            </ul>
            <!-- fonction alert -->
            <?php include '../fonction/alert-message.php'; ?>
            <!-- fin fonction alert -->

            <!-- corps de la page -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <span class="fa fa-plus-square"></span>&nbsp;
                                Modifier le mot de passe
                            </h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content" >
                            <form data-parsley-validate
                                class="form-horizontal form-label-left reciept2"
                                action="" name="nouvelle_retenue" method="post"
                                autocomplete="off">
                                <div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2" style="padding: 20px;">
                                    <div class="col-md-6 col-md-offset-3">
                                        <!-- Ancien mot de passe -->
                                        <label>
                                            Mot de passe actuel
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group">
                                            <i class="input-group-addon">
                                                <i class="fa fa-lock"></i>
                                            </i>
                                            <input type="password" name="passe_actuel"
                                                class="form-control" required
                                                placeholder="Mot de passe actuel"
                                                value=" ">
                                        </div>

                                        <!-- Nouveau mot de passe -->
                                        <label>
                                            Nouveau mot de passe
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group">
                                            <i class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </i>
                                            <input type="password" name="passe_nouveau"
                                                class="form-control" required
                                                id="passe_nouveau" minlength="4"
                                                placeholder="Nouveau Mot de passe">
                                        </div>

                                        <!-- Mot de passe de confirmation -->
                                        <label>
                                            Mot de passe de confirmation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group">
                                            <i class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </i>
                                            <input type="password" name="passe_confirm"
                                                class="form-control" required
                                                minlength="4"
                                                placeholder="Mot de passe de confirmation"
                                                data-parsley-equalto="#passe_nouveau">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="ln_solid"></div> -->
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button class="btn btn-primary btn-xs" type="reset">
                                            <span class="fa fa-refresh"></span>
                                            Réinitialiser
                                        </button>
                                        <button type="submit" id="Enregistrer"
                                                name="Enregistrer" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-floppy-save"></span>
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                                <br>
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
