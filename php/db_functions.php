<?php
/*
 *  @autor Michael Abplanalp
 *  @version Februar 2018
 *  Dieses Modul beinhaltet sämtliche Datenbankfunktionen.
 *  Die Funktionen formulieren die SQL-Anweisungen und rufen dann die Funktionen
 *  sqlQuery() und sqlSelect() aus dem Modul basic_functions.php auf.
 */
function db_benutzer_by_id($email) {
  $sql = "select benutzerID from benutzer where email = '".$email."'";
  $result = mysqli_query(getValue("cfg_db"), $sql);
  $row = mysqli_fetch_assoc($result);
  $benutzerID = $row['benutzerID'][0];

  setValue("benutzerID", $benutzerID);
}

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

function db_galerie_erstellen($name, $beschreibung, $benutzerID) {
  $sql = "SELECT benutzerID FROM benutzer WHERE benutzerID = ".$benutzerID;
  $result = mysqli_query(getValue("cfg_db"), $sql);
  $row = mysqli_fetch_assoc($result);
  $benutzerID = $row['benutzerID'][0];

  $sql = "INSERT INTO galerie(name, beschreibung, benutzerID)
  VALUES('".$name."', '".$beschreibung."', '".$benutzerID."')";
  sqlQuery($sql);
}

function db_galerie_bearbeiten($name, $beschreibung, $galerieID) {
  $sql = "UPDATE galerie SET name='".$name."', beschreibung='".$beschreibung."'
  WHERE galerieID=".$galerieID;
  sqlQuery($sql);
}

/*function db_uploadImage() {
  $imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
  $imageProperties = getImageSize($_FILES['userImage']['tmp_name']);
  
  $sql = "INSERT INTO bilder(name, datei, galerieID)
  VALUES('{$imageProperties['mime']}', '{$imgData}', '1')";
  //$sql = "INSERT INTO bilder(name, datei, galerieID)
  //VALUES ('".escapeSpecialChars($imageProperties['mime'])."', '".escapeSpecialChars($imgData)."', '1')";
  $current_id = mysqli_query(getValue("cfg_db"), $sql);
  if(isset($current_id)) {
    header("Location: ".$_SERVER['PHP_SELF']."?id=galerien");
  }
}*/

function db_bild_bearbeiten($name, $bildID) {
  $sql = "UPDATE bilder SET name='".$name."'
  WHERE bilderID=".$bildID;
  sqlQuery($sql);
}

function db_bild_löschen($bildID) {
  $sql = "DELETE FROM bilder
  WHERE bilderID=".$bildID;
  sqlQuery($sql);
}

function db_getImages() {
  $sql = "SELECT bilderID FROM bilder ORDER BY bilderID DESC"; 
  $result = mysqli_query(getValue("cfg_db"), $sql);
}
?>