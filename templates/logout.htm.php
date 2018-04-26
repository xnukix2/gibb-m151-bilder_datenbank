<div class="col-md-12">
<form name="logout" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	<div class="col-md-offset-4 col-md-4">
	  <button type="submit" class="btn btn-danger" name="logout" id="logout" onclick="return confirm('Willst du dich wirklich ausloggen?')">Logout</button>
	</div>
  </div>
</form>
</div>
<?php
	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
	} 
?>