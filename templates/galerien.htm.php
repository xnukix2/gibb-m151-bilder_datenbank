<div class="col-md-12">
<form name="galerien" class="form-horizontal form-condensed" action="" method="post">
  <div class="form-group control-group">
	  <div id="demo" class="carousel slide" data-ride="carousel">
		  <ul class="carousel-indicators">
		    <li data-target="#demo" data-slide-to="0" class="active"></li>
		    <li data-target="#demo" data-slide-to="1"></li>
		    <li data-target="#demo" data-slide-to="2"></li>
		  </ul>
		  
		  <!-- The slideshow -->
		  <div class="carousel-inner">

		  	<?php
		  	$sql = "SELECT bilderID FROM bilder ORDER BY bilderID DESC"; 
  			$result = mysqli_query(getValue("cfg_db"), $sql);
		  	while($row = $result->fetch_assoc()) {
			?>
			<div class="item">
				<img src="imageView.php?image_id=<?php echo $row["imageID"]; ?>" />
			</div>
			<?php		
			}
			?>
		    <div class="item active">
		      <img src="galaxy1.jpg" width="1100" height="500">
		    </div>
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

	echo "<div class='col-md-offset-2 col-md-4 carousel'>
	<img src='".getValue('bilder')."'>
	</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
	} 
?>