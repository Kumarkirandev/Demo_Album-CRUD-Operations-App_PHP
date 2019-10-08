<?php
require_once('include/config.php');
require_once('classes/Preferences.php');
require_once('classes/Utility.php');
require_once('classes/Album.php');
$UPLOAD_DIR = 'uploads/albumCover/';

$objPrefs = Preferences::getInstance();
$objUtil = Utility::getInstance();

//Check for valid login credentials and valid session
$db = MysqliDb::getInstance();
$objAlbum = new Album();

$message = '&nbsp;';
if(isset($_POST['submit'])) 
{
    $albumKey = trim($db->escape($_POST['album_key']));
    $albumTitle = trim($db->escape($_POST['album_title']));
    $albumArtist = $_POST['album_artist'];
    $albumMDirector = $_POST['album_music_director'];
    $albumLyrist = $_POST['album_lyrist'];
    $albumYear = $_POST['album_year'];
    $albumLabel = $_POST['album_label'];
    $albumGanere = $_POST['album_genres'];
    $albumCover = '';
    $albumDesc = $_POST['album_description'];
    
    if(empty($albumTitle)){
        $message = $objUtil->ShowError("Please provide a album title to add.");
    } else {
        $arrValues = array();
        $arrValues['album_key'] = $albumKey;
        $arrValues['album_title'] = $albumTitle;
        $arrValues['album_artist'] = $albumArtist;
        $arrValues['album_music_director'] = $albumMDirector;
        $arrValues['album_lyrist'] = $albumLyrist;
        $arrValues['album_year'] = $albumYear;
        $arrValues['album_label'] = $albumLabel;
        $arrValues['album_genres'] = $albumGanere;
        $arrValues['album_cover'] = $albumCover;
        $arrValues['album_description'] = $albumDesc;
        $arrValues['update_date'] = Utility::GetGMTDateTime();
	  
        $resultsAlbum = $objAlbum->getAlbumByTitle($albumTitle);
        if($resultsAlbum){
            $message = $objUtil->ShowError("Album with the same title already exits.");
        } else {
            /**
             * for Channel Image Upload
             */ 
            $fileName = $_FILES['album_cover']['name'];
            $fileType = $_FILES['album_cover']['type'];
            $fileSize = $_FILES['album_cover']['size'];
            if ($fileName != "") 
            {
	list($w, $h) = getimagesize($_FILES['album_cover']['tmp_name']);
	if($fileSize  > 50 * 1024)  //Max 50 kb in size
	{
	    $message =  $objUtil->ShowError("Upload an image under 50 KB for channel icon.");
	}
	/*if($w > 300 || $h > 300)
	{
	    $message =  $objUtil->ShowError("Upload an image under 200px x 200px. You uploaded ".$w."px X ".$h."px.");
	}*/
	if($fileName!="" && $fileType=="image/jpeg" || $fileType=="image/jpg" || $fileType=="image/gif" || $fileType=="image/png" || $fileType=="image/pjpeg" || $fileType=="image/x-png")
	{  
	  $albumCover = time()."_".str_replace(" ", "_", $_FILES['album_cover']['name']);
	  if(copy($_FILES['album_cover']['tmp_name'], $UPLOAD_DIR.$album_cover))
	  {
	    $error = "0";
	    $arrValues['album_cover'] = $album_cover;
	  }
	  else
	  {
	    $albumCover = "noimage.png";  //Default Image
	    $message =  $objUtil->ShowError("Error in uploading the Album Cover.");
	  }
	}
            }
            $addAlbum = $objAlbum->addAlbum($arrValues);
            if($addAlbum)
            {
	$message = $objUtil->ShowSuccess("Album Added Successfully");
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
      alert("Please enter a Album Title.")
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
                <td align="left" valign="middle" class="headingbg bodr text14"><em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Add Album</td>
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
                        <input type="text" name="album_title" id="album_title" value="<?php echo $_POST['album_title'];?>" size="45" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Album Key:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_key" id="album_key" size="45" value="<?php echo $_POST['album_key'];?>" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Artist Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_artist" id="album_artist" value="<?php echo $_POST['album_artist'];?>" size="45" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Composer Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_music_director" id="album_music_director" value="<?php echo $_POST['album_music_director'];?>" size="45" /></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Lyrist Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_lyrist" id="album_lyrist" value="<?php echo $_POST['album_lyrist'];?>" size="45" /></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Label:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_label" id="album_label" value="<?php echo $_POST['album_label'];?>" size="45" /></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Genre Name:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="text" name="album_genres" id="album_genres" value="<?php echo $_POST['album_genres'];?>" size="45" /></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Album Cover:</td>
                        <td width="61%" align="left" class="padd5">
                        <input type="file" name="album_cover" id="album_cover" size="45" /></td>
                      </tr>
                      
                      <tr>
                        <td width="39%" align="right" class="padd5">Description:</td>
                        <td width="61%" align="left" class="padd5">
                        <textarea name="album_description" id="album_description" row ="15" cols="35"><?php echo $_POST['album_description'];?></textarea></td>
                      </tr>
                      <tr>
                        <td width="39%" align="right" class="padd5">Year:</td>
                        <td width="61%" align="left" class="padd5">
                        <select class="select_calender" name="album_year" id="yeardropdown"></select>
                        </td>
                      </tr>                     
                        <td align="right" class="padd5">&nbsp;</td>
                        <td align="left" class="padd5">
                        <input type="submit" name="submit" value="Add Album" onclick="return validate();" class="submit"/></td>
                      </tr>
                    </table></td>
                </form></tr>
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
</script>

