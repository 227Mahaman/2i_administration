<li class="active"><a href="index.php?p=dashboard"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
<!--<li><a href="widgets.html"><em class="fa fa-calendar">&nbsp;</em> Widgets</a></li>
<li><a href="charts.html"><em class="fa fa-bar-chart">&nbsp;</em> Charts</a></li>
<li><a href="elements.html"><em class="fa fa-toggle-off">&nbsp;</em> UI Elements</a></li>
<li><a href="panels.html"><em class="fa fa-clone">&nbsp;</em> Alerts &amp; Panels</a></li>-->
<?php
    $id_current_group = 0;
    $tab_longueur = sizeof($_SESSION['bloc_administration']);
    for($i=0; $i<$tab_longueur; $i++) {
    $tab_simple = $_SESSION['bloc_administration'][$i];
    //condition d'ouverture d'un nouveau menu
    //if( $id_current_group != $tab_simple['id_groupe']){
    //if($id_current_group > 0)
    //	echo '</ul> </li>'; //fermeture du groupe precedent
?>
<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
    <em class="fa fa-navicon">&nbsp;</em> Multilevel <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
    </a>
    <ul class="children collapse" id="sub-item-1">
        <li><a class="" href="#">
            <span class="fa fa-arrow-right">&nbsp;</span> Sub Item 1
        </a></li>
        <li><a class="" href="#">
            <span class="fa fa-arrow-right">&nbsp;</span> Sub Item 2
        </a></li>
        <li><a class="" href="#">
            <span class="fa fa-arrow-right">&nbsp;</span> Sub Item 3
        </a></li>
    </ul>
</li>
<li><a href="index.php?p=deconnexion"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>