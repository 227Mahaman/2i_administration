<li class="active"><a href="index.php?p=dashboard"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
<!--<li><a href="widgets.html"><em class="fa fa-calendar">&nbsp;</em> Widgets</a></li>
<li><a href="charts.html"><em class="fa fa-bar-chart">&nbsp;</em> Charts</a></li>
<li><a href="elements.html"><em class="fa fa-toggle-off">&nbsp;</em> UI Elements</a></li>
<li><a href="panels.html"><em class="fa fa-clone">&nbsp;</em> Alerts &amp; Panels</a></li>-->
<?php if(sizeof($_SESSION['bloc_administration'])!=0):?><!--Vérifier si l'user a accès au menu de ce bloc_administration-->
<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
    <em class="fa fa-navicon">&nbsp;</em> <?= $_SESSION['bloc_administration']['0']['libelle_groupe'];?> <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
    </a>
    <ul class="children collapse" id="sub-item-1">
        <?php
        $id_current_group = 0;
        $tab_longueur = sizeof($_SESSION['bloc_administration']);
        for($i=0; $i<$tab_longueur; $i++) {
        $tab_administration = $_SESSION['bloc_administration'][$i];
        ?>
        <?php if(!empty($tab_administration['libelle_action'])):?>
        <li><a class="<?= $tab_administration['icon_groupe']; ?>" href="index.php?p=<?= $tab_administration['url_action'];?>">
            <span class="fa fa-arrow-right">&nbsp;</span> <?= $tab_administration['libelle_action'];?>
        </a></li>
        <?php endif;?>
        <?php
        $id_current_group = $tab_administration['id_groupe'];
        }//fin for
        ?>
    </ul>
</li>
<?php endif;?>
<?php if(sizeof($_SESSION['bloc_configuration'])!=0):?><!--Vérifier si l'user a accès au menu de ce bloc_configuration-->
<li class="parent "><a data-toggle="collapse" href="#sub-item-2">
    <em class="fa fa-navicon">&nbsp;</em> <?= $_SESSION['bloc_configuration']['0']['libelle_groupe'];?> <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
    </a>
    <ul class="children collapse" id="sub-item-2">
        <?php
        $id_current_group = 0;
        $tab_longueur = sizeof($_SESSION['bloc_configuration']);
        for($i=0; $i<$tab_longueur; $i++) {
        $tab_configuration = $_SESSION['bloc_configuration'][$i];
        ?>
        <?php if(!empty($tab_configuration['libelle_action'])):?>
        <li><a class="<?= $tab_configuration['icon_groupe']; ?>" href="index.php?p=<?= $tab_configuration['url_action'];?>">
            <span class="fa fa-arrow-right">&nbsp;</span> <?= $tab_configuration['libelle_action'];?>
        </a></li>
        <?php endif;?>
        <?php
        $id_current_group = $tab_configuration['id_groupe'];
        }//fin for
        ?>
    </ul>
</li>
<?php endif;?>
<li><a href="index.php?p=deconnexion"><em class="fa fa-power-off">&nbsp;</em> Se déconnecter</a></li>