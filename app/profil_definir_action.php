<?php 
    include_once("controle_session.php"); 
    include_once("../connexion/connexion.php");	
    include_once("action_db_manager.php");
    include_once("profil_db_manager.php");
    
    if(isset($_GET['id_profil'])){
        $id_profil = $_GET['id_profil'];
        $libelle_profil = $_GET['libelle_profil'];
    } 
    
    //enregistrement des actins definis
     if(isset($_POST['bouton_envoyer'])){
        $id_profil = $_POST['id_profil'];
        $libelle_profil = $_POST['libelle_profil'];
        $liste_action = $_POST['liste_action'];
        $nbr_action_coche = sizeof($liste_action);

        
        $id_user_conn = $_SESSION['id_user'];
        $date = date("Y-m-d H:i:s");
    
        //update du libelle profil
        update_profil($id_profil, $libelle_profil, $id_user_conn, $date);
        
        for($i=0; $i<$nbr_action_coche; $i++){
            $id_action = $liste_action[$i];
            $pdo->query("INSERT INTO profil_has_action(id_profil, id_action) VALUES ($id_profil, $id_action)");
        }//fin for
        
        $msg = "Enregistré avec succès.";
        header("location:profil_consulter.php?msg=$msg&type_msg=1");
        
    }//fin if isset bouton_envoyer

    // ENTETE
    $titre = "Définir les droits du profil";
    include 'include/entete.php';
    
?>

    
  
    <style type="text/css">
        #bouton_envoyer{
            margin-top: 20px;
        }
        #form1{
            border: 1px #ddd solid;
            border-radius: 10px;
            padding: 30px;
        }
    </style>
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <?php include_once("menu.php"); ?>
        <div class="right_col" role="main">
            <ul class="breadcrumb">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;
                <li> <span class="fa fa-user"></span> Profil</li>
                <li><span class="fa fa fa-plus-square"></span>&nbsp; définir privilèges</li>
            </ul>
            <?php include '../message_confirmation.php';
            $records = select_all_actions();
             ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <span class="fa fa-plus-square"></span>&nbsp;Donner privilèges
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
                            <!--  formulaire de actions-->
                            <form action="#" id="form1" name="form1" method="post" class="reciept2">
                                <table class='table table-bordered table-striped table-condensed recieptBlanc' style="border-radius: 5px 5px 5px 5px">
                                    <tr>
                                        <td>
                                            <div class="form-group has-feedback">
                                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top:8px">
                                                    <!--======================================================
                                                     ===============LIBELLE  PROFIL=================
                                                     ======================================================-->
                                                    <label class="col-md-8 col-sm-8 col-xs-12">
                                                        Profil
                                                    </label>
                                                    <span class="fa fa-user form-control-feedback left "
                                                          aria-hidden="true">
                                                     </span>
                                                    <input type="hidden" id="id_profil" name="id_profil"
                                                           class="form-control" required value="<?php echo $id_profil ;?>"/>
                                                    <input type="text" id="libelle_profil"
                                                           name="libelle_profil" value="<?php echo $libelle_profil ;?>"
                                                           style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px" class="form-control has-feedback-left">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table class='table table-bordered table-striped table-condensed' id="tab"
                                       style="border-radius: 5px 5px 5px 5px">
                                    <thead class="BackCollor reciept">
                                    <th><b class="fa fa-star-half-o verte"></b>&nbsp;&nbsp;Module</th>
                                    <th><b class="fa fa-legal verte"></b>&nbsp;&nbsp;Libellé privilège</th>
                                    <th><b class="fa fa-comments-o verte"></b>&nbsp;&nbsp;Description privilège</th>
                                    <th><b class="fa fa-cogs verte"></b>&nbsp;&nbsp;Action</th>
                                    </thead>
                                    <tbody class="tbody">
                                    <?php
                                    foreach($records as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo htmlentities(stripcslashes($row['libelle_groupe']));?>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo htmlentities(stripcslashes($row['libelle_action']));?>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo htmlentities(stripcslashes($row['description_action']));?>
                                            </td>
                                            <td>
                                                <input class="flat" type="checkbox"
                                                    value="<?php echo htmlentities(stripcslashes($row['id_action']));?>"
                                                    name="liste_action[]">
                                            </td>
                                        </tr>
                                        <?php
                                    } //fin foreach
                                    ?>
                                    </tbody>
                                </table>
                                <p style="text-align: center">
                                    <button id="bouton_envoyer" name="bouton_envoyer" type="submit" class="btn btn-success btn-xs">
                                        <span class="glyphicon glyphicon-floppy-save"></span> Valider
                                    </button>
                                </p>
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