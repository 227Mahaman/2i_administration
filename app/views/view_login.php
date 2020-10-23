<?php 
$title="Authentification";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>
	<link href="public/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/css/datepicker3.css" rel="stylesheet">
	<link href="public/css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading"><img src="" alt="2iSoft Logo"/></div>
				<div class="panel-body">
					<form role="form" method="post">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Pseudo / Login" name="login" type="text" required>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="mot_passe" type="password" required>
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Remember Me
								</label>
                            </div>
                            <button id="connecter" name="connecter" type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-log-in"></span> Connecter
                            </button>
                            <!--<a href="index.html" class="btn btn-primary">Login</a>-->
                        </fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

<script src="public/js/jquery-1.11.1.min.js"></script>
	<script src="public/js/bootstrap.min.js"></script>
</body>
</html>
