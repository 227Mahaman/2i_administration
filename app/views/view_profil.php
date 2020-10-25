<?php
    $title="Profil";
    ob_start();
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
							<th>Nom</th>
							<th>Adresse</th>
							<th>Email</th>
							<th>Tel</th>
							<th>BP</th>
							<th>Date</th>
							<th>Action</th>
						</thead>
						<tbody>
							<tr>
								<td>ok<?//= $value['id_sta'];?></td>
								<td>k<?//= $value['id_sta'];?></td>
								<td>k<?//= $value['id_sta'];?></td>
								<td>h<?//= $value['id_sta'];?></td>
								<td>h<?//= $value['id_sta'];?></td>
								<td>h<?//= $value['id_sta'];?></td>
								<td>h<?//= $value['id_sta'];?></td>
								<td>h<?//= $value['id_sta'];?></td>
							</tr>
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