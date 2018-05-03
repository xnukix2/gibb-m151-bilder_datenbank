<?php
  	$sql = "SELECT bilderID FROM bilder
  	ORDER BY bilderID";
  	$result = getValue("cfg_db")->query($sql);
  	$result2 = getValue("cfg_db")->query($sql);
	//$result = mysqli_query(getValue("cfg_db"), $sql);

?>

<div class="col-md-12">
<form name="galerien" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	  <div id="demo" class="carousel slide" data-ride="carousel">
		  <ul class="carousel-indicators">
		  <?php
  			$count = 0;
		  	while($row = $result->fetch_assoc()) {
		  		if ($count == 0) {
					echo '<li data-target="#demo" data-slide-to="0" class="active"></li>';
					
		  		} else {
		  			echo '<li data-target="#demo" data-slide-to="' . $count . '"></li>';
		  		}
		  		$count += 1;
		  	}
		  ?>
		  </ul>
		  
		  <!-- The slideshow -->
		  <div class="carousel-inner">

		  	<?php
	  			$var = 0;
			  	while($row = $result2->fetch_assoc()) {
			  		if ($var == 0) {
				  		?>
						<div class="item active">
				    		<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>">
				    	</div>
						<?php
						$var += 1;
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
		  </div>
		  
		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#demo" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class=" right carousel-control" href="#demo" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>
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