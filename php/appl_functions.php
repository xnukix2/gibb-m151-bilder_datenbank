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
			db_uploadImage($bildName, $gid);
			$image = db_getLatestImage();
			$temp = explode(".", $_FILES["userImage"]["name"]);
			$newfilename = $image . '.' . end($temp);
			$origin_dir = "../images/origin/";
			$origin_file = $origin_dir . $newfilename;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($origin_file, PATHINFO_EXTENSION));

			$check = getimagesize($_FILES['userImage']['tmp_name']);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
			}

			if (file_exists($origin_file)) {
				$uploadOk = 0;
			}

			if ($_FILES["userImage"]["size"] > 4194304) {
				$uploadOk = 0;
			}

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$uploadOk = 0;
			}

			if ($uploadOk == 0) {
			} else {
				if (isset($_POST["inputNameBild"])) {
					$bildName = $_POST["inputNameBild"];
				} else {
					$bildName = "";
				}
				move_uploaded_file($_FILES["userImage"]["tmp_name"], $origin_file);
				
				$thumb_dir = "../images/thumb/";
				$thumb_file = $thumb_dir . $newfilename;
				create_thumb(150, $origin_file, $thumb_file);
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
			$bildID = db_getImageByID($_POST["btnBildLöschen"]);
			unlink("../images/origin/".$bildID.".jpg");
			unlink("../images/thumb/".$bildID.".jpg");
			db_bild_löschen($_POST['btnBildLöschen']);
		}

		setValue("phpmodule", $_SERVER['PHP_SELF']."?id=".getValue("func"));
		return runTemplate( "../templates/".getValue("func").".htm.php" );
	}
}

function create_thumb($max_size, $source_file, $dst_dir, $quality = 80){
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
 
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
     
    $dst_img = imagecreatetruecolor($max_size, $max_size);
    $src_img = $image_create($source_file);
     
    $width_new = $height * $max_size / $max_size;
    $height_new = $width * $max_size / $max_size;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_size, $max_size, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_size, $max_size, $width_new, $height);
    }
     
    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
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