<div class="col-md-12">
<form name="deinegalerien" enctype="multipart/form-data" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	<div class="col-md-4">
		<label>Upload Image File:</label><br/>
		<input name="userImage" type="file" class="inputFile" />
		<button type="submit" class="btn btn-success" name="upload" id="upload">Hochladen</button>
	</div>
  </div>
</div>
<?php

	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
	} 
?>