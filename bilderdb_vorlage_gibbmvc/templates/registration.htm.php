<div class="col-md-12">
<form name="kontakt" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="username">Benutzername</label>
	<div class="col-md-4">
	  <input type="name" class="form-control" id="username" name="username" value="" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="email">E-Mail</label>
	<div class="col-md-4">
	  <input type="email" class="form-control" id="email" name="email" value="" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="password">Passwort</label>
	<div class="col-md-4">
	  <input type="password" class="form-control" id="password" name="password" value="" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="password2">Passwort wiederholen</label>
	<div class="col-md-4">
	  <input type="password" class="form-control" id="password2" name="password2" value="" />
	</div>
  </div>
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	  <button type="submit" class="btn btn-success" name="registrieren" id="registrieren">Registrieren</button>
	</div>
  </div>
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	<?php
		$meldung = getValue("meldung");
		if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";
	?>
	</div>
  </div>
</form>
</div>
