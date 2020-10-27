<?php
	include_once("app/core/action_db_manager.php");
	include_once("app/core/profil_db_manager.php");
    $title="Menu";
	ob_start();
	$menu = "";
	//enregistrement des données du formulaire dans la base
	if (isset($_POST['bouton_envoyer'])) {//Ajout menu
		$groupe = echapper($_POST['id_groupe']);
		$libelle = echapper($_POST['libelle_action']);
		$description = echapper($_POST['description_action']);
		$url = echapper($_POST['url_action']);
		$ordre = echapper($_POST['ordre_affichage_action']);
		$result = insert_menu($groupe, $libelle, $description, $url, $ordre);
		
	} elseif (!empty($_GET['modif']) && ctype_digit($_GET['modif'])) {//Modification de menu
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
	} elseif(isset($_POST['id_action'])){//Suppression de menu
		$id = $_POST['id_action'];
		$delete = delete_menu($id);
		if($delete){
			header("Location: index.php?p=menu");
		}
	} elseif (isset($_GET['profil'])){//Rôle (Profil)
		extract($_GET);
		if(!empty($_POST)){
			$menu = $_POST['menu'];
			$add = insert_menu_profil($profil, $menu);
			if($add){
				header('Location: index.php?p=menu&profil='.$profil);
			}
		// } elseif(isset($menu)){
		// 	//var_dump($_POST);die;
		// }
		$profil = select_profil_one($profil)->fetch();
	} elseif (isset($_GET['detail'])){//Detail (Profil)
		extract($_GET);
		$profil = select_profil_one($detail)->fetch();
	}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="<?= (isset($_GET['profil']) || isset($_GET['detail'])) ? '' : 'active'?>"><?= $title;?></li>
			<?php if (isset($_GET['profil']) || isset($_GET['detail'])) : ?>
				<li class="active">Profil <?= $profil['libelle_profil']?></li>
			<?php endif;?>
		</ol>
	</div><!--/.row-->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?//= $title;?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<?php if (!isset($_GET['profil']) && !isset($_GET['detail'])) : ?>
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
							<select class="form-control" name="id_groupe">
								<?php
									$records = select_all_groupes();
									foreach($records as $row) {
								?>
									<option <?= (isset($_GET['modif']) && $row['id_groupe'] == $menu['id_groupe'])? "selected" : "" ?> value="<?= $row['id_groupe']?>"><?= $row['libelle_groupe']?></option>
								<?php } ?>
							</select>
						</div>
						<button type="submit" id="bouton_envoyer" name="<?= (isset($_GET['modif']))? "btn_update" : "bouton_envoyer";?>" class="btn btn-primary">Enregistrer</button>
					</form>
				</div>
			</div>
		</div><!-- /.panel-->
		<?php endif; ?>
		
		<div class="<?= (isset($_GET['profil']) || isset($_GET['detail'])) ? 'col-md-12' : 'col-md-8' ?>">
			<div class="panel panel-default">
				<div class="panel-heading"><?= isset($_GET['profil']) || isset($_GET['detail']) ? "Menu: Profil" : 'Données' ?></div>
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
									if(isset($_GET['detail'])){
										$records = select_all_profil_menus($_GET['detail']);
									} else{
										$records = select_all_menus();
									}
									foreach($records as $row) {
										if(isset($_GET['profil'])){//Vérification
											$actProfil = select_profil_menu($_GET['profil'],$row['id_action'])->fetch();
										}
								?>
								<tr>
								<td><?= ++$i;?></td>
									<td><?= htmlentities(stripcslashes($row['libelle_action']));?></td>
									<td><?= htmlentities(stripcslashes($row['description_action']));?></td>
									<td><?= htmlentities(stripcslashes($row['url_action']));?></td>
									<td>
										<?php if (isset($_GET['profil'])) : ?>
                                            <form method="post">
                                            <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                <label>
                                                    <!--<input type="hidden" name="id_profil" value="<?//= $_GET['profil']; ?>">-->
                                                    <!-- name="menu" onchange="submit()" || onchange="addMenuProfil(this)" -->
                                                    <input class="module_is_checked" id="id_action" name="menu" onchange="submit()" value="<?= $row['id_action'] ?>" type="checkbox" <?= (isset($actProfil['id_action']) && $actProfil['id_action']==$row['id_action']) ? 'checked' : '';?> <?= (isset($_GET['detail'])) ? 'disabled' : '';?> > ajouter au profil
                                                </label>
                                                </div>
                                            </div>
                                            </div>
											</form>
											<?php elseif (isset($_GET['detail'])) : ?>
                                            <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                <label>
                                                    <input value="<?= $row['id_action'] ?>" type="checkbox" checked disabled > ajouter au profil
                                                </label>
                                                </div>
                                            </div>
                                            </div>
                                        <?php else : ?>
											<a href="index.php?p=menu&modif=<?= htmlentities(stripcslashes($row['id_action'])); ?>" class="btn btn-primary">
												<i class="fa fa-pencil"></i>
											</a>
											<form method="post">
												<input type="hidden" name="id_action" value="<?= htmlentities(stripcslashes($row['id_action'])); ?>">
												<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
											</form>
										<?php endif; ?>
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