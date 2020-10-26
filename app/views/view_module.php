<?php
	include_once("app/core/module_db_manager.php");
    $title="Module";
	ob_start();
	$module = "";
	//enregistrement des données du formulaire dans la base
	if (isset($_POST['bouton_envoyer'])) {
		$libelle = echapper($_POST['libelle_groupe']);
		$icon = echapper($_POST['icon_groupe']);
		$bloc = echapper($_POST['bloc_menu']);
		$ordre = echapper($_POST['ordre_affichage_groupe']);
		$result = insert_module($libelle, $icon, $bloc, $ordre);
		//var_dump($result);die;
		
	} elseif (!empty($_GET['modif']) && ctype_digit($_GET['modif'])) {
		$id = $_GET['modif'];
		$module = select_module_one($id)->fetch();
		if (isset($_POST['btn_update'])) {
			$libelle = echapper($_POST['libelle_groupe']);
			$icon = echapper($_POST['icon_groupe']);
			$bloc = echapper($_POST['bloc_menu']);
			$ordre = echapper($_POST['ordre__affichage_groupe']);
			$update = update_module($id, $libelle, $icon, $bloc, $ordre);
			header('Location: index.php?p=module');
		}
	} elseif(isset($_POST['id_groupe'])){
		$id = $_POST['id_groupe'];
		$delete = delete_module($id);
		if($delete){
			header("Location: index.php?p=module");
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
					<!--<div class="col-md-6">-->
					<form role="form" method="post">
						<div class="form-group">
							<label>Libellé</label>
							<input class="form-control" name="libelle_groupe" value="<?= ($module)? $module['libelle_groupe'] : "" ?>" placeholder="Titre du module (Groupe)">
						</div>
						<div class="form-group">
							<label>Icon</label>
							<input class="form-control" name="icon_groupe" value="<?= ($module)? $module['icon_groupe'] : "" ?>" placeholder="fa fa-example">
						</div>
						<div class="form-group">
							<label>Bloc</label>
							<input class="form-control" name="bloc_menu" value="<?= ($module)? $module['bloc_menu'] : "" ?>" placeholder="Bloc du menu">
						</div>
						<div class="form-group">
							<label>Ordre</label>
							<input class="form-control" name="ordre_affichage_groupe" value="<?= ($module)? $module['ordre_affichage_groupe'] : "" ?>" placeholder="Ordre affichage groupe">
						</div>
						<!--<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control">
						</div>
						<div class="form-group">
							<label>Selects</label>
							<select class="form-control">
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
								<option>Option 4</option>
							</select>
						</div>-->
						<button type="submit" id="bouton_envoyer" name="<?= (isset($_GET['modif']))? "btn_update" : "bouton_envoyer";?>" class="btn btn-primary">Enregistrer</button>
						<!--<button type="reset" class="btn btn-default">Reset Button</button>-->
					</form>
				</div>
			</div>
		</div><!-- /.panel-->
		
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">Données</div>
				<div class="panel-body">
					<!--<div class="col-md-12">-->
						<!--<table class="table table-bordered table-striped table-condensed tbody">-->
						<table class="table table-condensed">
							<thead>
								<th>#</th>
								<th>Libellé</th>
								<th>Icon</th>
								<th>Bloc</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
									$i = 0;
									$records = select_module(true);
									foreach($records as $row) {
								?>
								<tr>
								<td><?= ++$i;?></td>
									<td><?= htmlentities(stripcslashes($row['libelle_groupe']));?></td>
									<td><?= htmlentities(stripcslashes($row['icon_groupe']));?></td>
									<td><?= htmlentities(stripcslashes($row['bloc_menu']));?></td>
									<td>
										<!--<a href="index.php?p=menu&profil=<?//= htmlentities(stripcslashes($row['id_groupe'])); ?>" class="btn btn-success">
                                            <i class="fa fa-plus"></i>
                                        </a>-->
										<a href="index.php?p=module&modif=<?= htmlentities(stripcslashes($row['id_groupe'])); ?>" class="btn btn-primary">
											<i class="fa fa-pencil"></i>
										</a>
										<form method="post">
											<input type="hidden" name="id_groupe" value="<?= htmlentities(stripcslashes($row['id_groupe'])); ?>">
											<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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