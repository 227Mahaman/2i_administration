<?php
    // fichier pour internationaliser les ecritures stariques
    include_once 'include/i18n.php';

    // recuperation de la langue courante en session;
    $langue     =   $_SESSION['lang'];
?>
<div class="col-md-3 left_col update-menu">
<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.php" class="site_title">
            <img src="../img/logo.png" style="height: 50px;width: 200px">
        </a>
    </div>
    <!-- menu profile quick info -->

    <div class="profile clearfix ">
    </div>
    <!-- /menu profile quick info -->

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu simple-block">
                <!--liens bloc "simple"-->
                <?php
                $id_current_group = 0;
                $tab_longueur = sizeof($_SESSION['bloc_simple']);
                for($i=0; $i<$tab_longueur; $i++) {
                $tab_simple = $_SESSION['bloc_simple'][$i];
                //condition d'ouverture d'un nouveau menu
                if( $id_current_group != $tab_simple['id_groupe']){
                if($id_current_group > 0)
                    echo '</ul> </li>'; //fermeture du groupe precedent
                ?>
                <li>

                    <a>
                        <i class="<?php echo $tab_simple['icon_groupe']; ?>">
                        </i>
                            <?php echo $langue=='fr'
                                    ? $tab_simple['libelle_groupe']
                                    : $tab_simple['libelle_groupe_en'];
                                ?>
                        <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <?php
                        }//fin if condition d'ouverture
                        ?>
                        <!-- si le champ est null, on n'afficge rien -->
                        <?php if(!empty($tab_simple['libelle_action'])):?>

                        <li>
                            <a href="<?php echo $tab_simple['url_action']; ?>" >
                                <?php echo $langue=='fr'
                                    ? $tab_simple['libelle_action']
                                    : $tab_simple['libelle_action_en'];
                                ?>
                            </a>
                        </li>
                        <?php endif;?>
                        
                        <?php
                        $id_current_group = $tab_simple['id_groupe'];
                        }//fin for
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a><i class="fa fa-cog verte"></i><?=$menu['config'][$langue];?><span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu config-block">
                        <?php
                        $id_current_group = 0;
                        $tab_longueur = sizeof($_SESSION['bloc_config']);
                        for($i=0; $i<$tab_longueur; $i++) {
                        $tab_config = $_SESSION['bloc_config'][$i];
                        //condition d'ouverture d'un nouveau sous-menu
                        if( $id_current_group != $tab_config['id_groupe']){
                        if($id_current_group > 0)
                            echo '</ul> </li>'; //fermeture du groupe precedent
                        ?>
                        <li>
                            <a>
                                <?php echo $langue=='fr'
                                        ? $tab_config['libelle_groupe']
                                        : $tab_config['libelle_groupe_en'];
                                ?>
                                <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php
                                }//fin if condition d'ouverture
                                ?>
                                <?php if(!empty($tab_config['libelle_action'])):?>
                                <li>
                                    <a href="<?php echo $tab_config['url_action']; ?>">
                                        <?php echo $langue=='fr'
                                            ? $tab_config['libelle_action']
                                            : $tab_config['libelle_action_en'];
                                        ?>
                                    </a>
                                </li>
                                <?php endif;?>
                                <?php
                                $id_current_group = $tab_config['id_groupe'];
                                }//fin for
                                ?>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="<?=$menu['aide'][$langue];?>">
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen" >
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="<?=$menu['deconnexion'][$langue];?>" href="../deconnexion.php">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
</div>

<!-- top navigation -->
<div class="top_nav" >
<div class="nav_menu" style="height:2px">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle">
                <button class="btn btn-default btn-xs" style="margin-left:5px">
                 <b>  <span class="glyphicon glyphicon-fullscreen" ></b>
                </button>
            </a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../img/user.png" alt="" style="height: 20px;width: 20px;">
                    <?php echo  $_SESSION['nom'];?>&nbsp;
                    <?php echo  $_SESSION['prenom'];?>
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"><?=$menu['profil'][$langue];?></a></li>
                    <li><a href="javascript:;"><?=$menu['aide'][$langue];?></a></li>
                    <li class="divider"></li>
                    <!-- Changement de langue -->
                    <?php
                        echo $_SESSION['lang'] =='fr'
                            ? '<li><a href="?lang=en">Passer à l\'anglais</a></li>'
                            : '<li><a href="?lang=fr">Go to French</a></li>';
                    ?>
                    <!-- fin changement de langue -->
                    <li class="divider"></li>
                    <li><a href="../deconnexion.php"><i class="fa fa-sign-out bg-red pull-right"></i><?=$menu['deconnexion'][$langue];?></a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</div>
<!-- /top navigation -->






