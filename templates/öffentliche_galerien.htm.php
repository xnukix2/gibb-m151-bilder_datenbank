<?php
  	$sql = "SELECT b.bilderID, g.name, g.beschreibung FROM bilder AS b
  	RIGHT JOIN galerie AS g ON b.galerieID = g.galerieID
  	GROUP BY g.galerieID";
  	$result = getValue("cfg_db")->query($sql);
	//$result = mysqli_query(getValue("cfg_db"), $sql);

?>

<div class="col-md-12">
<form name="öffentliche_galerien" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	  	<?php
		while($row = $result->fetch_assoc()) {
		?>
		<div class="panel panel-default">
		  	<div class="panel-heading">
		  		<button type="submit" name="btnGalerieAnzeigen" value="<?php echo $row['galerieID'] ?>" class="btn btn-link">
		  			<h2><?php echo $row["name"]; ?></h2>
		  		</button>
		  	</div>
		  	<div class="panel-body">
		  		<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>" id="upl_image" style="height: 200px;">
		  		<p><?php echo $row["beschreibung"]; ?></p>
		  	</div>
	  	</div>
		<?php		
			}
		?>
	  <!--<div id="demo" class="carousel slide" data-ride="carousel">
		  <ul class="carousel-indicators">
		    <li data-target="#demo" data-slide-to="0" class="active"></li>
		    <li data-target="#demo" data-slide-to="1"></li>
		    <li data-target="#demo" data-slide-to="2"></li>
		  </ul>
		  
		  <!-- The slideshow -->
		  <!--<div class="carousel-inner">

		  	<?php
	  			$count = 0;
			  	while($row = $result->fetch_assoc()) {
			  		if ($count == 0) {
				  		?>
						<div class="item active">
				    		<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>">
				    	</div>
						<?php
						$count += 1;
			  		}
			  		else {
					?>
					<div class="item">
						<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>">
					</div>
					<?php
					}
				}
			?>
		    <div class="item">
		      <img src="download.png">
		    </div>
		  </div>
		  
		  <!-- Left and right controls -->
		  <!--<a class="left carousel-control" href="#demo" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class=" right carousel-control" href="#demo" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>
		</div>-->
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