<?php 
	//***page de control de session de ****************
	session_start();

	//on verifie que les variables de session sont renseignées
	if(!isset($_SESSION['login']) || !isset($_SESSION['mot_passe']) || !isset($_SESSION['profil'])){
		  header('location:../index.php?msg=Veuillez vous connecter !');  
		  exit();
	}

	


//CONTROLER LES SAISIES SUR LE NAVIGATEUR

//echo '';
//print_r($_SERVER);
//echo '/';

// le script en lui même

$chaine = $_SERVER['HTTP_REFERER'];
$lg_max=strlen($_SERVER['HTTP_HOST']);

if (strlen($chaine) > $lg_max)
{
    $chaine = substr($chaine, 7, $lg_max);
}

//echo 'resultat :'.$chaine;


if($_SERVER['HTTP_HOST']!=$chaine){
    session_start();
    session_unset();
    header("location:../index.php?msg=Veuillez uniquement utiliser le menu d'application !");
    exit();
}else{
}
?>