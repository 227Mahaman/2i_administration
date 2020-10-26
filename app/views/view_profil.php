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
				<div class="panel-heading">Données</div>
				<div class="panel-body">
						<table class="table table-condensed">
							<thead>
								<th>#</th>
								<th>Libellé</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
									$i = 0;
									$records = select_profil(true);
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
					<!--</div>-->
				</div>
			</div><!-- /.panel-->
		</div><!-- /.col-->
	</div>
</div>	<!--/.main-->
<?php
    $content = ob_get_clean();
    require('template.php');
?>