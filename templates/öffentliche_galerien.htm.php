<?php
  	$sql = "SELECT b.bilderID, g.name, g.beschreibung FROM bilder AS b
  	RIGHT JOIN galerie AS g ON b.galerieID = g.galerieID
  	GROUP BY g.galerieID";
  	$result = getValue("cfg_db")->query($sql);

  	$dir = "../images/thumb/";
  	$image_names = array();
   	$k = 0;
  	foreach (glob("{$dir}*.{jpg, png, jpeg, gif}", GLOB_BRACE) as $key) {
  		$image_names[$k] = substr($key, -5, -4);
  		$k++;
  	}
  	$images = glob("{$dir}*.{jpg, png, jpeg, gif}", GLOB_BRACE);

?>

<div class="col-md-12">
<form name="öffentliche_galerien" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	  	<?php
  		$i = 0;
		while($row = $result->fetch_assoc()) {
		?>
		<div class="panel panel-default">
		  	<div class="panel-heading">
		  		<button type="submit" name="btnGalerieAnzeigen" value="<?php echo $row['galerieID'] ?>" class="btn btn-link">
		  			<h2><?php echo $row["name"]; ?></h2>
		  		</button>
		  	</div>
		  	<div class="panel-body">
		  		<?php
		  		if($image_names == null) {}
		  		else {
		  			if(in_array($row['bilderID'], $image_names)) {
							$num = $images[$i];
	  				?>
			  			<img src="<?php echo $num; ?>" id="upl_image">
			  		<?php
			  		}
	  				$i += 1;
	  			}
		  		?>
		  		<p><?php echo $row["beschreibung"]; ?></p>
		  	</div>
	  	</div>
		<?php		
			}
		?>
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