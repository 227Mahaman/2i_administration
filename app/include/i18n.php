<?php
	// langue par defaut est le francais
	if(empty($_SESSION['lang'])){
		$_SESSION['lang']	=	'fr';
	}
	// choix de langue
	else if(!empty($_GET['lang'])){
		$lang_autorisee	=['fr', 'en'];

		if(in_array($_GET['lang'], $lang_autorisee)){
			$_SESSION['lang']	=	$_GET['lang'];
		}
	}


	// parametrage de certains noms commun
	$commun = [
			'reset' 	=> ['fr' => 'Réinitialiser', 'en' => 'Reset'],
			'submit' 	=> ['fr' => 'Enregistrer', 'en' => 'Submit'],
			'add' 		=> ['fr' => 'Ajouter', 'en' => 'Add'],
			'consulter' => ['fr' => 'Consulter', 'en' => 'Consult'],
			'enter' 	=> ['fr' => 'Entrez ', 'en' => 'Enter the '],
			'first' 	=> ['fr' => 'Première', 'en' =>'First'],
			'last' 		=> ['fr' => 'Dernière', 'en' =>'Last'],
			'next' 		=> ['fr' => 'Suivante', 'en' =>'Next'],
			'previous' 	=> ['fr' => 'Précedente', 'en' =>'Previous'],
			'fermer' 	=> ['fr' => 'Fermer', 'en' =>'Close'],
			'search' 	=> ['fr' => 'Rechercher', 'en' =>'Search'],
			'choisir' 	=> ['fr' => 'Choisir', 'en' =>'Choose'],
			'modifier' 	=> ['fr' => 'Modifier', 'en' =>'Modify'],
			'supprimer' => ['fr' => 'Supprimer', 'en' =>'Delete'],
			'aucun_enregistrement' 	=> ['fr' => 'Aucun enregistrement trouvé', 'en' =>'No record found'],
			'mot_cle' 	=> ['fr' => 'Entrez le mot clé', 'en' =>'Enter the keyword'],
			'confirm_suppression' => ['fr' => 'Etes-vous sur de vouloir le supprimer???', 'en' =>'Are you sure you want to delete it ???']
	];




	// parametrage des grands traits du menu
	$menu = [
			'profil' 		=> ['fr' => 'Profil', 'en' => 'Profile'], 
			'config' 		=> ['fr' => 'Configuration', 'en' => 'Configuration'], 
			'aide' 			=> ['fr' => 'Aide', 'en' => 'Assistant'], 
			'deconnexion' 	=> ['fr' => 'Déconnexion', 'en' => 'Logout'], 
			'agrandir' 		=> ['fr' => 'Agrandir', 'en' => 'Enlarge'], 
			'reduire' 		=> ['fr' => 'Réduire', 'en' => 'Reduce']
	];





	// le parametrage de la partie gestion des utilisateurs
	$user = [
			'users'			=>['fr'	=> 'Utilisateurs', 'en'=> 'Users'],
			'consulter'		=>['fr'	=> 'Consulter', 'en'=> 'Consult'],
			'ajouter'		=>['fr'	=> 'Ajouter', 'en'=> 'Add'],
			'new_user'		=>['fr'	=> 'Nouvel utilisateur', 'en'=> 'New user'],
			'nom'			=>['fr'	=> 'Nom', 'en'=> 'Name'],
			'prenom'		=>['fr'	=> 'Prénom', 'en'=> 'First name'],
			'login'			=>['fr'	=> 'Login', 'en'=> 'Login'],
			'passe'			=>['fr'	=> 'Mot de passe', 'en'=> 'Password'],
			'profil'		=>['fr'	=> 'Profil', 'en'=> 'Profile'],
			'passe_confirm'	=>['fr'	=> 'Mot de passe de confirmation', 'en'=> 'Confirmation password'],
			'profil'		=>['fr'	=> 'Profil', 'en'=> 'Profile'],
			'choisir'		=>['fr'	=> 'Choisir', 'en'=> 'Choose'],
			'liste'			=>['fr'	=> 'Liste des utilisateurs', 'en'=> 'List of users'],
			'edit_user'		=>['fr'	=> 'Modifier l\'utilisateur', 'en'=> 'Edit a user'],
			'choisir'		=>['fr'	=> 'Choisir', 'en'=> 'Choose']
	];



	// le parametrage de la partie gestion des profils
	$profil = [
			'profil'			=>['fr'	=> 'Profil', 'en'=> 'Profile'],
			'add'				=>['fr'	=> 'Ajouter', 'en'=> 'Add'],
			'new_profile'		=>['fr'	=> 'Nouveau profil', 'en'=> 'New profile'],
			'nom_profil'		=>['fr'	=> 'Nom du profil', 'en'=> 'Profile name'],
			'liste_profil'		=>['fr'	=> 'Liste des profils', 'en'=> 'List of profiles'],
			'detail_profil'		=>['fr'	=> 'Détail du profil', 'en'=> 'Profile detail'],
			'nom_privilege'		=>['fr'	=> 'Libellé privilège', 'en'=> 'Privilege label'],
			'desc_privilege'	=>['fr'	=> 'Description privilège', 'en'=> 'Privilege description'],
			'modifier_profil'	=>['fr'	=> 'Modifier le profil', 'en'=> 'Modify the profile']
			
	];




	// le parametrage de la partie gestion des services
	$service = [
			'nouveau_service'	=>['fr'	=> 'Nouveau service', 'en'=> 'New service'],
			'code_service'		=>['fr'	=> 'Code service', 'en'=> 'Service code'],
			'designation'		=>['fr'	=> 'Désignation service', 'en'=> 'Service designation'],
			'nom_service'		=>['fr'	=> 'Libellé service', 'en'=> 'Service wording'],
			'liste_service'		=>['fr'	=> 'Liste des services', 'en'=> 'List of services'],
			'modifier_service'	=>['fr'	=> 'Modifier service', 'en'=> 'Edit service']
	];



	// le parametrage de la partie gestion des qualifications
	$qualific = [
			'nouvel_qualific'	=>['fr'	=> 'Nouvelle qualification', 'en'=> 'New qualification'],
			'code_qualific'		=>['fr'	=> 'Code qualification', 'en'=> 'Qualification code'],
			'designation'		=>['fr'	=> 'Désignation qualification', 'en'=> 'Qualification designation'],
			'nom_qualific'		=>['fr'	=> 'Libellé qualification', 'en'=> 'Qualification label'],
			'liste_qualific'	=>['fr'	=> 'Liste des qualification', 'en'=> 'List of qualifications'],
			'modifier_qualific'	=>['fr'	=> 'Modifier qualification', 'en'=> 'Edit qualification']
	];


	// le parametrage de la partie gestion des etablissements
	$etab = [
			'nouvel_etab'	=>['fr'	=> 'Nouvel établissement', 'en'=> 'New establishment'],
			'code_etab'		=>['fr'	=> 'Code établissement', 'en'=> 'Establishment code'],
			'designation'		=>['fr'	=> 'Désignation établissement', 'en'=> 'Establishment designation'],
			'nom_etab'		=>['fr'	=> 'Libellé établissement', 'en'=> 'Establishment label'],
			'liste_etab'	=>['fr'	=> 'Liste des établissements', 'en'=> 'List of establishments'],
			'modifier_etab'	=>['fr'	=> 'Modifier établissement', 'en'=> 'Edit establishment'],
			'etab'			=>['fr'	=> 'Etablissement', 'en'=> 'Establishment']
	];



	// le parametrage de la partie gestion des emploi
	$emploi = [
			'nouvel_emploi'	=>['fr'	=> 'Nouvel emploi', 'en'=> 'New employment'],
			'code_emploi'	=>['fr'	=> 'Code emploi', 'en'=> 'Employment code'],
			'designation'	=>['fr'	=> 'Désignation emploi', 'en'=> 'Employment designation'],
			'nom_emploi'		=>['fr'	=> 'Libellé emploi', 'en'=> 'Employment label'],
			'liste_emploi'	=>['fr'	=> 'Liste des emplois', 'en'=> 'List of Employments'],
			'modifier_emploi'=>['fr'	=> 'Modifier emploi', 'en'=> 'Edit Employment'],
			'emploi'		=>['fr'	=> 'Emploi', 'en'=> 'Employment']
	];



	// le parametrage de la partie gestion des divisions
	$division = [
			'nouvel_division'	=>['fr'	=> 'Nouvelle division', 'en'=> 'New division'],
			'code_division'		=>['fr'	=> 'Code division', 'en'=> 'Division code'],
			'designation'		=>['fr'	=> 'Désignation division', 'en'=> 'Division designation'],
			'nom_division'		=>['fr'	=> 'Libellé division', 'en'=> 'Division label'],
			'liste_division'	=>['fr'	=> 'Liste des divisions', 'en'=> 'List of divisions'],
			'modifier_division'	=>['fr'	=> 'Modifier division', 'en'=> 'Edit division'],
			'division'			=>['fr'	=> 'division', 'en'=> 'Division']
	];


	// le parametrage de la partie gestion des departement
	$departe = [
			'nouveau_departe'	=>['fr'	=> 'Nouvel département', 'en'=> 'New department'],
			'code_departe'		=>['fr'	=> 'Code département', 'en'=> 'department code'],
			'designation'		=>['fr'	=> 'Désignation département', 'en'=> 'Department designation'],
			'nom_departe'		=>['fr'	=> 'Libellé département', 'en'=> 'Department label'],
			'liste_departe'		=>['fr'	=> 'Liste des départements', 'en'=> 'List of departments'],
			'modifier_departe'	=>['fr'	=> 'Modifier département', 'en'=> 'Edit department'],
			'departe'			=>['fr'	=> 'Département', 'en'=> 'Department']
	];


	// le parametrage de la partie gestion des civilites
	$civilite = [
			'nouvel_civilite'	=>['fr'	=> 'Nouvelle civilité', 'en'=> 'New civility'],
			'code_civilite'		=>['fr'	=> 'Code civilité', 'en'=> 'Civility code'],
			'designation'		=>['fr'	=> 'Désignation civilité', 'en'=> 'Civility designation'],
			'nom_civilite'		=>['fr'	=> 'Libellé civilité', 'en'=> 'Civility label'],
			'liste_civilite'	=>['fr'	=> 'Liste des civilités', 'en'=> 'List of civility'],
			'modifier_civilite'	=>['fr'	=> 'Modifier civilité', 'en'=> 'Edit Civility'],
			'civilite'			=>['fr'	=> 'civilité', 'en'=> 'Civility']
	];



	// le parametrage de la partie gestion des departement
	$categorie = [
			'nouvel_categorie'	=>['fr'	=> 'Nouvelle catégorie', 'en'=> 'New category'],
			'code_categorie'		=>['fr'	=> 'Code catégorie', 'en'=> 'Category code'],
			'designation'		=>['fr'	=> 'Désignation catégorie', 'en'=> 'Category designation'],
			'nom_categorie'		=>['fr'	=> 'Libellé catégorie', 'en'=> 'Category label'],
			'liste_categorie'	=>['fr'	=> 'Liste des catégories', 'en'=> 'List of category'],
			'modifier_categorie'	=>['fr'	=> 'Modifier catégorie', 'en'=> 'Edit category'],
			'categorie'			=>['fr'	=> 'catégorie', 'en'=> 'Category']
	];
?>