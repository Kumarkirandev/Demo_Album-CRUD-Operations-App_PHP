<?php
class GenreChannel
{
    protected $db;
       
    public function __construct()
    {
        $this->db = MysqliDb::getInstance();
    }

	/**
     * Method to get Genres for selected Channel
     * @param int $channel_id Channel ID
     * @return mixed Genre data array or <i>null</i>
     */
    public function getGenresForChannel($channel_id)
    {
		$sql = 'SELECT `tbl_genre`.`genre_id`, 
						`tbl_genre`.`genre_title` 
				FROM
				 `tbl_genre_channels`
				INNER JOIN `tbl_genre` 
					ON (`tbl_genre_channels`.`genre_id` = `tbl_genre`.`genre_id`)
					WHERE `tbl_genre_channels`.`channel_id` = ?';
        $params = array($channel_id);
        $resulsChannel = $this->db->rawQuery($sql, $params);
        return $resulsChannel;
    }
	
	/**
	 * Remove all the genres for the selected channel
	 * 
     * @param int $channel_id Channel ID
     *
	 * @return boolean
	 */
	  public function removeAllGenresForChannel($channel_id)
	  {
		$this->db->where('channel_id', $channel_id);
		return $this->db->delete('tbl_genre_channels');
	  }
	 
     /**
     * Method to add new Channel Record
     *
     * @param array $arrValues Key/Value array for the channel
     *
     * @return boolean
     */
	  public function add($arrValues)
	  {
		  $results = $this->db->insert("tbl_genre_channels", $arrValues);
		  if($results) {
			return true;
		  } else {
			return false;
		  }
	  }
}