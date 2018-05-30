<?php
	$gid = $_SESSION["gid"];
  	$sql = "SELECT b.name, b.bilderID FROM bilder AS b
  	LEFT JOIN galerie AS g ON b.galerieID = g.galerieID
  	WHERE g.galerieID = ".$gid."
  	ORDER BY b.bilderID";

  	$result = getValue("cfg_db")->query($sql);

  	//Thumbnail
  	$dir_thumb = "../images/thumb/";
  	$image_path_thumb = glob("{$dir_thumb}*.{jpg, png, jpeg, gif}", GLOB_BRACE);

  	$i=0;
  	while($row = $result->fetch_assoc()) {
   		$var_thumb[$i] = $row['bilderID'];
  		$i++;
  	}
  	mysqli_data_seek($result, 0);

	while($row = $result->fetch_assoc()) {
	   	for ($i=0; $i < count($var_thumb); $i++) { 
	   		if (in_array($row['bilderID'], $var_thumb)) {
	   			$image_path_galerie_thumb[$i] = $dir_thumb.$var_thumb[$i].".jpg";
	   		}
	   	}
	}
  	mysqli_data_seek($result, 0);

	//Origin
	$dir_origin = "../images/origin/";
  	$image_path_origin = glob("{$dir_origin}*.{jpg, png, jpeg, gif}", GLOB_BRACE);

  	$i=0;
  	while($row = $result->fetch_assoc()) {
   		$var_origin[$i] = $row['bilderID'];
  		$i++;
  	}
  	mysqli_data_seek($result, 0);

	while($row = $result->fetch_assoc()) {
	   	for ($i=0; $i < count($var_origin); $i++) { 
	   		if (in_array($row['bilderID'], $var_origin)) {
	   			$image_path_galerie_origin[$i] = $dir_origin.$var_origin[$i].".jpg";
	   		}
	   	}
	}
  	mysqli_data_seek($result, 0);
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

	<div class="row">
  	<?php
  	$i = 0;
  	while($row = $result->fetch_assoc()) {
  	?>
  		<div class="col-sm-4">
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
		  	<div class="panel-body" style="text-align: center;">
		  		<div id="bearbeiten<?php echo $row['bilderID'] ?>" class="collapse panel panel-default">
				  	<div class="panel-body">
				  		<p>Bild Name:</p>
				  		<input type="text" name="inputNameBildBearbeiten" class="form-control" style="width: 200px">
					  	<button name="btnBildBearbeiten" value="<?php echo $row['bilderID'] ?>" class="btn btn-success">Speichern</button>
				  	</div>
			  	</div>
		  		<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal">
		  			<?php
		  			if(in_array($row['bilderID'], $var_thumb)) {
  						$num = $image_path_galerie_thumb[$i];
  					?>
		  				<img src="<?php echo $num; ?>" id="upl_image">
		  			<?php
		  			}
  					$i += 1;
		  			?>
		  		</button>
		  	</div>
	  	</div>
	  	</div>
  	<?php }
  	mysqli_data_seek($result, 0); ?>
  	</div>
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
						  	mysqli_data_seek($result, 0);
						  	?>
						</ol>
						<div class="carousel-inner">
						  	<?php
					  			$r = 0;
					  			$i = 0;
							  	while($row = $result->fetch_assoc()) {
							  		if ($r == 0) {
								  		?>
										<div class="item active">
								    		<?php
								  			if(in_array($row['bilderID'], $var_origin)) {
						  						$num = $image_path_galerie_origin[$i];
						  					?>
								  				<img src="<?php echo $num; ?>" id="upl_image">
								  			<?php
								  			}
						  					$i += 1;
								  			?>
								    	</div>
										<?php
										$r += 1;
							  		}
							  		else {
									?>
									<div class="item">
										<?php
							  			if(in_array($row['bilderID'], $var_origin)) {
					  						$num = $image_path_galerie_origin[$i];
					  					?>
							  				<img src="<?php echo $num; ?>" id="upl_image">
							  			<?php
							  			}
					  					$i += 1;
							  			?>
									</div>
									<?php
									}
								}
								mysqli_data_seek($result, 0);
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