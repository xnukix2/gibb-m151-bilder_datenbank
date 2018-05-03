<?php
    if(isset($_GET['image_id'])) {
    	$db = mysqli_connect("127.0.0.1", "root", "gibbiX12345", "bilderdb");
        $sql = "SELECT name, datei FROM bilder WHERE bilderID=" . $_GET['image_id'];
        $result = $db->query($sql);
		//$result = mysqli_query(getValue("cfg_db"), $sql);
		$row = $result->fetch_assoc();//  mysql_fetch_array($result);
		header("Content-type: " . $row["name"]);
        echo $row["datei"];
	}
?>