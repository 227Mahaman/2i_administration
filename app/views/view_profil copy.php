<?php
include_once("app/core/profil_db_manager.php");
include_once("app/core/action_db_manager.php");
    $title="Profil";
	ob_start();
	$profil = "";
	//enregistrement des données du formulaire dans la base
	if (isset($_POST['bouton_envoyer'])) {
		$libelle_profil = echapper($_POST['libelle_profil']);
		
		$id_user_conn = $_SESSION['id_user'];
		//$date = date("Y-m-d H:i:s");
		
		$result = insert_profil($libelle_profil, $id_user_conn);
	} elseif (!empty($_GET['modif']) && ctype_digit($_GET['modif'])) {
		$id = $_GET['modif'];
		$profil = select_profil_one($id)->fetch();
		if (isset($_POST['btn_update'])) {
			$libelle = echapper($_POST['libelle_profil']);
			$date = date("Y-m-d H:i:s");
			$update = update_profil($id, $libelle, $_SESSION['id_user'],	$date);
			header('Location: index.php?p=profil');
		}
	} elseif(isset($_POST['id_profil'])){
		$id = $_POST['id_profil'];
		$delete = delete_profil($id);
		if($delete){
			header("Location: index.php?p=profil");
		}
	}
	//Gestion de pagination
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
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"><?= $title;?></li>
		</ol>
	</div><!--/.row-->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?//= $title;?></h1>
		</div>
	</div><!--/.row-->
	<!--<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-center">
						<div class="row no-padding">
							<div class="large">120</div>
							<div class="text-muted">New Orders</div>
						</div>
					</div>
				</div>
			</div>--><!--/.row-->
		<!--</div>-->
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default form">
				<div class="panel-heading">Renseignez les informations</div>
				<div class="panel-body">
					<form role="form" method="post">
						<div class="form-group">
							<label>Libellé</label>
							<input class="form-control" name="libelle_profil" value="<?= ($profil)? $profil['libelle_profil'] : "" ?>" placeholder="Titre du profil">
						</div>
						<button type="submit" id="bouton_envoyer" name="<?= (isset($_GET['modif']))? "btn_update" : "bouton_envoyer";?>" class="btn btn-primary">Enregistrer</button>
					</form>
				</div>
			</div>
		</div><!-- /.panel-->
		
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-md-3 col-sm-3 col-xs-12" style="padding-top: 8px">
						<span class="fa fa-user form-control-feedback left"
							aria-hidden="true">
						</span>
    					<input type="text" id="libelle_profil2" required="required" class="form-control has-feedback-left" style="height: 23px;width:250px;border-radius: 3px 3px 3px 3px;padding-top:1px" name="libelle_profil2" placeholder="Entrez le nom  du profil">
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12" style="padding-top:9px">
						<button class="btn btn-info btn-xs" id="btn_search" name="btn_search" type="button">
							<span class="glyphicon glyphicon-search " style="color: #FFFFFF"></span> Rechercher
						</button>
					</div>
				</div>
				<div class="panel-body">
						<?php
							$records = select_profil_per_page($start, $records_per_page, $critere);
							$count = $records->rowCount();
							if($count > 0)
							{	?>
							<table id="page_data" class="table table-condensed">
								<thead>
									<th>#</th>
									<th>Libellé</th>
									<th>Action</th>
								</thead>
								<tbody>
									<?php
										$i = 0;
										//$records = select_profil(true);
										foreach($records as $row) {
									?>
									<tr>
									<td><?= ++$i;?></td>
										<td><?= htmlentities(stripcslashes($row['libelle_profil']));?></td>
										<td>
											<a href="index.php?p=menu&profil=<?= htmlentities(stripcslashes($row['id_profil'])); ?>" title="Ajouter des menu au profil" class="btn btn-success">
												<i class="fa fa-plus"></i>
											</a>
											<a href="index.php?p=menu&detail=<?= htmlentities(stripcslashes($row['id_profil'])); ?>" title="Voir l'ensemble des menu" class="btn btn-info">
												<i class="fa fa-eye"></i>
											</a>
											<a href="index.php?p=profil&modif=<?= htmlentities(stripcslashes($row['id_profil'])); ?>" title="Modifier le profil" class="btn btn-primary">
												<i class="fa fa-pencil"></i>
											</a>
											<form method="post">
												<input type="hidden" name="id_profil" value="<?= htmlentities(stripcslashes($row['id_profil'])); ?>">
												<button type="submit" title="Supprimer le profil" class="btn btn-danger"><i class="fa fa-trash"></i></button>
											</form>
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
					<!--</div>-->
				</div>
			</div><!-- /.panel-->
		</div><!-- /.col-->
	</div>
</div>	<!--/.main-->
<script type="text/javascript">
$(document).ready(function(){
	change_page('0');

	//gestion du click du btn rechercher
	$("#btn_search").click(function(){	
		var page_id = 0;
		var libelle_profil2 = $("#libelle_profil2").val();

		// au lancement de la fonction ajax
		$(document).ajaxStart(function(){
			$('.spinner').css('display','inline-table');
		});

		// au lancement de la fonction ajax
		$(document).ajaxStop(function(){
			$('.spinner').css('display','none');
		});

		var dataString = 'page_id='+page_id+'&libelle_profil2='+libelle_profil2;
		$.ajax({
			type: "POST",
			url: "index.php?p=profil",
			data: dataString,
			cache: false,
			success: function(result){
			$(".flash").hide();
			$("#page_data").html(result);
			}
		});//fin ajax
	}); //fin click btn_search
});

function change_page(page_id){
	var dataString = 'page_id='+ page_id;

	// au lancement de la fonction ajax
	$(document).ajaxStart(function(){
		$('.spinner').css('display','inline-table');
	});

	// au lancement de la fonction ajax
	$(document).ajaxStop(function(){
		$('.spinner').css('display','none');
	});

	$.ajax({
		type: "POST",
		url: "index.php?p=profil",
		data: dataString,
		cache: false,
		success: function(result){
			$(".flash").hide();
			$("#page_data").html(result);
		}
	});
} //fin fonction change_page
</script>
<?php
    $content = ob_get_clean();
    require('template.php');
?>