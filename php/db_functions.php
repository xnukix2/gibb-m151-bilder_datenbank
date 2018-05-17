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

function db_galerieErstellen($name, $beschreibung, $benutzerID) {
   $sql = "SELECT benutzerID FROM benutzer WHERE email = 'user@user.ch'";
  $result = mysqli_query(getValue("cfg_db"), $sql);

  $row = mysqli_fetch_assoc($result);
  var_dump($row['benutzerID']);
  exit();

  $benutzerID = $row['benutzerID'];


  $sql = "INSERT INTO galerie(name, beschreibung, benutzerID)
  VALUES('".$name."', '".$beschreibung."', '".$benutzerID."')";
  sqlQuery($sql);
}

function db_uploadImage() {
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
}

function db_getImages() {
  $sql = "SELECT bilderID FROM bilder ORDER BY bilderID DESC"; 
  $result = mysqli_query(getValue("cfg_db"), $sql);
}
?>