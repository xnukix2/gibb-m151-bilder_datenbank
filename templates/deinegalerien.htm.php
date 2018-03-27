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
	if(count($_FILES) > 0) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
					$imageProperties = getImageSize($_FILES['userImage']['tmp_name']);
					
					//$sql = "INSERT INTO bilder(name, datei, galerieID)
					//VALUES('{$imageProperties['mime']}', '{$imgData}', '1')";
					$sql = "INSERT INTO bilder(name, datei, galerieID)
					VALUES ('".escapeSpecialChars($imageProperties['mime'])."', '".escapeSpecialChars($imgData)."', '1')";
					$current_id = mysqli_query(getValue("cfg_db"), $sql);
					if(isset($current_id)) {
					    header("Location: ".$_SERVER['PHP_SELF']."?id=galerien");
					}
				}
			}

	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
	} 
?>