<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul definert alle Konfigurationsparameter und stellt die DB-Verbindung her
 */

// Funktionen
setValue("cfg_func_list", array("login","registration","logout","galerien","galerie","deinegalerien"));
// Inhalt des Menus
if (isset($_SESSION["session"])) {
	setValue("cfg_menu_list", array("logout"=>"Logout","galerien"=>"Galerien","deinegalerien"=>"Deine Galerien"));
}
else {
	setValue("cfg_menu_list", array("login"=>"Login","registration"=>"Registration"));
}

// Datenbankverbindung herstellen
$db = mysqli_connect("127.0.0.1", "root", "gibbiX12345", "bilderdb");
if (!$db) die("Verbindungsfehler: ".mysqli_connect_error());
setValue("cfg_db", $db);
?>
