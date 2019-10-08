<?php
require_once('include/config.php');
require_once('classes/Preferences.php');
require_once('classes/Utility.php');
require_once('classes/Album.php');

$objPrefs = Preferences::getInstance();
$objUtil = Utility::getInstance();

$objAlbum = new Album(); // Object of Ganre 

$page = intval($_GET['page']);
$album_id = intval($_GET['id']);
$deleteAlbum = $objAlbum->deleteAlbum($album_id);

if($deleteAlbum){
  header("location:view_album.php?page=".$page);
}
?>
