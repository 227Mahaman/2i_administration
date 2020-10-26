<?php
	include_once("app/core/action_db_manager.php");
    $title="Menu";
	ob_start();
	$menu = "";
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
		$menu = select_menu_one($id)->fetch();
		if (isset($_POST['btn_update'])) {
			$groupe = echapper($_POST['id_groupe']);
			$libelle = echapper($_POST['libelle_action']);
			$description = echapper($_POST['description_action']);
			$url = echapper($_POST['url_action']);
			$ordre = echapper($_POST['ordre_affichage_action']);
			$update = update_menu($id, $groupe, $libelle, $description, $url, $ordre);
			header('Location: index.php?p=menu');
		}
	} elseif(isset($_POST['id_groupe'])){
		$id = $_POST['id_groupe'];
		$delete = delete_menu($id);
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
							<input class="form-control" name="libelle_action" value="<?= ($menu)? $menu['libelle_action'] : "" ?>" placeholder="Titre du menu (action)">
						</div>
						<div class="form-group">
							<label>Description</label>
							<input class="form-control" name="description_action" value="<?= ($menu)? $menu['description_action'] : "" ?>" placeholder="Description du menu">
						</div>
						<div class="form-group">
							<label>Url</label>
							<input class="form-control" name="url_action" value="<?= ($menu)? $menu['url_action'] : "" ?>" placeholder="URL du menu">
						</div>
						<div class="form-group">
							<label>Ordre</label>
							<input class="form-control" name="ordre_affichage_action" value="<?= ($menu)? $menu['ordre_affichage_action'] : "" ?>" placeholder="ordre affichage action">
						</div>
						<div class="form-group">
							<label>Groupe (Module)</label>
							<select class="form-control">
								<?php
									$records = select_all_groupes();
									foreach($records as $row) {
								?>
									<option <?= (isset($_GET['modif']) && $value['id_groupe'] == $menu['id_groupe'])? "selected" : "" ?> value="<?= $row['id_groupe']?>"><?= $row['libelle_groupe']?></option>
								<?php } ?>
							</select>
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
					<!--<div class="col-md-12">-->
						<!--<table class="table table-bordered table-striped table-condensed tbody">-->
						<table class="table table-condensed">
							<thead>
								<th>#</th>
								<th>Menu</th>
								<th>Description</th>
								<th>URL</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
									$i = 0;
									$records = select_all_menus();
									foreach($records as $row) {
								?>
								<tr>
								<td><?= ++$i;?></td>
									<td><?= htmlentities(stripcslashes($row['libelle_action']));?></td>
									<td><?= htmlentities(stripcslashes($row['description_action']));?></td>
									<td><?= htmlentities(stripcslashes($row['url_action']));?></td>
									<td>
										<!--<a href="index.php?p=menu&profil=<?//= htmlentities(stripcslashes($row['id_groupe'])); ?>" class="btn btn-success">
                                            <i class="fa fa-plus"></i>
                                        </a>-->
										<a href="index.php?p=menu&modif=<?= htmlentities(stripcslashes($row['id_action'])); ?>" class="btn btn-primary">
											<i class="fa fa-pencil"></i>
										</a>
										<form method="post">
											<input type="hidden" name="id_action" value="<?= htmlentities(stripcslashes($row['id_action'])); ?>">
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