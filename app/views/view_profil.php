<?php
include_once("app/core/profil_db_manager.php");
include_once("app/core/action_db_manager.php");
    $title="Profil";
	ob_start();
	$records = select_profil(true);
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
			<h1 class="page-header"><?= $title;?></h1>
		</div>
	</div><!--/.row-->
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Données</div>
			<div class="panel-body">
				<div class="col-md-12">
					<!--<table class="table table-bordered table-striped table-condensed tbody">-->
					<table class="table table-condensed">
						<thead>
							<th>#</th>
							<th>Libellé</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php 
								$i = 0;
								foreach($records as $row) {
							?>
							<tr>
							<td><?= ++$i;?></td>
								<td><?= htmlentities(stripcslashes($row['libelle_profil']));?></td>
								<td>
									<a href="index.php?p=profil&modif=<?= htmlentities(stripcslashes($row['id_profil'])); ?>" class="btn btn-primary">
										<i class="fa fa-pencil"></i>
									</a>
									<form method="post">
										<input type="hidden" name="id_profil" value="<?= htmlentities(stripcslashes($row['id_profil'])); ?>">
										<button class="btn btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
							<?php
							} //fin foreach
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div><!-- /.panel-->
	</div><!-- /.col-->
</div>	<!--/.main-->
<?php
    $content = ob_get_clean();
    require('template.php');
?>