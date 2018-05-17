<?php
  	$sql = "SELECT g.name, g.beschreibung, b.bilderID FROM galerie AS g
  	LEFT JOIN bilder AS b ON g.galerieID = b.galerieID
  	LEFT JOIN benutzer AS be ON g.benutzerID = be.benutzerID
  	WHERE be.email = '".$_SESSION["session"]."'
  	GROUP BY g.galerieID";
  	$result = getValue("cfg_db")->query($sql);
	//$result = mysqli_query(getValue("cfg_db"), $sql);

?>

<div class="col-md-12">
<form name="deinegalerien" enctype="multipart/form-data" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
  	<p>Galerie Name:</p>
  	<input type="text" name="inputGalerieName" class="form-control" style="width: 200px">
  	<p>Galerie Beschreibung:</p>
  	<input type="text" name="inputGalerieBeschreibung" class="form-control" style="width: 200px">
  	<button name="btnGalerieErstellen" class="btn btn-success">Galerie erstellen</button>
  	<br>
  		<?php
		while($row = $result->fetch_assoc()) {
		?>
		<a href="index.php?id=galerie">
			<div class="col-md-4">
	      		<div class="thumbnail">
	          		<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>" id="upl_image" style="height: 200px;">
	          		<div class="caption">
	            		<p><?php echo $row["beschreibung"]; ?></p>
	          		</div>
	      		</div>
	    	</div>
		</a>
	
		<?php		
			}
		?>
  </div>
</div>
<?php
		if(count($_FILES) > 0) {
			if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
				$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
				  $imageProperties = getImageSize($_FILES['userImage']['tmp_name']);
				  
				  $sql = "INSERT INTO bilder(name, art, datei, galerieID)
				  VALUES('{$imageProperties['mime']}', '{$imgData}', '1')";
				  //$sql = "INSERT INTO bilder(name, datei, galerieID)
				  //VALUES ('".escapeSpecialChars($imageProperties['mime'])."', '".escapeSpecialChars($imgData)."', '1')";
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