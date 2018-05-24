<?php
	$gid = $_SESSION["gid"];
  	$sql = "SELECT b.name, b.bilderID FROM bilder AS b
  	LEFT JOIN galerie AS g ON b.galerieID = g.galerieID
  	WHERE g.galerieID = ".$gid."
  	ORDER BY b.bilderID";
  	//WHERE g.galerieID = ".$gid."
  	$result = getValue("cfg_db")->query($sql);
  	$result2 = getValue("cfg_db")->query($sql);
  	$result3 = getValue("cfg_db")->query($sql);

?>

<div class="col-md-12">
<form name="galerie" class="form-horizontal form-condensed" enctype="multipart/form-data" action="" method="post">
  <div class="form-group control-group">
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		<h2>Bild Hochladen:</h2>
	  	</div>
	  	<div class="panel-body">
		  	<input name="userImage" type="file"/>
			<button type="submit" class="btn btn-success" name="btnUpload" id="upload">Hochladen</button>
			<br/><label>Bild Name:</label><br/>
			<input type="text" name="inputNameBild" class="form-control">
	  	</div>
  	</div>

	
  	<?php
  	while($row = $result3->fetch_assoc()) {
  	?>
  		<div class="panel panel-default">
		  	<div class="panel-heading">
		  		<h2><?php echo $row["name"]; ?></h2>
		  		<button data-toggle="collapse" data-target="#bearbeiten<?php echo $row['bilderID'] ?>" type="button" class="btn btn-link">
		        	<span class="glyphicon glyphicon-pencil"></span>
		        </button>

		  		<button type="submit" name="btnBildLöschen" value="<?php echo $row['bilderID'] ?>" class="btn btn-link">
		        	<span class="glyphicon glyphicon-trash"></span>
		        </button>
		  	</div>
		  	<div class="panel-body">
		  		<div id="bearbeiten<?php echo $row['bilderID'] ?>" class="collapse panel panel-default">
				  	<div class="panel-body">
				  		<p>Bild Name:</p>
				  		<input type="text" name="inputNameBildBearbeiten" class="form-control" style="width: 200px">
					  	<button name="btnBildBearbeiten" value="<?php echo $row['bilderID'] ?>" class="btn btn-success">Speichern</button>
				  	</div>
			  	</div>
		  		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal">
		  			<img src="imageView.php?image_id=<?php echo $row["bilderID"]; ?>" id="upl_image" style="height: 200px;">
		  		</button>
		  	</div>
	  	</div>
  	<?php
  	}
  	?>
  	<div class="modal fade" id="modal" role="dialog">
	    <div class="modal-dialog">
	    	<div class="modal-content">
		        <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        </div>
		        <div class="modal-body">
		        	<div id="demo" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
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
						</ol>
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
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	    	</div>
	    </div>
	</div>
	</div>
</form>
</div>
<?php
	$meldung = getValue("meldung");
	if (strlen($meldung) > 0) echo "<div class='col-md-offset-2 col-md-6 alert alert-danger'>$meldung</div>";

	if (isset($_SESSION['session'])) {
		echo "<div class='loginbox'>Member: ".$_SESSION['session']."</div>";
		echo "<div class='loginbox'>Galerie: ".$gid."</div>";
	} 
?>