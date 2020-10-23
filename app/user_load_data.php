<?php
  session_start();
  include_once("user_db_manager.php");
  require_once '../security.php';

   // appel de certaines fonctions de certaines petites taches
  include_once("../fonction/fonctions.php");


    $critere = "true";
    if(isset($_POST['nom'])){
        $nom = $_POST['nom'];
        if(!empty($nom)) $critere = $critere . " and nom_user like '$nom%' ";

        $prenom = $_POST['prenom'];
        if(!empty($prenom)) $critere = $critere . " and prenom_user like '$prenom%' ";

        $profil = $_POST['profil'];
        if(!empty($profil)) $critere = $critere . " and u.id_profil = $profil ";
    }//fin if isset
	$sqlQuery = select_user($critere);
	$count = $sqlQuery->rowCount();

	$adjacents = 2;
	$records_per_page =8;

	$page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
	$page = ($page == 0 ? 1 : $page);
	$start = ($page-1) * $records_per_page;

	$next = $page + 1;
	$prev = $page - 1;
	$last_page = ceil($count/$records_per_page);
	$second_last = $last_page - 1;

$pagination = "";
if($last_page > 1){
  $pagination .= "<div class='pagination col-lg-8 navbar-right reciept2' style='background-color:#EDEDED'>";
  if($page > 1)
      $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);' style='color:#00caff'>
                          &laquo;Premier &nbsp;&nbsp;
                     </a>";
  else
      $pagination.= "<span class='disabled'>&laquo; Premier &nbsp;&nbsp;</span>";

if ($page > 1)
      $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($prev).");' style='color:#00caff'>
                        &laquo; Précedent &nbsp;&nbsp;
                     </a>";
  else
      $pagination.= "<span class='disabled'>&laquo; Précedent &nbsp;&nbsp;</span>";

  if ($last_page < 7 + ($adjacents * 2))
  {
      for ($counter = 1; $counter <= $last_page; $counter++)
      {
          if ($counter == $page)
              $pagination.= "<span class='current'>$counter</span>";
          else
              $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");' style='color:#00caff'>
                                &nbsp;&nbsp; $counter &nbsp;&nbsp;
                             </a>";
      }
  }
  elseif($last_page > 5 + ($adjacents * 2))
  {
      if($page < 1 + ($adjacents * 2))
      {
          for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
          {
              if($counter == $page)
                  $pagination.= "<span class='current'>&nbsp;&nbsp;$counter&nbsp;&nbsp;</span>";
              else
                  $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");' style='color:#00caff'>
                                    &nbsp;&nbsp;$counter&nbsp;&nbsp;
                                  </a>";
          }
          $pagination.= "...";
          $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");' style='color:#00caff'>
                             &nbsp;&nbsp; $second_last&nbsp;&nbsp;
                         </a>";
          $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");' style='color:#00caff'>
                          &nbsp;&nbsp; $last_page&nbsp;&nbsp;
                           </a>";
     }
     elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
     {
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);' style='color:#00caff'>&nbsp;&nbsp;1&nbsp;&nbsp;</a>";
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);' style='color:#00caff'>&nbsp;&nbsp;2&nbsp;&nbsp;</a>";
         $pagination.= "...";
         for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
         {
             if($counter == $page)
                 $pagination.= "<span class='current'>&nbsp;&nbsp;$counter&nbsp;&nbsp;</span>";
             else
                 $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");' style='color:#00caff'>
                                    &nbsp;&nbsp;$counter&nbsp;&nbsp;
                                </a>";
         }
         $pagination.= "..";
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");' style='color:#00caff'>
                            &nbsp;&nbsp; $second_last&nbsp;&nbsp;
                        </a>";
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");' style='color:#00caff'>
                           &nbsp;&nbsp;$last_page&nbsp;&nbsp;
                        </a>";
     }
     else
     {
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);' style='color:#00caff'>&nbsp;&nbsp;1&nbsp;&nbsp;</a>";
         $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);' style='color:#00caff'>&nbsp;&nbsp;2&nbsp;&nbsp;</a>";
         $pagination.= "..";
         for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
         {
             if($counter == $page)
                  $pagination.= "<span class='current'>&nbsp;&nbsp;$counter&nbsp;&nbsp;</span>";
             else
                  $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");' style='color:#00caff'>
                                    &nbsp;&nbsp; $counter &nbsp;&nbsp;
                                 </a>";
         }
     }
  }
  if($page < $counter - 1)
      $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($next).");' style='color:#00caff'>
                       &nbsp;&nbsp;Suivant &raquo;&nbsp;&nbsp;
                      </a>";
  else
      $pagination.= "<span class='disabled'>&nbsp;&nbsp; Précedent &raquo;&nbsp;&nbsp;</span>";

if($page < $last_page)
      $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");' style='color:#00caff'>
                         &nbsp;&nbsp;Dernier &raquo;
                     </a>";
  else
      $pagination.= "<span class='disabled'>&nbsp;&nbsp;Dernier &raquo;&nbsp;&nbsp;</span>";

  $pagination.= "</div>";
}


$records = select_user_per_page($start, $records_per_page, $critere);
$count = $records->rowCount();
if($count > 0)
{
?>

<table class="table table-bordered table-striped table-condensed tbody" id="tab"
    style="margin-top:-2em">
    <thead class="BackCollor reciept">
        <th style="width:40px">
            <b class="verte">#&nbsp;</b>
            <i class="fa fa-unsorted pull-right hidden-print verte">
        </th>
        <th>
            <i class="fa fa-male verte"></i>&nbsp;
            Nom
            <i class="fa fa-unsorted pull-right hidden-print verte"></i>
        </th>
        <th>
            <i class="fa fa-male verte"></i>&nbsp;
            Prénom
            <i class="fa fa-unsorted pull-right hidden-print verte"></i>
        </th>
        <th>
            <i class="fa fa-users verte"></i>&nbsp;
            Profil
            <i class="fa fa-unsorted pull-right hidden-print verte"></i>
        </th>
        <th>
            <i class="fa fa-user verte"></i>&nbsp;
            Login
            <i class="fa fa-unsorted pull-right hidden-print verte"></i>
        </th>
        <?php
            if(verifier_droit_action('user_activer_compte.php')):
        ?>
        <th style="width:80px">
            <i class="fa fa-star-half-o verte"></i>&nbsp;
            Statut
        </th>
        <?php endif;?>
        <th style="width:80px">
            <i class="fa fa-cog verte"></i>&nbsp;
            Action
        </th>
     </thead>
     <tbody>
        <?php
            $index=0;
            foreach($records as $row) {
              $id_profil_user = $row['id_profil'];
         ?>
            <td><?php echo $index+=1;?></td>
            <td>
              <?php echo echapper($row['nom_user']);?>
            </td>
            <td>
              <?php echo echapper($row['prenom_user']);?>
            </td>
            <td>
              <?php echo echapper($row['libelle_profil']);?>
            </td>
            <td>
              <?php echo echapper($row['login']);?>
            </td>
            <td>
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                <?php
                    if(verifier_droit_action('user_activer_compte.php')):
                ?>
                <a href="user_activer_compte.php?id_user=<?php echo echapper($row['id_user']);?>&statut=<?php echo echapper($row['statut_activation']);?>"
                  style="align-content: center"
                  onclick="return(confirm('Voulez-vous valider cette opération?'))">
                  <?php if(echapper($row['statut_activation']) == 1):?>
                    <button class="btn btn-success btn-xs" type="button">
                        <span class='glyphicon glyphicon-check' style="color:#FFFFFF"></span>
                    </button>
                  <?php else: ?>
                  <button class="btn btn-danger btn-xs" type="button">
                      <span class='glyphicon glyphicon-ban-circle' style="color:#FFFFFF"></span>
                  </button>
                  <i class=" rouge"></i>
                  <?php endif;?>
                </a>
                <?php endif;?>
            </td>
            <td>
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                <?php
                    if(verifier_droit_action('user_modifier.php')):
                ?>
                <button class="btn btn-dark btn-xs" type="button" data-toggle="modal"
                    data-target=".<?php echo echapper($row['id_user']);?>">
                    <span class='glyphicon glyphicon-edit' style="color:#FFFFFF"></span>
                </button>
                <?php endif;?>
                    <!--******************************************
                     ****************MODIFIER UN UTILISATEUR*******************
                     ******************************************
                      -->
                    <div tabindex="-1" class="modal fade <?php echo echapper($row['id_user']);?>"
                        role="dialog" aria-hidden="true"
                        style="display: none; color: rgb(115, 135, 156); font-family: sans-serif;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button class="close" type="button" data-dismiss="modal">
                                      &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">
                                      Modification de l'utilisateur
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form data-parsley-validate
                                      class="form-horizontal form-label-left reciept2 formulaire"
                                      action="user_consulter.php" name="form1" method="post">
                                      <div class="form-group has-feedback">
                                        <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2"
                                          style="padding-top: 8px">
                                            <input type="hidden" id="nom" required="required"
                                              class="form-control has-feedback-left"
                                              value="<?php set_value('', $row['id_user']);?>"
                                              name="id_user">

                                              <!-- ***************************************
                                              *****************NOM**********************
                                              ******************************************-->
                                              <label class="col-md-8 col-sm-8 col-xs-12">
                                                Nom
                                                <em style="color:#d7082b">*</em>
                                              </label>
                                              <span class="fa fa-male form-control-feedback left"
                                                aria-hidden="true">
                                              </span>
                                              <input type="text" id="nom" required="required"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                                                class="form-control has-feedback-left"
                                                value="<?php set_value('', $row['nom_user']);?>"
                                                name="nom" placeholder="Entrez le nom">
                                            </div>

                                            <!--******************************************
                                             *****************PRENOM*******************
                                             ******************************************-->
                                            <div class="col-md-4 col-sm-4 col-xs-12"
                                              style="padding-top: 8px">
                                                <label class="col-md-8 col-sm-8 col-xs-12">
                                                    Prénom
                                                    <em style="color:#d7082b">*</em>
                                                </label>
                                                <span class="fa fa-male form-control-feedback right"
                                                      aria-hidden="true">
                                                </span>
                                                <input type="text" id="prenom" name="prenom" required
                                                  class="form-control has-feedback-left"
                                                  value="<?php set_value('', $row['prenom_user']);?>"
                                                  placeholder="Entrez le prénom"
                                                  style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                            </div>
                                        </div>

                                        <!-- *************************************
                                        ***************** LOGIN ******************
                                        *************************************** -->
                                        <div class="form-group has-feedback">
                                          <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2"
                                            style="padding-top: 8px">
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                              Login
                                              <i class="text-danger">*</i>
                                            </label>
                                            <span class="fa fa-user form-control-feedback left"></span>
                                            <input type="text" id="login" name="login" required
                                              class="form-control has-feedback-left"
                                              value="<?php set_value('', $row['login']);?>"
                                              placeholder="Entrez le login"
                                              style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                          </div>

                                          <!-- ******************************************
                                          ***************** MOT DE PASSE *************
                                          *******************************************-->
                                          <div class="col-md-4 col-sm-4 col-xs-12"
                                            style="padding-top: 8px">
                                            <label class="col-md-8 col-sm-8 col-xs-12">
                                              Mot de passe
                                            </label>
                                            <span class="fa fa-lock form-control-feedback right"></span>
                                            <input type="password" name="password_modifier"
                                              id="passeUser<?php echo $row['id_user'];?>"
                                              class="form-control has-feedback-left password_modifier"
                                              placeholder="Entrez le mot de passe"
                                              style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px">
                                              <b class="pass_modifier"></b>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                          <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2"
                                            style="padding-top: 8px">
                                            <!-- ******************************************
                                            ***************** PROFIL *******************
                                            ****************************************** -->
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
                                                <select name="id_profil" class="form-control"
                                                  required style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:2px">
                                                  <?php foreach ($result_profil as $profil) : ?>
                                                    <option value="<?php echo $profil['id_profil']; ?>" <?php select_option('id_profil', $profil['id_profil'], $id_profil_user);?>>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php echo $profil['libelle_profil']; ?>
                                                    </option>
                                                  <?php endforeach; //fin foreach ?>
                                                </select>
                                            </div>

                                            <!-- ******************************************
                                            ***************** CONFIRMER LE MOT DE PASSE ***
                                            ******************************************* -->
                                            <div class="col-md-4 col-sm-4 col-xs-12"
                                              style="padding-top: 8px">
                                              <label class="col-md-12 col-sm-12 col-xs-12">
                                                Mot de passe de confirmation
                                              </label>
                                              <span class="fa fa-lock form-control-feedback right"></span>
                                              <input type="password" name="password2_modifier"
                                                style="height: 25px;border-radius: 3px 3px 3px 3px;padding-top:1px"
                                                id="<?php echo $row['id_user'];?>"
                                                class="form-control has-feedback-left password2_modifier"
                                                placeholder="Mot de passe de confirmation">
                                                <b class="pass2_modifier"></b>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-dark btn-xs navbar-left"
                                              type="button" data-dismiss="modal">
                                              <span class="fa fa-times" style="color: #FFFFFF"></span>
                                                Fermer
                                            </button>

                                            <button class="btn btn-primary btn-xs" type="reset">
                                                <span class="fa fa-repeat" style="color: #FFFFFF"></span>
                                                Réinitialiser
                                            </button>

                                            <button type="submit" id="bouton_modifier"
                                              name="bouton_modifier" class="btn btn-success btn-xs">
                                              <span class="glyphicon glyphicon-floppy-save" style="color: #FFFFFF"></span>
                                              Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
            } //fin foreach
         ?>
     </tbody>
</table>
<?php
}//fin if rowcount > 0
else
{
    echo "Aucun enregistrement";
}//fin else

	echo $pagination;
?>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("table#tab").tablesorter();
    });
</script>
<style>
    #tab thead th:hover{
        cursor: pointer;
        background-color: #163251;
    }
</style>

<script>
    $(function(){
        // avec le mot passe
        $(".password_modifier").keyup(function(){
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
        $(".password2_modifier").keyup(function(){
            var id = $(this).attr('id');

            if($(this).val() != $('#passeUser'+id).val()){
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
        $('.formulaire').on('submit', function(e){
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
