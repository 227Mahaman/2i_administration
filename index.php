<?php 
  session_start();
  //Require les scripts
  require_once('connexion/connexion.php');
  require_once('./security.php');
  if (isset($_SESSION['user-auth'])) {

  } else {
    if (!empty($_POST)) {//
        $data = $_POST;
        
    }
    require('app/views/view_login.php');
}