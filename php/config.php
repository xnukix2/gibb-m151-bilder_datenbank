<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul definert alle Konfigurationsparameter und stellt die DB-Verbindung her
 */

// Funktionen
setValue("cfg_func_list", array("registration","login","logout","öffentliche_galerien","galerien","geschützte_galerien","deine_galerien","galerie"));
// Inhalt des Menus
if (isset($_SESSION["session"])) {
	setValue("cfg_menu_list", array("öffentliche_galerien"=>"Öffentliche Galerien","deine_galerien"=>"Deine Galerien"));
	setValue("cfg_menu_right_list", array("logout"=>"Logout"));
}
else {
	setValue("cfg_menu_list", array("öffentliche_galerien"=>"Öffentliche Galerien","geschützte_galerien"=>"Geschützte Galerien"));
	setValue("cfg_menu_right_list", array("registration"=>"Registration","login"=>"Login"));
}

// Datenbankverbindung herstellen
$db = mysqli_connect("127.0.0.1", "root", "gibbiX12345", "bilderdb");
if (!$db) die("Verbindungsfehler: ".mysqli_connect_error());
setValue("cfg_db", $db);
?>
