<?php
	include 'connexion.php';

	echo md5('aaaaaa');
	// $pdo->query("");

	// $pdo->query("INSERT INTO action(id_groupe, libelle_action, description_action, url_action, ordre_affichage_action)
	// 	VALUES
		
	// 	(39, 'Ajouter type frais', 'Ajouter un type de frais','type_frais_nouveau.php',1),
	// 	(39, '', 'Supprimer un type de frais','type_frais_supprimer.php',''),
	// 	(39, '', 'Modifier un type de frais','type_frais_modifier.php',''),
	// 	(39, 'Liste type frais', 'Lister les types de frais','type_frais_consulter.php',2)");
	
	// $pdo->query("update groupe_action set libelle_groupe = 'Type de service', libelle_groupe_en = 'Type de service' where id_groupe=9");

	// $pdo->query("update action set libelle_action = 'Ajouter type service', description_action = 'Ajouter type service', url_action ='type_service_nouveau.php' where id_action=17");

	// $pdo->query("update action set libelle_action = 'Consulter type service', description_action = 'Consulter les types de service', url_action ='type_service_consulter.php' where id_action=18");

	// $pdo->query("update action set libelle_action = '', description_action = 'Modifier les types de service', url_action ='type_service_modifier.php' where id_action=70");

	// $pdo->query("update action set libelle_action = '', description_action = 'Supprimer les types de service', url_action ='type_service_supprimer.php' where id_action=71");

	// $pdo->query("INSERT INTO groupe_action(libelle_groupe, libelle_groupe_en, bloc_menu, ordre_affichage_groupe, icon_groupe) VALUES('Type de frais missiob','Les types de frais de mission','config', 30, '')");

	// $pdo->query("insert into profil_has_action(id_action, id_profil) values(56,1),(57,1)");

	// $pdo->query("update groupe_action set libelle_groupe = 'Gestion des congés' where id_groupe = 34");

	// $pdo->exec("INSERT INTO type_document_etat_civil(designation_type_document)
	//  			VALUES('Acte de naissance'), ('Acte de mariage'), ('Acte de décès'), ('Certificat de scolarité'),('Acte adoption')");

	// var_dump($_SERVER);

	// echo date('t', strtotime("2-2016"));

?>
