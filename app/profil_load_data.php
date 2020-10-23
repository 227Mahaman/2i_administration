<?php
        include_once("profil_db_manager.php");
        include_once("action_db_manager.php");

        $critere = " true ";  
        if(isset($_POST['libelle_profil2'])){
            $libelle_profil = $_POST['libelle_profil2'];
            if(!empty($libelle_profil)) $critere = $critere . " and libelle_profil like '$libelle_profil%' ";
   
        }//fin if isset
        
	$sqlQuery = select_profil($critere);
	$count = $sqlQuery->rowCount();

	$adjacents = 2;
	$records_per_page = 100;
	
	$page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
	$page = ($page == 0 ? 1 : $page);
	$start = ($page-1) * $records_per_page;
	
	$next = $page + 1;    
	$prev = $page - 1;
	$last_page = ceil($count/$records_per_page);
	$second_last = $last_page - 1; 

	
	$pagination = "";
	if($last_page > 1){
        $pagination .= "<div class='pagination col-lg-12'>";
        if($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>&laquo; Prem</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Prem</span>";
		
		if ($page > 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($prev).");'>&laquo; Prec&nbsp;&nbsp;</a>";
        else
            $pagination.= "<span class='disabled'>&laquo; Prec&nbsp;&nbsp;</span>";   
		
        if ($last_page < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $last_page; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class='current'>$counter</span>";
                else
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
                         
            }
        }
        elseif($last_page > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
            {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
                }
                $pagination.= "...";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'> $second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   
           
           }
           elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
               $pagination.= "...";
               for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
               {
                   if($counter == $page)
                       $pagination.= "<span class='current'>$counter</span>";
                   else
                       $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
               }
               $pagination.= "..";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'>$second_last</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   
           }
           else
           {
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
               $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
               $pagination.= "..";
               for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
               {
                   if($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                   else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
               }
           }
        }
        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($next).");'>Suiv &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Next &raquo;</span>";
		
		if($page < $last_page)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>Dern &raquo;</a>";
        else
            $pagination.= "<span class='disabled'>Dern &raquo;</span>";
        
        $pagination.= "</div>";       
    }


$records = select_profil_per_page($start, $records_per_page, $critere);
$count = $records->rowCount();

if($count > 0)
{	
?>

    <table class='table table-bordered table-striped table-condensed tbody' id="tab" style="margin-top:-2em">
        <thead class="BackCollor reciept">
        <th>&nbsp;&nbsp;<b class="verte">#</b>&nbsp;&nbsp;Index <i class="fa fa-unsorted pull-right hidden-print"></th>
            <th>&nbsp;&nbsp;<i class="fa fa-user verte"></i>&nbsp;&nbsp; Libellé du profil <i class="fa fa-unsorted pull-right hidden-print"></i></th>
            <th style="width: 150px">&nbsp;&nbsp;<i class="fa fa-cog verte"></i>&nbsp;&nbsp;Action</th>
		</thead>
		<tbody>
			<?php 
				$i = 0;
			    foreach($records as $row) {
			 ?>
				<tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo htmlentities(stripcslashes($row['libelle_profil']));?></td>
                    <td>
                        <!--=============================================================================
                             ===========================DETAIL DU PROFIL=================================
                             =============================================================================-->
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-success btn-xs" type="button" data-toggle="modal" title="Modifier le exercice comptable"
                                data-target=".<?php echo htmlentities(stripcslashes($row['id_profil']));?>detail">
                            <span class='glyphicon glyphicon-eye-open' style="color: #ffffff"></span>
                        </button>
                        <div tabindex="-1" class="modal fade bs-example-modal-sm <?php echo htmlentities(stripcslashes($row['id_profil']));?>detail" role="dialog" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header BackCollor">
                                        <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Détail du profil</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" id="form1" name="form1" method="post" class="reciept2">
                                            <table class='table table-bordered table-striped table-condensed' style="border-radius: 5px 5px 5px 5px"><br>
                                                <tr>
                                                    <td>
                                                        <label for="libelle_profil">Libellé du profil&nbsp;:&nbsp;&nbsp;</label>
                                                        <input type="hidden" id="id_profil" name="id_profil" class="form-control" required value="<?php echo htmlentities(stripcslashes($row['id_profil']));?>"/>
                                                        <span><?php echo htmlentities(stripcslashes($row['libelle_profil']));?></span>
                                                    </td>

                                                </tr>
                                            </table>

                                            <table class='table table-bordered table-striped table-condensed' id="tab">
                                                <thead class="BackCollor reciept">
                                                <th><b class="fa fa-star-half-o verte"></b>&nbsp;&nbsp;Module</th>
                                                <th><b class="fa fa-legal verte"></b>&nbsp;&nbsp;Libellé privilège</th>
                                                <th><b class="fa fa-comments-o verte"></b>&nbsp;&nbsp;Description privilège</th>
                                                <th><b class="fa fa-cogs verte"></b>&nbsp;&nbsp;Action</th>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $records2 = select_all_profil_actions($row['id_profil']);
                                                foreach($records2 as $row2) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities(stripcslashes($row2['libelle_groupe']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row2['libelle_action']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row2['description_action']));?></td>
                                                        <td>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" id="" name="liste_action[]" value="<?php echo htmlentities(stripcslashes($row2['id_action']));?>" checked="checked" disabled>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } //fin foreach
                                                ?>
                                                </tbody>
                                            </table>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--=============================================================================
                            ===========================MODIFICATION DU PROFIL============================
                            =============================================================================-->
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-dark btn-xs" type="button" data-toggle="modal" title="Modifier le exercice comptable"
                                data-target=".<?php echo htmlentities(stripcslashes($row['id_profil']));?>modifier">
                            <span class='glyphicon glyphicon-edit' style="color: #ffffff"></span>
                        </button>
                        <div tabindex="-1" class="modal fade bs-example-modal-sm <?php echo htmlentities(stripcslashes($row['id_profil']));?>modifier" role="dialog" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header BackCollor">
                                        <button class="close" type="button" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Modifier le profil</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $id_profil=$row['id_profil'];
                                        //recuperations des autres priviliges (qui ne font pas parti de ceux existant dans le profil)
                                        $records_2 = $pdo->query("SELECT a.id_groupe, libelle_groupe, id_action, libelle_action, description_action
                                         FROM action a, groupe_action g
                                         WHERE a.id_groupe=g.id_groupe 
                                         and id_action not in (SELECT id_action FROM profil_has_action WHERE id_profil=$id_profil)
                                         order by libelle_groupe");

                                        ?>

                                        <!--  formulaire de actions-->
                                        <form action="profil_consulter.php" id="form1" name="form1" method="post">
                                            <table class='table table-bordered table-striped table-condensed'>
                                                <tr>
                                                    <td>
                                                        <label for="libelle_profil">Libellé du profil&nbsp;&nbsp;:&nbsp;&nbsp;</label>
                                                        <input type="hidden" id="id_profil" name="id_profil" class="form-control"
                                                               required value="<?php echo htmlentities(stripcslashes($row['id_profil']));?>"/>
                                                        <input type="hidden" id="libelle_profil3" name="libelle_profil3"
                                                               value="<?php echo htmlentities(stripcslashes($row['libelle_profil']));?>">
                                                        <span><?php echo htmlentities(stripcslashes($row['libelle_profil']));?></span>

                                                </tr>
                                            </table>

                                            <table class='table table-bordered table-striped table-condensed' id="tab">
                                                <thead class="BackCollor reciept">
                                                <th><b class="fa fa-star-half-o verte"></b>&nbsp;&nbsp;Module</th>
                                                <th><b class="fa fa-legal verte"></b>&nbsp;&nbsp;Libellé privilège</th>
                                                <th><b class="fa fa-comments-o verte"></b>&nbsp;&nbsp;Description privilège</th>
                                                <th><b class="fa fa-cogs verte"></b>&nbsp;&nbsp;Action</th>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $records_1 = select_all_profil_actions($row['id_profil']);
                                                foreach($records_1 as $row1) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities(stripcslashes($row1['libelle_groupe']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row1['libelle_action']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row1['description_action']));?></td>
                                                        <td>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" name="liste_action[]"
                                                                class="flat"
                                                                value="<?php echo htmlentities(stripcslashes($row1['id_action']));?>" checked="">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } //fin foreach 1
                                                ?>

                                                <?php
                                                foreach($records_2 as $row1) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities(stripcslashes($row1['libelle_groupe']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row1['libelle_action']));?></td>
                                                        <td><?php echo htmlentities(stripcslashes($row1['description_action']));?></td>
                                                        <td>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="checkbox" name="liste_action[]"
                                                                class="flat"
                                                                value="<?php echo htmlentities(stripcslashes($row1['id_action']));?>" >
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } //fin foreach 2
                                                ?>
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button class="btn btn-dark btn-xs navbar-left" type="button" data-dismiss="modal">
                                                    <span class="fa fa-times" style="color: #FFFFFF"></span>
                                                    Fermer
                                                </button>
                                                <button class="btn btn-primary btn-xs" type="reset">
                                                    <span class="fa fa-refresh" style="color: #FFFFFF"></span>
                                                    Réinitialiser
                                                </button>
                                                <button type="submit" id="bouton_modifier" name="bouton_modifier"
                                                        class="btn btn-success btn-xs">
                                                    <span class="glyphicon glyphicon-floppy-save" style="color: #FFFFFF"></span>
                                                    Soumettre
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
    echo 'Aucun enregistrement trouvé';
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
        background: rgba(29, 34, 69, 0.73);
    }
</style>