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

function db_checkEmailNotExists($email) {
	$sql = "select `email` FROM `benutzer` WHERE `email` = '".escapeSpecialChars($email)."'";
    $result = sqlQuery($sql);
  
  	if($result != null){
  		return false;
  	}
  	else{
  		return true;
  	}
}
?>