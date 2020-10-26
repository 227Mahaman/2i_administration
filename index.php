<?php 
    session_start();
    //Require les scripts
    require_once('connexion/connexion.php');
    require_once('./security.php');
    if (isset($_SESSION['id_user'])) {
        extract($_GET);
        if ($p == "dashboard") {//Tableau de board
            include_once('app/views/view_dashboard.php');
        } elseif($p == "deconnexion"){//Deconnexion
            include_once('deconnexion.php');
        } elseif($p == "login"){//Login
            include_once('app/views/view_login.php');
        } elseif($p == "profil"){//Profil
            include_once('app/views/view_profil.php');
        } elseif($p == "module"){//Module
            include_once('app/views/view_module.php');
        } elseif($p == "menu"){//Menu
            include_once('app/views/view_menu.php');
        } elseif($p == "addUser"){//AddUser
            include_once('app/views/view_addUser.php');
        }

    } else {//Connexion
        if(isset($_POST['connecter'])){
            $login = echapper($_POST['login']) ;
            $mot_passe = echapper($_POST['mot_passe']);
            $mot_passe = md5($mot_passe);
            //requete dans la table compte //table: postgres users
            $query = "SELECT id_user, id_profil, nom_user, prenom_user, login, password, statut_connexion 
                FROM user   
                WHERE  login = '$login' and  password = '$mot_passe' and statut_activation = 1"
            ;
            $result = $pdo->query($query);
            $nbr = $result->rowCount();
            if($nbr == 1){
                $row = $result->fetch();
                $_SESSION['id_user'] = htmlentities(stripcslashes($row['id_user']));
                $_SESSION['login'] = htmlentities(stripcslashes($row['login']));
                $_SESSION['mot_passe'] = htmlentities(stripcslashes($row['password']));
                $_SESSION['profil'] = htmlentities(stripcslashes($row['id_profil']));
                $_SESSION['nom'] = htmlentities(stripcslashes($row['nom_user']));  
                $_SESSION['prenom'] = htmlentities(stripcslashes($row['prenom_user']));
                    //le profil du user
                    $id_profil = $row['id_profil']; 
                    
                //********1.récupération de la liste des actions autorisées du bloc configuration***********************************
                $sql = "SELECT  g.id_groupe,icon_groupe, libelle_groupe, p.id_action, libelle_action, url_action
                    FROM action a, profil_has_action p, groupe_action g
                    WHERE a.id_action = p.id_action and a.id_groupe=g.id_groupe
                    and id_profil=$id_profil and bloc_menu='configuration'
                    order by libelle_groupe asc, ordre_affichage_action asc"
                ;
                $result_configuration = $pdo->query($sql);
                //initialisation de la variable de session pour configuration
                $_SESSION['bloc_configuration']= array();
                $i=0;
                foreach($result_configuration as $row_configuration){
                    $_SESSION['bloc_configuration'][$i] = array('id_groupe' => $row_configuration['id_groupe'],
                        'libelle_groupe' => $row_configuration['libelle_groupe'],
                        'icon_groupe' => $row_configuration['icon_groupe'],
                        'id_action' => $row_configuration['id_action'],
                        'libelle_action' => $row_configuration['libelle_action'],
                        'url_action' => $row_configuration['url_action']
                    );
                    $i++;
                }//fin foreach
                //**********2.récupération de la liste des actions autorisées du bloc administration*********************
                $sql = "SELECT  g.id_groupe,icon_groupe, libelle_groupe, p.id_action, libelle_action, url_action
                    FROM action a, profil_has_action p, groupe_action g
                    WHERE a.id_action = p.id_action and a.id_groupe=g.id_groupe
                    and id_profil=$id_profil and bloc_menu='administration'
                    order by ordre_affichage_groupe asc, g.id_groupe,  ordre_affichage_action asc"
                ;
                $result_administration = $pdo->query($sql);
                //initialisation de la variable de session pour le bloc administration
                $_SESSION['bloc_administration']= array();
                $i=0;
                foreach($result_administration as $row_administration){
                    $_SESSION['bloc_administration'][$i] = array('id_groupe' => $row_administration['id_groupe'],
                        'libelle_groupe' => $row_administration['libelle_groupe'],
                        'icon_groupe' => $row_administration['icon_groupe'],
                        'id_action' => $row_administration['id_action'],
                        'libelle_action' => $row_administration['libelle_action'],
                        'url_action' => $row_administration['url_action']
                    );
                    $i++;
                }//fin foreach
                header('Location: index.php?p=dashboard');
            }
            else{ //else 2
              //erreur de login/mot de passe
              header('location:index.php?msg=login et/ou mot de passe incorrect');
        
            }// fin else  2
        
        }//fin if isset $_POST['connecter']
        require('app/views/view_login.php');
    }
//include_once('app/views/view_login.php');