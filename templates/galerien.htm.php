<div class="col-md-12">
<form name="galerien" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	<label class="control-label col-md-offset-2 col-md-2" for="email">Test</label>
	<div class="col-md-4">
	  <input type="email" class="form-control" id="email" name="email" value="<?php echo getHtmlValue("email"); ?>" />
	</div>
  </div>
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	  <button type="submit" class="btn btn-success" name="login" id="login">Gail</button>
	</div>
  </div>
</form>
</div>
<?php
	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";

	echo "<div class='col-md-offset-2 col-md-4 carousel'>
	<img src='".getValue('bilder')."'>
	</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
	} 
?>