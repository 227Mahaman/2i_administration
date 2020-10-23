<?php
  include_once("controle_session.php");
  include_once("user_db_manager.php");
  require_once '../security.php';

  // appel de certaines fonctions de certaines petites taches
  include_once("../fonction/fonctions.php");

  // verifier si la personne a droit a d'acces a la page
  verifier_droit_page();

  //enregistrement des données du formulaire dans la base
  if (isset($_POST['bouton_envoyer'])) {
      $id_profil = echapper($_POST['id_profil']);
      $nom       = echapper($_POST['nom']);
      $prenom    = echapper($_POST['prenom']);
      $login     = echapper($_POST['login']);
      $password  = echapper($_POST['password']);
      $password2 = echapper($_POST['password2']);

      $id_user_conn = $_SESSION['id_user'];
      $date = date("Y-m-d H:i:s");
      if($password==$password2){
          $result = insert_user($id_profil, $nom, $prenom, $login, md5($password), $id_user_conn, $date);

          if ($result == true)
          {
              $msg = "Enregistré avec succès!";
              nouveau_alert('success', $msg);
              header("location:user_nouveau.php");
              die();
          }
          else
          {
              $msg = "Echec de l'enregistrement, veuillez reprendre svp.";
              nouveau_alert('danger', $msg);
          }
      }
      else
      {
          $msg = "Echec de l'enregistrement,les deux mots de passe sont différents. veuillez reprendre svp.";
          nouveau_alert('danger', $msg);
      }

  }//fin if isset bouton_enregistrer

  // ENTETE
  $titre = "Nouvel utilisateur";
  include 'include/entete.php';
?>

<div class="container body">
  <div class="main_container">
    <?php include_once("menu.php"); ?>
    <div class="right_col" role="main">
      <ul class="breadcrumb ajuster-entete">
          <li><span class="fa fa-user"></span>&nbsp;Utilisateur</li>
          <li><span class="fa fa fa-plus-square"></span>&nbsp;Ajouter</li>
      </ul>

      <!-- fonction alert -->
      <?php include '../fonction/alert-message.php'; ?>
      <!-- fin fonction alert -->

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>
                  <span class="fa fa fa-plus-square"></span>&nbsp;
                  Ajouter un nouvel utilisateur
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
            <div class="x_content">
              <form id="formulaire" data-parsley-validate class="form-horizontal form-label-left reciept2"
                    action="user_nouveau.php"
                    name="form1"
                    method="post">
                <div class="form-group has-feedback">
                  <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2" style="padding-top: 8px">
                      <!--
                      ******************************************
                      *****************NOM**********************
                      ******************************************
                      -->
                    <label class="col-md-8 col-sm-8 col-xs-12">
                        Nom utilisateur
                        <i class="text-danger">*</i>
                    </label>
                    <span class="fa fa-male form-control-feedback left"></span>
                    <input type="text" id="nom" name="nom" required
                      style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                      class="form-control has-feedback-left"
                      placeholder="Entrez le nom de l'utilisateur"
                      value="<?php set_value('nom');?>">
                  </div>
                  <!--******************************************
                   *****************PRENOM*******************
                   ******************************************-->
                  <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                    <label class="col-md-8 col-sm-8 col-xs-12">
                        Prénom utilisateur
                        <i class="text-danger">*</i>
                    </label>
                    <span class="fa fa-male form-control-feedback right"></span>
                    <input type="text" id="prenom" name="prenom"
                      style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                      required="required" class="form-control has-feedback-left"
                      placeholder="Entrez le prénom de l'utilisateur"
                      value="<?php set_value('prenom');?>">
                  </div>
                </div>
                <!--
                   ******************************************
                   *****************LOGIN********************
                   ******************************************
                  -->
                <div class="form-group has-feedback">
                  <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2"
                    style="padding-top: 8px">
                    <label class="col-md-8 col-sm-8 col-xs-12">
                      Login utilisateur
                      <i class="text-danger">*</i>
                    </label>
                    <span class="fa fa-user form-control-feedback left"></span>
                    <input type="text" id="login" name="login"
                      style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                      required="required" class="form-control has-feedback-left"
                      placeholder="Entrez le login"
                      value="<?php set_value('login');?>">
                  </div>
                  <!--******************************************
                   *****************MOT DE PASSE*************
                   *******************************************-->
                  <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                  <label class="col-md-8 col-sm-8 col-xs-12">
                      Mot de passe
                      <i class="text-danger">*</i>
                  </label>
                   <span class="fa fa-lock form-control-feedback right"></span>
                    <input type="password" id="password" name="password"
                    minlength="6"
                      style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                      required="required" class="form-control has-feedback-left"
                      placeholder="Mot de passe">
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
                          <i class="text-danger">*</i>
                      </label>
                      <span class="fa fa-users form-control-feedback left"></span>
                    <?php
                    //recuperation de la liste des profils user
                    $sql = "SELECT id_profil, libelle_profil FROM profil order by libelle_profil";
                    $result_profil = $pdo->query($sql);
                    ?>
                    <select name="id_profil" id="id_profil" class="form-control" required
                      style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:2px">
                      <option value="">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        --- Choisir le profil ---
                      </option>
                    <?php foreach ($result_profil as $row) :?>
                          <option value="<?php echo $row['id_profil']; ?>"
                            <?php select_option('id_profil', $row['id_profil'])?>>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $row['libelle_profil']; ?>
                          </option>
                    <?php endforeach;?>
                    </select>
                  </div>
                    <!--******************************************
                            *****************CONFIRMER LE MOT DE PASSE*************
                         *******************************************-->
                    <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 8px">
                        <label class="col-md-12 col-sm-12 col-xs-12">
                            Mot de passe confirmation
                            <i class="text-danger">*</i>
                        </label>
                        <span class="fa fa-lock form-control-feedback right"></span>
                        <input type="password" id="password2" name="password2"
                            style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                            required="required" class="form-control has-feedback-left"
                            placeholder="Mot de passe de confirmation">
                        <b id="pass2"></b>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                    <button class="btn btn-primary btn-xs" type="reset">
                      <span class="fa fa-repeat"></span>
                      Réinitialiser
                    </button>
                    <button type="submit" id="bouton_envoyer"
                            name="bouton_envoyer" class="btn btn-success btn-xs">
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
    $(document).ready(function(){
        // avec le mot passe
        $("#password").keyup(function(){
            //On vérifie si le mot de passe est ok
            if($(this).val().length < 6){
              $(this).css({
                  'border-color'     : 'red',
                  'background-color' : 'rgb(249, 212, 212)'
              });
            }
            else
            {
                $(this).css({
                    'border-color'     : 'green',
                    'background-color' : 'rgb(199, 245, 188)'
                });
            }
        });

        // mot de passe de confirmation
        $("#password2").keyup(function(){

            if($(this).val() != $('#password').val()){
                 $(this).css({
                    'border-color'     : 'red',
                    'background-color' : 'rgb(249, 212, 212)'
                });
            } else {
                $(this).css({
                    'border-color'     : 'green',
                    'background-color' : 'rgb(199, 245, 188)'
                });
            }
        });

        // blocage de l'envoi du formulaire au cas ou les mots de passe ne sont pas corrects
        $('#formulaire').on('submit', function(e){
            var passModifier, passConfirmer;
            passModifier  = $(this).find('.password_modifier').val().trim();
            passConfirmer = $(this).find('.password2_modifier').val().trim();

            // mot de passe different alors bloquer le formulaire
            if(passModifier != passConfirmer)
            {
              e.preventDefault();

              // erreur de mot de passe
              alertify.alert('Les deux mots de passe ne concordent pas').setHeader('Erreur de mot de passe');
            }
        });
    });

</script>

<!-- PIED DE LA PAGE -->
<?php include 'include/pied.php';?>
