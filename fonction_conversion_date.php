<?php 

	//fonction de conversion du format de la date pour l'adapter aux utilisateurs
        function convert_date_to_human($date_mysql){
            if(isset($date_mysql) & !empty($date_mysql))
            {
                //separation des elements de la date pour reorganisation
                $tab1 = explode('-',$date_mysql);
                $annee = $tab1[0];
                $mois = $tab1[1];
                $jour = $tab1[2];
                //reconstitution de la date au format utilisateur
                $date_humain = $jour."/".$mois."/".$annee ;
                return $date_humain ;
            }
        }//fin fonction convert_date_to_human
			
        //fonction de conversion du format de la date pour l'adapter aux utilisateurs
        function convert_datetime_to_human($date_mysql){
            if(isset($date_mysql) & !empty($date_mysql))
            {
                //separation de la date et de l'heure
                $tab1 = explode(' ',$date_mysql);
                $date = $tab1[0];
                $heure = $tab1[1];
                //separation des elements de la date pour reorganisation
                $tab2 = explode('-',$date);
                $annee = $tab2[0];
                $mois = $tab2[1];
                $jour = $tab2[2];
                //reconstitution de la date au format utilisateur
                $date_humain = $jour."/".$mois."/".$annee." ".$heure ;
                return $date_humain ;
            }
        } //fin fonction convert_datetime_to_human

    //fonction de conversion du format de la date pour l'adapter à MySQL
    function convert_datetime_to_mysql($date_humain){
        if(isset($date_humain) & !empty($date_humain))
        {
            //separation de la date et de l'heure
            $tab1 = explode(' ',$date_humain);
            $date = $tab1[0];
            $heure = $tab1[1];
            //separation des elements de la date pour reorganisation
            $tab2 = explode('/',$date);
            //verification du format de la date
            if(sizeof($tab2) > 2){
                    $jour = $tab2[0];
                    $mois = $tab2[1];
                    $annee = $tab2[2];
                    //reconstitution de la date au format mysql
                    $date_mysql = $annee."-".$mois."-".$jour." ".$heure ;
            }
            else{
                    $date_mysql = $date_humain." ".$heure ;
            }
            return $date_mysql ;
        }
    }//fin fonction convert_datetime_to_mysql
		
    //fonction de conversion du format de la date pour l'adapter à MySQL
    function convert_date_to_mysql($date_humain){
        if(isset($date_humain) & !empty($date_humain))
        {
            //separation des elements de la date pour reorganisation
            $tab2 = explode('/',$date_humain);
            //verification du format de la date
            if(sizeof($tab2) > 2){
                $jour = $tab2[0];
                $mois = $tab2[1];
                $annee = $tab2[2];
                //reconstitution de la date au format mysql
                $date_mysql = $annee."-".$mois."-".$jour ;
            }
            else{
                $date_mysql = $date_humain ;
            }
            return $date_mysql ;
        }
    }//fin fonction convert_datetime_to_mysql
?>