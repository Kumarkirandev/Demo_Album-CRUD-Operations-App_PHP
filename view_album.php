<?php 
require_once('include/config.php');
require_once('classes/Preferences.php');
require_once('classes/Utility.php');
require_once('classes/Album.php');
require_once('classes/paginator.class.2.php');

$objPrefs = Preferences::getInstance();
$objUtil = Utility::getInstance();


//Any condition to searching
$where = '';

$objAlbum = new Album();
$num_rows = $objAlbum->getAlbumCount($where);

$rowsPerPage = $objPrefs->getPrefValForKey('record_per_page');
if (isset($_GET['ipp'])) {
  $rowsPerPage = intval($_GET['ipp']);
}
if($rowsPerPage <= 0){
  $rowsPerPage = 20;
}
$pageNum = 1;
if (isset($_GET['page'])) {
  $pageNum = intval($_GET['page']);
}
if($pageNum <= 0){
  $pageNum = 1;
}
$maxPage = ceil($num_rows/$rowsPerPage);
if($maxPage == 0) {
  $maxPage = 1;
}
if($pageNum > $maxPage) {
  $pageNum = $maxPage;
}
$offset = ($pageNum - 1) * $rowsPerPage;

$records = array();
if ($num_rows > 0){
  //if we have records to show, get the records for the current page
  $records = $objAlbum->getAllAlbum($where, $offset, $rowsPerPage);
  $records = $objUtil->fixSlashes($records);
}
//Pagnator Object
$objPaginator = new Paginator;
$objPaginator->items_total = $num_rows;
$objPaginator->mid_range = 9; // Number of pages to display. Must be odd and > 3
$objPaginator->items_per_page = $rowsPerPage;
$objPaginator->paginate();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $objPrefs->getPrefValForKey('admin_title'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" >
  function delete_confirm() 
  {
    var msg = confirm('Are you sure you want to delete.');
    if(msg == false) 
    {
      return false;
    }
  }
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<?php include("include/header.php") ?>
<tr>
  <td align="right" class="paddRtLt70" valign="top">
    <table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="200" align="left" valign="top"><?php include("include/left.php")?></td>
        <td align="right" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="middle" class="headingbg bodr">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td class="text14"><em><img src="images/arrow2.gif" width="21" height="21" hspace="10" align="absmiddle" /></em>Admin: View Album (<?php echo $num_rows; ?> Album)</td>
                <td align="right" class="padd5">&nbsp;</td>
                <td align="right">&nbsp;</td>
                </tr>
              </table>
              </td>
            </tr>
            <tr>
              <td height="100" align="left" valign="top" bgcolor="#FFFFFF" class="bodr">
                  <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left">
                        <?php
                        if($num_rows==0)
                        {
                        ?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td align="center"><?php echo $objUtil->showError('No Records found');?></td>
                            </tr>
                          </table>
                        <?php
                        }
                        else
                        {
                        ?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="10%" align="left" class="padd5" bgcolor="#f3f4f6"><strong>S No.</strong></td>
                              <td width="70%" align="left" class="padd5" bgcolor="#f3f4f6"><strong>Album Title</strong></td>
                              <td width="10%" align="center" class="padd5" bgcolor="#f3f4f6"><strong>Edit</strong></td>
                              <td width="10%" align="center" class="padd5" bgcolor="#f3f4f6"><strong>Delete</strong></td>
                            </tr>
                          <?php
                          $count = $offset;
                          foreach($records as $objAlbum)
                          {
                            $count = $count+1;
                            if($count%2 == 0) {
                              $bgcolor = "#f3f4f6";
                            } else {
                              $bgcolor = "#ffffff";
                            }
                          ?>
                          <tr bgcolor="<?php echo $bgcolor; ?>">
                            <td class="padd5"><?php echo $count; ?></td>
                            <td class="padd5" align="left" valign="top"><?php echo $objAlbum['album_title']; ?></td>
                            <td align="center" class="padd5"><a href="edit_album.php?id=<?php echo $objAlbum['album_id'] ?>"><img src="images/edit3.gif" border="0" /></a></td>
                            <td align="center" class="padd5"><a href="delete_album.php?id=<?php echo $objAlbum['album_id'] ?>&page=<?php echo $pageNum; ?>&show=<?php echo $show; ?>" onclick="return delete_confirm();"><img src="images/trash.png" border="0" /></a></td>
                          </tr>
                          <?php 
                            }
                          ?>
                            <tr>
                              <td colspan="4" align="left" class="padd5 bodrTop">
                                <div class="paginatorHolder" style="background:#f3f3f3">
		<?php echo $objPaginator->display_jump_menu();?>
                                <span id="tnt_pagination" style="background:#FFF">
                                  <?php echo $objPaginator->display_pages(); ?>
                                </span>
                                <?php echo $objPaginator->display_items_per_page();?></div>
                              </td>
                            </tr>
                          </table>
                        <?php
                        }
                        ?>
                        </td>
                      </tr>
                  </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>
<?php
  include ('include/footer.php');
 ?>
</table>
</body>
</html>
