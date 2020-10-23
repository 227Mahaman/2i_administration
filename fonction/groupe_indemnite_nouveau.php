<?php
require_once '../security.php';
include_once("action_db_manager.php");
include_once("groupe_indemnite_db_manager.php");

// appel de certaines fonctions de certaines petites taches
include_once("../fonction/fonctions.php");

// fonction qui permet de controler le droit d'acces a la page
    verifier_droit_page();

    // initialisation de la variable id_groupe_indemnite_hierarchique
    if(isset($_POST['designation_groupe'])){
        $id_groupe_indemnite_hierarchiques = $_POST['id_groupe_indemnite_hierarchique'];
    }
    else{
        $id_groupe_indemnite_hierarchiques =array();
    }

//enregistrement des données du formulaire dans la base
if (isset($_POST['Enregistrer'])){

    // controle sur les champs obligatoires
    if(not_empty_group(['designation_groupe_indemnite'])){

        $code_groupe_indemnite            =   echapper($_POST['code_groupe_indemnite']);
        $designation_groupe_indemnite     =   echapper($_POST['designation_groupe_indemnite']);
        
        // insertion
        $insert = ajouter_groupe_indemnite($code_groupe_indemnite, $designation_groupe_indemnite);
        if($insert){
            // ajout des differents groupe_indemnites hierarchiques
            // recuperation du dernier id_groupe_indemnite
            $id_groupe_indemnite = get_last_id_groupe_indemnite()['id_groupe_indemnite'];
            // variable de formulaire pour les groupe_indemnites hierarchiques
            $id_groupe_indemnite_hierarchiques = $_POST['id_groupe_indemnite_hierarchique'];
            // parcours des differents groupe_indemnites hierarchiques
            foreach($id_groupe_indemnite_hierarchiques as $id_groupe_indemnite_hierarchique){
                // si le groupe_indemnite n'est pas deja enregistré
                if(verifier_si_ajouter_groupe_indemnite_hierarchique($id_groupe_indemnite, $id_groupe_indemnite_hierarchique)){
                    // ajout dans la base de donnee
                    ajouter_groupe_indemnite_hierarchique($id_groupe_indemnite, $id_groupe_indemnite_hierarchique);
                }
            }

            // envoi du message de succes
            nouveau_alert('success', "Vous avez ajouté un groupe_indemnite avec succés");

            header("location:groupe_indemnite_nouveau.php");
            die();
        }

        else{
             // envoi du message d'erreur
            nouveau_alert('danger', "Echec d'enregistrement");
        }
    }
    else{
        // envoi du message d'erreur
        nouveau_alert('danger', "Veuillez bien remplir tous les champs !!!");
    }

    }//fin if isset bouton_enregistrer

    // ENTETE
    $titre = 'Nouveau groupe_indemnite';
    include 'include/entete.php';   
?>

<div class="container body">
    <div class="main_container">
        <!-- menu -->
        <?php include_once("menu.php"); ?>
        <!-- fin menu -->
        <div class="right_col" role="main">
            <ul class="breadcrumb" style="margin-left: 130px">
                <li>
                    <span class="fa fa-wheelchair"></span>&nbsp;
                    groupe_indemnite
                </li>
                <li>
                    <span class="fa fa-list"></span>&nbsp;
                    nouveau groupe_indemnite
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
                                Nouveau groupe_indemnite
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <?php
                                    if(verifier_droit_action('groupe_indemnite_consulter.php')):
                                ?>
                                <a class="btn btn-success btn-xs"
                                    href="groupe_indemnite_consulter.php">
                                    <span class="fa fa-list" style="color: #fff"></span>&nbsp;
                                    Liste des groupe_indemnites
                                </a>
                                <?php endif;?>        
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content" >
                            <form data-parsley-validate class="form-horizontal form-label-left reciept2" action="" name="nouvelle_groupe_indemnite" method="post" autocomplete="off">
                                <div class="form-group has-feedback" style="padding: 20px;">
                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                        <!--code du groupe_indemnite-->
                                        <label>
                                            Code du groupe_indemnite
                                        </label>
                                        <div class="input-group">
                                            <i class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </i>
                                            <input type="text" name="code_groupe_indemnite" class="form-control" placeholder="Entrez le code du groupe_indemnite" value="<?php set_value('code_groupe_indemnite');?>">
                                        </div>

                                        <!--designation du groupe_indemnite-->
                                        <label>
                                            Désignation du groupe_indemnite
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="input-group">
                                            <i class="input-group-addon">
                                                <i class="fa fa-file-text"></i>
                                            </i>
                                            <input type="text" name="designation_groupe_indemnite" class="form-control" placeholder="Entrez la désignation du groupe_indemnite" required value="<?php set_value('designation_groupe_indemnite');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p class="text-center">
                                                    Liste des groupe_indemnites hierarchiques
                                                </p>
                                                <a class="btn btn-primary btn-xs pull-right" onclick="ajoutergroupe_indemnite()">
                                                    <i class="fa fa-plus"></i>
                                                    &nbsp;ajouter un groupe_indemnite hierarchique
                                                </a>
                                                <div style="margin-top: 40px;">
                                                    <table class="conteneur table table-condensed">
                                                        <!-- la liste des groupe_indemnites hierarchique choisis  -->
                                                        <!-- parcours de cette liste -->
                                                        <?php foreach($id_groupe_indemnite_hierarchiques as $id_groupe_indemnite):?>
                                                        
                                                        <tr>
                                                            <td>
                                                                <select name="id_groupe_indemnite_hierarchique[]" class="form-control" style="margin-bottom:5px;">
                                                                    <option value="">--- Choisir le groupe_indemnite hierarchique ---</option>
                                                                    <!-- debut parcours -->
                                                                    <?php foreach(lister_groupe_indemnite('true') as  $groupe_indemnite):?>

                                                                        <option value="<?php echo $groupe_indemnite['id_groupe_indemnite'];?>"
                                                                            <?php select_option('', $groupe_indemnite['id_groupe_indemnite'], $id_groupe_indemnite);?> >
                                                                            <?php echo $groupe_indemnite['designation_groupe_indemnite'];?>
                                                                        </option>;
                                                                        
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a class='btn btn-danger supprimer'><span class='fa fa-trash'></span></a>
                                                            </td>
                                                        </tr>

                                                        <!-- fin du parcours de la liste -->
                                                        <?php endforeach;?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group col-sm-offset-2">
                                    <div class="pull-right">
                                        <button class="btn btn-primary btn-xs" type="reset">
                                            <span class="fa fa-refresh"></span>
                                            Réunitialiser
                                        </button>
                                        <button type="submit" id="Enregistrer"
                                                name="Enregistrer" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-floppy-save"></span>
                                            Enregistrer
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

<script>
    // ajouter un groupe_indemnite hierarchique
    function ajoutergroupe_indemnite(){
        var contenugroupe_indemnite;
        contenugroupe_indemnite = '<tr><td>';
        contenugroupe_indemnite +='<select name="id_groupe_indemnite_hierarchique[]" class="form-control" style="margin-bottom:5px;">';
        contenugroupe_indemnite +='<option value="">--- Choisir le groupe_indemnite hierarchique ---</option>';
            // affichage des differents services

            // debut parcours
            <?php foreach(lister_groupe_indemnite('true') as  $groupe_indemnite):?>

                contenugroupe_indemnite +='<option value="<?php echo $groupe_indemnite['id_groupe_indemnite'];?>">';
                contenugroupe_indemnite +='<?php echo $groupe_indemnite['designation_groupe_indemnite'];?>';
                contenugroupe_indemnite +='</option>';
                
            <?php endforeach;?>
            // fin parcours

        contenugroupe_indemnite += '</select></td>';
        contenugroupe_indemnite += "<td><a class='btn btn-danger supprimer'><span class='fa fa-trash'></span></a><td>";
        contenugroupe_indemnite += '</tr>';

        $('.conteneur').append(contenugroupe_indemnite);
    }

    // action de suppression d'un groupe_indemnite hierarchique
    $(document).on('click', '.supprimer', function(){
        var thisParent;
        var trElement;
        thisParent = $(this).parent();
        trElement  = thisParent.parent();
        trElement.remove();
    });
    
</script>

<!-- PIED DE LA PAGE -->
<?php include 'include/pied.php';?>