<?php
require_once('include/config.php');
require_once('classes/Preferences.php');
require_once('classes/Utility.php');
require_once('classes/Album.php');

$objPrefs = Preferences::getInstance();
$objUtil = Utility::getInstance();

$objAlbum = new Album();
$UPLOAD_DIR = 'uploads/albumCover/';

$message = '&nbsp;';
$album_id = intval($_GET['id']);
$recAlbum = $objAlbum->getAlbumByID($album_id);
	
if(is_null($recAlbum)){
  die("Invalid Album id supplied.");
} 

if (isset($_POST['Update_Genre'])) 
{
	$albumKey = trim($db->escape($_POST['album_key']));
	$albumTitle = trim($db->escape($_POST['album_title']));
	$albumArtist = $_POST['album_artist'];
	$albumMDirector = $_POST['album_music_director'];
	$albumLyrist = $_POST['album_lyrist'];
	$albumYear = $_POST['album_year'];
	$albumLabel = $_POST['album_label'];
	$albumCover = '';
	$albumDesc = $_POST['album_description'];
	
	if(empty($albumTitle)){
	  $message = $objUtil->ShowError("Please provide a Album title to edit.");
	} else {
	  $arrValues = array();
	  $arrValues['album_key'] = $albumKey;
	  $arrValues['album_title'] = $albumTitle;
	  $arrValues['album_artist'] = $albumArtist;
	  $arrValues['album_music_director'] = $albumMDirector;
	  $arrValues['album_lyrist'] = $albumLyrist;
	  $arrValues['album_year'] = $albumYear;
	  $arrValues['album_label'] = $albumLabel;
	  $arrValues['album_genres'] = '';
	  $arrValues['album_cover'] = $albumCover;
	  $arrValues['album_description'] = $albumDesc;
	  $arrValues['update_date'] = Utility::GetGMTDateTime();

	  $resultsAlbum = $objAlbum->getAlbumByTitle($albumTitle);
      if($resultsAlbum && $resultsAlbum['album_id'] != $album_id){
	  $message = $objUtil->ShowError("Another album with the same title already exits.");
	  } else {
			$resultAlbum = $objAlbum->updateAlbum($arrValues, $album_id);			
			if($resultAlbum)
			{
				$message = $objUtil->ShowSuccess("Update Successfully");
				header("location:view_album.php");
				exit;	
			} else {
				$message = $objUtil->ShowError("Error while trying to add the record.");
			}
	    }
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $objPrefs->getPrefValForKey('admin_title'); ?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript">
  function validate() {
    if (document.frm.album_title.value == "") {
      alert("Please enter a Album.")
      return false;
    }
  }
</script>
</head>
<body>
<script type="text/javascript">
window.onload=function(){
populatedropdown("yeardropdown")
}
</script>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <?php include("include/header.php") ?>
  <tr>
    <td align="right" class="paddRtLt70" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200" align="left" valign="top"><?php include("include/left.php")?></td>
          <td align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" class="headingbg bodr text14"><em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Update Album</td>
              </tr>
              <tr>
                <td height="100" align="left" valign="top" bgcolor="#FFFFFF" class="bodr">
                <form name="frm" method="post" enctype="multipart/form-data">
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td colspan="2"><?php echo $message; ?></td>
                    </tr>
                    <tr>
                      <td width="39%" align="right" class="padd5">Album Name:</td>
                      <td width="61%" align="left" class="padd5">
                      <input type="text" name="album_title" size="45" value="<?php echo $recAlbum['album_title']; ?>" /></td>
                    </tr>
                       <tr>
                        <td width="39%" align="right" class="padd5">Album Key:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_key" id="album_key" size="45" value="<?php echo $recAlbum['album_key']; ?>" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Artist Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_artist" size="45" value="<?php echo $recAlbum['album_artist']; ?>" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Composer Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_music_director" size="45" value="<?php echo $recAlbum['album_music_director']; ?>"/></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Lyrist Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_lyrist" size="45" value="<?php echo $recAlbum['album_lyrist']; ?>"/></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Label:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_label" size="45" value="<?php echo $recAlbum['album_label']; ?>"/></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Genre Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_genres" size="45" value="<?php echo $recAlbum['album_genres']; ?>"/></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Album Cover:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="file" name="album_cover" size="45" value="<?php echo $recAlbum['album_cover']; ?>"/></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Description:</td>
                        <td width="61%" align="left" class="padd5">
                        <textarea name="album_description" row ="15" cols="35"><?php echo $recAlbum['album_description']; ?></textarea></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Year:</td>
                        <td width="61%" align="left" class="padd5">
                        <select class="select" name="album_year" id="yeardropdown" value="<?php echo $recAlbum['album_year']; ?>" selected="selected"></select>
                        </td>
                      </tr>
                    <td align="right" class="padd5">&nbsp;</td>
                      <td align="left" class="padd5"><input type="submit" name="Update_Genre" value="Update Genre" onclick="return validate();" class="submit"/></td>
                    </tr>
                  </table>
                  </td>
                </form>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <?php
  include ('include/footer.php');
 ?>
</table>
</body>
</html>
<script type="text/javascript">
function populatedropdown(yearfield){
var today=new Date()
var yearfield=document.getElementById(yearfield)
var thisyear=today.getFullYear()
for (var y=0; y<20; y++){
yearfield.options[y]=new Option(thisyear, thisyear)
thisyear+=1
}
yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}

$("#album_title").blur(function(){
    var key = $(this).val();
    key = key.toLowerCase();  //convert to lowercase
    key = key.replace(/&/g, '');  //remove &
    key = key.replace(/  /g, ' '); //double space with single space
    key = key.replace(/ /g, '-');  //space with -
    $("#album_key").val(key);
  });
</script>