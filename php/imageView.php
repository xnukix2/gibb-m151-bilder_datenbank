<?php
    if(isset($_GET['image_id'])) {
        $sql = "SELECT name, datei FROM bilder WHERE bilderID=" . $_GET['image_id'];
		$result = mysqli_query(getValue("cfg_db"), $sql);
		$row = $result->fetch_assoc();//  mysql_fetch_array($result);
		header("Content-type: " . $row["name"]);
        echo $row["datei"];
	}
?>