<?php 
    include_once("controle_session.php"); 
    include_once("../connexion/connexion.php");
    require_once '../security.php';
    
    //activation ou desactivation de compte
    if(isset($_GET['id_user'])){
        $id_user = echapper($_GET['id_user']);
        $statut = echapper($_GET['statut']); 

        if($statut == 0) $nouv_statut = 1;
        else if($statut == 1) $nouv_statut = 0;

        try{
            $sql = "update users set statut_activation=? where id_user=?";
            $setSatut   =   $pdo->prepare($sql);
            $setSatut->execute([$nouv_statut, $id_user]);

            header("location:user_consulter.php");
        }
        catch(EXCEPTION $e){
            header("location:user_consulter.php");
            
        }


    }//fin if isset
	
?>