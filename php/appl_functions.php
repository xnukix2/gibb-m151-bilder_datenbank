<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul beinhaltet Funktionen, welche die Anwendungslogik implementieren.
 */

/*
 * Beinhaltet die Anwendungslogik zum Login
 */
function login() {
  // Template abfüllen und Resultat zurückgeben
  setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
  return runTemplate( "../templates/".getValue("func").".htm.php" );
}

/*
 * Beinhaltet die Anwendungslogik zur Registration
 */
function registration() {
	if (isset($_POST["registrieren"])) {
		$fehlermeldung = checkMail();
		// Wenn ein Fehler aufgetreten ist
		if (strlen($fehlermeldung) > 0) {
			setValue("meldung", $fehlermeldung);

			setValues($_POST);
		} else {
			db_insert_benutzer($_POST);

			return header("Location: ".$_SERVER['PHP_SELF']."?id=login");
		}
	}
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}






function checkMail() {
  $fehlermeldung = "";

  if (!checkEmpty($_POST['benutzername'], 3)) {
	$fehlermeldung .= "Der Benutzername muss mind. 3 Zeichen lang sein. ";
	$_POST["benutzername"] = "";
  }
  if (!checkEmail($_POST['email'])) {
	$fehlermeldung .= "Falsches Format E-Mail. ";
	$_POST["email"] = "";
  }
  if (!checkPasswort($_POST['passwort'])) {
	$fehlermeldung .= "Falsches Passwort. ";
	$_POST["passwort"] = "";
  }
  return $fehlermeldung;
}
?>