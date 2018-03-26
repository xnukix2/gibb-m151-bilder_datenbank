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

  if(db_checkEmailNotExists($_POST['email'])){
	$fehlermeldung .= "Email existiert bereits. ";
	$_POST["email"] = "";
  }

  if (!checkEmail($_POST['email'])) {
	$fehlermeldung .= "Falsches Format der E-Mail. ";
	$_POST["email"] = "";
  }

  if (!checkPasswort($_POST['passwort'])) {
	$fehlermeldung .= "Passwort stimmt nicht mit den Vorgaben überein [1. Grossbuchstabe, 1. Zahl, 1. Sonderzeichen & mind. 8 Zeichen]. ";
	$_POST["passwort"] = "";
  }
  if ($_POST['passwort'] != $_POST['passwort2'])
  $fehlermeldung .= "Passwörter sind nicht gleich. ";
	$_POST["passwort2"] = "";
  return $fehlermeldung;
}
?>