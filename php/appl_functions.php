<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul beinhaltet Funktionen, welche die Anwendungslogik implementieren.
 */

function login() {
	if (isset($_POST["login"])) {
		$fehlermeldung = checkLogin();
		if (strlen($fehlermeldung) > 0) {
			setValue("meldung", $fehlermeldung);

			setValues($_POST);
		} else {
			db_benutzer_by_id($_POST['email']);
			$_SESSION['session'] = getValue("benutzerID");
			redirect("deine_galerien");
		}
	}
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}

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
			redirect("login");
		}
	}
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}

function öffentliche_galerien() {
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}

function geschützte_galerien() {
	if (isset($_POST["login"])) {
		$fehlermeldung = checkLogin();
		if (strlen($fehlermeldung) > 0) {
			setValue("meldung", $fehlermeldung);

			setValues($_POST);
		} else {
			db_benutzer_by_id($_POST['email']);
			$_SESSION['session'] = getValue("benutzerID");
			redirect("deine_galerien");
		}
	}
	setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
	return runTemplate( "../templates/".getValue("func").".htm.php" );
}

function galerie() {
	if (isset($_SESSION['session'])) {
		if (isset($_POST["btnUpload"])) {
			if (isset($_POST["inputNameBild"])) {
				$bildName = $_POST["inputNameBild"];
			} else {
				$bildName = "";
			}
			$gid = $_SESSION["gid"];
			if(count($_FILES) > 0) {
				if($_FILES['userImage']['size'] > 4194304) {
					setValue("meldung", "Zu grosse Datei");
				} else {
			        if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
			        	$imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
			        	$img = imagecreatefrompng($_FILES['userImage']['name']);
			        	$size = min(imagesx($img), imagesy($img));
			        	$imgCrop = imagecrop($img, ['x'=>0, 'y'=>0, 'width'=>$size, 'height'=>$size]);
			        	$imgProperties = getimageSize($_FILES['userImage']['tmp_name']);
			        	
			        	//$sql = "INSERT INTO bilder(name, art, datei, galerieID)
			        	//VALUES('".$bildName."', '".$imgProperties['mime']."', '".$imgData."', '".$gid."')";

			        	$sql = "INSERT INTO bilder(name, art, datei, thumb, galerieID)
			        	VALUES('".$bildName."', '".$imgProperties['mime']."', '".$imgData."', '".$imgCrop."', '".$gid."')";
			        	
			        	sqlQuery($sql);
			        }
			    }
		    }
		}

		if (isset($_POST["btnBildBearbeiten"])) {
			if (isset($_POST["inputNameBildBearbeiten"])) {
				$name = $_POST["inputNameBildBearbeiten"];
			} else {
				$name = "";
			}
			db_bild_bearbeiten($name, $_POST['btnBildBearbeiten']);
		}

		if (isset($_POST["btnBildLöschen"])) {
			db_bild_löschen($_POST['btnBildLöschen']);
		}

		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}

function deine_galerien() {
	if (isset($_SESSION['session'])) {
		if (isset($_POST["btnGalerieErstellen"])) {
			$name = $_POST["inputGalerieName"];
			$fehlermeldung = checkEmpty($name, 3);
			if (strlen($fehlermeldung) == 0) {
				setValue("meldung", "Bitte längeren Namen eingeben");

				setValues($_POST);
			} else {
				if (isset($_POST["inputGalerieBeschreibung"])) {
					$beschreibung = $_POST["inputGalerieBeschreibung"];
				} else {
					$beschreibung = "";
				}
				db_galerie_erstellen($name, $beschreibung, $_SESSION['session']);
			}
		}

		if (isset($_POST["btnGalerieBearbeiten"])) {
			$name = $_POST["inputGalerieNameBearbeiten"];
			$fehlermeldung = checkEmpty($name, 3);
			if (strlen($fehlermeldung) == 0) {
				setValue("meldung", "Bitte längeren Namen eingeben");

				setValues($_POST);
			} else {
				if (isset($_POST["inputGalerieBeschreibungBearbeiten"])) {
					$beschreibung = $_POST["inputGalerieBeschreibungBearbeiten"];
				} else {
					$beschreibung = "";
				}
				db_galerie_bearbeiten($name, $beschreibung, $_POST['btnGalerieBearbeiten']);
			}
		}

		if (isset($_POST["btnGalerieLöschen"])) {
			db_galerie_löschen($_POST['btnGalerieLöschen']);
		}

		if (isset($_POST["btnGalerieAnzeigen"])) {
			$gid = $_POST["btnGalerieAnzeigen"];
			$_SESSION["gid"] = $gid;
			redirect("galerie");
		}

		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}


function logout() {
	if (isset($_SESSION['session'])) {
		if (isset($_POST["logout"])) {
			session_destroy();
			redirect("login");
		}
		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	} else {
		redirect("login");
	}
}

function checkValues() {
	$fehlermeldung = "";

	if(db_checkEmailExists($_POST['email'])){
		$fehlermeldung .= "Email existiert bereits. ";
		$_POST["email"] = "";
	}

	else if (!checkEmail($_POST['email'])) {
		$fehlermeldung .= "Keine gültige E-Mail. ";
		$_POST["email"] = "";
	}

	if (!checkPasswort($_POST['passwort'])) {
		$fehlermeldung .= "Kein gültiges Passwort, Min. 8 Zeichen, 1 Grossbuchstabe, 1 Kleinbuchstabe, 1 Ziffer, 1 Sonderzeichen. ";
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