<?php
	include_once("app/core/user_db_manager.php");
	include_once("app/core/profil_db_manager.php");
    $title="Ajouter Utilisateur";
	ob_start();
	$user = "";
	//enregistrement des données du formulaire dans la base
	if (isset($_POST['bouton_envoyer'])) {
		$profil = echapper($_POST['id_profil']);
		$nom = echapper($_POST['nom_user']);
		$prenom = echapper($_POST['prenom_user']);
		$login = echapper($_POST['login']);
		$password = echapper(md5($_POST['password']));
		$user_conn = $_SESSION['id_user'];
      	//$date = date("Y-m-d H:i:s");
		$result = insert_user($profil, $nom, $prenom, $login, $password, $user_conn);
		//var_dump($result);die;
		
	} elseif (!empty($_GET['modif']) && ctype_digit($_GET['modif'])) {
		$id = $_GET['modif'];
		$user = select_user_one($id)->fetch();
		if (isset($_POST['btn_update'])) {
			$libelle = echapper($_POST['libelle_groupe']);
			$icon = echapper($_POST['icon_groupe']);
			$bloc = echapper($_POST['bloc_menu']);
			$ordre = echapper($_POST['ordre_affichage_groupe']);
			$update = update_user($id, $libelle, $icon, $bloc, $ordre);
			header('Location: index.php?p=user');
		}
	} elseif(isset($_POST['id_groupe'])){
		$id = $_POST['id_groupe'];
		$delete = delete_user($id);
		if($delete){
			header("Location: index.php?p=user");
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
		<div class="col-md-12">
			<div class="panel panel-default form">
				<div class="panel-heading">Renseignez les informations</div>
				<div class="panel-body">
					<!--<div class="col-md-6">-->
					<form role="form" method="post">
						<div class="form-group">
							<label>Nom</label>
							<input class="form-control" name="nom_user" value="<?= ($user)? $user['nom_user'] : "" ?>" placeholder="Nom d'utilisateur" required>
						</div>
						<div class="form-group">
							<label>Prénom</label>
							<input class="form-control" name="prenom_user" value="<?= ($user)? $user['prenom_user'] : "" ?>" placeholder="Prénom d'utilisateur" required>
						</div>
						<div class="form-group">
							<label>Login</label>
							<input class="form-control" name="login" value="<?= ($user)? $user['login'] : "" ?>" placeholder="Pseudo Login" required>
						</div>
						<div class="form-group">
							<label>Mot de passe</label>
							<input class="form-control" type="password" name="password" value="<?= ($user)? $user['password'] : "" ?>" placeholder="Mot de passe" required>
						</div>
						<div class="form-group">
							<label>Selects</label>
							<select class="form-control" name="id_profil" required>
								<?php
									$records = select_profil(true);
									foreach($records as $row) {
								?>
								<option value="<?= $row['id_profil']?>"><?= $row['libelle_profil']?></option>
								<?php } ?>
							</select>
						</div>
						<button type="submit" id="bouton_envoyer" name="<?= (isset($_GET['modif']))? "btn_update" : "bouton_envoyer";?>" class="btn btn-primary">Enregistrer</button>
					</form>
				</div>
			</div>
		</div><!-- /.panel-->
	</div>
</div>	<!--/.main-->
<?php
    $content = ob_get_clean();
    require('template.php');
?>