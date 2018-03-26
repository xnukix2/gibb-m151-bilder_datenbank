<div class="col-md-12">
<form name="kontakt" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="nickname">Nickname</label>
	<div class="col-md-4">
	  <input type="name" class="form-control" id="nickname" name="nickname" value="<?php echo getHtmlValue("nickname"); ?>" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="email">E-Mail</label>
	<div class="col-md-4">
	  <input type="email" class="form-control" id="email" name="email" value="<?php echo getHtmlValue("email"); ?>" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="passwort">Passwort</label>
	<div class="col-md-4">
	  <input type="password" class="form-control" id="passwort" name="passwort" value="<?php echo getHtmlValue("passwort"); ?>" />
	</div>
  </div>
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="passwort2">Passwort wiederholen</label>
	<div class="col-md-4">
	  <input type="password" class="form-control" id="passwort2" name="passwort2" value="<?php echo getHtmlValue("passwort2"); ?>" />
	</div>
  </div>
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	  <button type="submit" class="btn btn-success" name="registrieren" id="registrieren">Registrieren</button>
	</div>
  </div>
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	</div>
  </div>
</form>
</div>
<?php
	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";
?>