<?php 
    session_start();
    //Require les scripts
    require_once('connexion/connexion.php');
    require_once('./security.php');
    if (isset($_SESSION['user-auth'])) {

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
                    
                //********récupération de la liste des actions autorisées du bloc config***********************************
                $sql = "SELECT  g.id_groupe,icon_groupe, libelle_groupe, p.id_action, libelle_action, url_action
                        FROM action a, profil_has_action p, groupe_action g
                        WHERE a.id_action = p.id_action and a.id_groupe=g.id_groupe
                        and id_profil=$id_profil and bloc_menu='config'
                        order by libelle_groupe asc, ordre_affichage_action asc";
                $result_config = $pdo->query($sql);
                //initialisation de la variable de session pour config
                $_SESSION['bloc_config']= array();
                $i=0;
                foreach($result_config as $row_config){
                    $_SESSION['bloc_config'][$i] = array('id_groupe' => $row_config['id_groupe'],
                                                            'libelle_groupe' => $row_config['libelle_groupe'],
                                                            'icon_groupe' => $row_config['icon_groupe'],
                                                            'id_action' => $row_config['id_action'],
                                                            'libelle_action' => $row_config['libelle_action'],
                                                            'url_action' => $row_config['url_action']
                                                    );
                    $i++;
                }//fin foreach
                //**********récupération de la liste des actions autorisées du bloc simple*********************
                $sql = "SELECT  g.id_groupe,icon_groupe, libelle_groupe, p.id_action, libelle_action, url_action
                        FROM action a, profil_has_action p, groupe_action g
                        WHERE a.id_action = p.id_action and a.id_groupe=g.id_groupe
                        and id_profil=$id_profil and bloc_menu='simple'
                        order by ordre_affichage_groupe asc, g.id_groupe,  ordre_affichage_action asc";
                $result_simple = $pdo->query($sql);
                //initialisation de la variable de session pour le bloc simple
                $_SESSION['bloc_simple']= array();
                $i=0;
                foreach($result_simple as $row_simple){
                    $_SESSION['bloc_simple'][$i] = array('id_groupe' => $row_simple['id_groupe'],
                                                            'libelle_groupe' => $row_simple['libelle_groupe'],
                                                            'icon_groupe' => $row_simple['icon_groupe'],
                                                            'id_action' => $row_simple['id_action'],
                                                            'libelle_action' => $row_simple['libelle_action'],
                                                            'url_action' => $row_simple['url_action']
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