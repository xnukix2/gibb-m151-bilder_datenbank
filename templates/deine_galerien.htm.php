<?php
  	$sql = "SELECT b.bilderID, g.galerieID, g.name, g.beschreibung FROM bilder AS b
  	RIGHT JOIN galerie AS g ON b.galerieID = g.galerieID
  	WHERE g.benutzerID = '".$_SESSION['session']."'
  	GROUP BY g.galerieID";
  	$result = getValue("cfg_db")->query($sql);

?>

<div class="col-md-12">
<form name="deine_galerien" enctype="multipart/form-data" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">

  	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		<h2>Galerie erstellen</h2>
	  	</div>
	  	<div class="panel-body">
	  		<p>Galerie Name:</p>
		  	<input type="text" name="inputGalerieName" class="form-control" style="width: 200px">
		  	<p>Galerie Beschreibung:</p>
		  	<input type="text" name="inputGalerieBeschreibung" class="form-control" style="width: 200px">
		  	<button name="btnGalerieErstellen" class="btn btn-success">Galerie erstellen</button>
	  	</div>
  	</div>
  		<?php
		while($row = $result->fetch_assoc()) {
		?>
		<div class="panel panel-default">
		  	<div class="panel-heading">
		  		<button type="submit" name="btnGalerieAnzeigen" value="<?php echo $row['galerieID'] ?>" class="btn btn-link">
		  			<h2><?php echo $row["name"]; ?></h2>
		  		</button>
		  		<button data-toggle="collapse" data-target="#bearbeiten<?php echo $row['galerieID'] ?>" type="button" class="btn btn-link">
		        	<span class="glyphicon glyphicon-pencil"></span>
		        </button>

		        <button type="submit" name="btnGalerieLöschen" value="<?php echo $row['galerieID'] ?>" class="btn btn-link">
		        	<span class="glyphicon glyphicon-trash"></span>
		        </button>
		  	</div>
		  	<div class="panel-body">
		  		<div id="bearbeiten<?php echo $row['galerieID'] ?>" class="collapse panel panel-default">
				  	<div class="panel-body">
				  		<p>Galerie Name:</p>
					  	<input type="text" name="inputGalerieNameBearbeiten" class="form-control" style="width: 200px">
					  	<p>Galerie Beschreibung:</p>
					  	<input type="text" name="inputGalerieBeschreibungBearbeiten" class="form-control" style="width: 200px">
					  	<button name="btnGalerieBearbeiten" value="<?php echo $row['galerieID'] ?>" class="btn btn-success">Speichern</button>
				  	</div>
			  	</div>
		  		<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>" id="upl_image" style="height: 200px;">
		  		<p><?php echo $row["beschreibung"]; ?></p>
		  	</div>
	  	</div>
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