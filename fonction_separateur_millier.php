<?php 
	//fonction separateur de millier
	function separateur_millier($number){
		return number_format ( $number , $decimals = 0 , $dec_point = '.' , $thousands_sep = ' ' );
	}
?>