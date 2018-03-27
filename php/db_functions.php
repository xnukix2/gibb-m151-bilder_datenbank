<?php
/*
 *  @autor Michael Abplanalp
 *  @version Februar 2018
 *  Dieses Modul beinhaltet sämtliche Datenbankfunktionen.
 *  Die Funktionen formulieren die SQL-Anweisungen und rufen dann die Funktionen
 *  sqlQuery() und sqlSelect() aus dem Modul basic_functions.php auf.
 */
function db_insert_benutzer($params) {
	$sql = "insert into benutzer (nickname, email, passwort)
  values ('".escapeSpecialChars($params['nickname'])."','".escapeSpecialChars($params['email'])."','".sha1(escapeSpecialChars($params['passwort']))."')";
  sqlQuery($sql);
}

function db_checkEmailExists($email) {
  $sql = "select email FROM benutzer WHERE email = '".escapeSpecialChars($email)."'";
  $result = mysqli_query(getValue("cfg_db"), $sql);

  $rows = $result->num_rows;

	if($rows > 0){
		return true;
	}
	else{
		return false;
	}
}

function db_checkEmailAndPwd($email, $pwd) {
  $sql = "select email, passwort FROM benutzer WHERE email = '".escapeSpecialChars($email)."' AND passwort = '".sha1(escapeSpecialChars($pwd))."'";
  $result = mysqli_query(getValue("cfg_db"), $sql);

  $rows = $result->num_rows;

  if($rows > 0){
    return true;
  }
  else{
    return false;
  }
}

function uploadImage() {
  $imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
  $imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
  
  $sql = "INSERT INTO images(imageType ,imageData)
  VALUES('{$imageProperties['mime']}', '{$imgData}')";
  $current_id = $conn->query($sql);
  if(isset($current_id)) {
    header("Location: listImages.php");
  }
}
?>