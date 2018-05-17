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
	/*if (isset($_SESSION)) {
		session_destroy();
	}*/
	if (isset($_POST["login"])) {
		$fehlermeldung = checkLogin();
		if (strlen($fehlermeldung) > 0) {
			setValue("meldung", $fehlermeldung);

			setValues($_POST);
		} else {
			$_SESSION['session'] = $_POST['email'];
			return header("Location: ".$_SERVER['PHP_SELF']."?id=galerien");
		}
	}

	// Template abfüllen und Resultat zurückgeben
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}

/*
 * Beinhaltet die Anwendungslogik zur Registration
 */
function registration() {
	if (isset($_SESSION['session'])) {
		session_destroy();
	}
	if (isset($_POST["registrieren"])) {
		$fehlermeldung = checkValues();
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

function galerien() {
	if (isset($_SESSION['session'])) {
		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}
function galerie() {
	if (isset($_SESSION['session'])) {
		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}

function deinegalerien() {
	if (isset($_SESSION['session'])) {
		if (isset($_POST["upload"])) {
			if(count($_FILES) > 0) {
				if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
					db_uploadImage();
				}
			}
		}
		if (isset($_POST["btnGalerieErstellen"])) {
			$name = $_POST["inputGalerieName"];
			if (isset($_POST["inputGalerieBeschreibung"])) {
				$beschreibung = $_POST["inputGalerieBeschreibung"];
			}
			db_galerieErstellen($name, $beschreibung, $_SESSION['session']);
		}

		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}


function logout() {
	if (isset($_SESSION['session'])) {
		if (isset($_POST["logout"])) {
			session_destroy();
			header("Location: ".$_SERVER['PHP_SELF']."?id=login");
		}
		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}

function checkValues() {
	$fehlermeldung = "";

	if(db_checkEmailExists($_POST['email'])){
		$fehlermeldung .= "Email existiert bereits. ";
		$_POST["email"] = "";
	}

	else if (!checkEmail($_POST['email'])) {
		$fehlermeldung .= "Falsches Format der E-Mail. ";
		$_POST["email"] = "";
	}

	if (!checkPasswort($_POST['passwort'])) {
		$fehlermeldung .= "Min. 8 Zeichen, 1 Grossbuchstabe, 1 Kleinbuchstabe, 1 Ziffer, 1 Sonderzeichen. ";
		$_POST["passwort"] = "";
		$_POST["passwort2"] = "";
	}

	if ($_POST['passwort'] != $_POST['passwort2']) {
		$fehlermeldung .= "Passwörter sind nicht gleich. ";
		$_POST["passwort"] = "";
		$_POST["passwort2"] = "";
	}
	return $fehlermeldung;
}

function checkLogin() {
	$fehlermeldung = "";
	if(!db_checkEmailAndPwd($_POST['email'], $_POST['passwort'])){
		$fehlermeldung .= "Falsche Logindaten. ";
		$_POST["email"] = "";
		$_POST["passwort"] = "";
	}
	return $fehlermeldung;
}
?>