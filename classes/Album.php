<?php
class Album
{
    protected $db;
       
    public function __construct()
    {
        $this->db = MysqliDb::getInstance();
    }

     /**
     * Method to get Genre Title added
     * @param string $genreTitle Genre title to be searched
     * @return mixed Genre data array or <i>null</i>
     */
    public function getAlbumByTitle($albumTitle)
    {
        $sql = 'SELECT * FROM tbl_music_album WHERE album_title = ?';
        $params = array($albumTitle);
        $resulsAlbum = $this->db->rawQuery($sql, $params);
        if(count($resulsAlbum) > 0){
            return $resulsAlbum[0];
        } else {
            return null;
        }
    }

     /**
     * Method to get Genre by ID
     * @param string $genreID Genre ID to be searched
     * @return mixed Genre data array or <i>null</i>
     */
    public function getAlbumByID($albumID)
    {
        $sql = 'SELECT * FROM tbl_music_album WHERE album_id = ?';	
        $params = array($albumID);
        $resulsAlbum = $this->db->rawQuery($sql, $params);
		// print_r($resulsAlbum);
		// die;
        if(count($resulsAlbum) > 0){
			// echo count($resulsAlbum);
			// die;
            return $resulsAlbum[0];
        } else {
			// echo "In else Part";
			// die;
            return null;
        }
    }

    /**
     * Method to get the Genres Count
     * @param string $where SQL where clause if any or blank string
     * @return integer
     */
    public function getAlbumCount($where = '')
    {
       $sql = "SELECT count(*) AS rec_count FROM tbl_music_album";
       if(!empty($where)){
         $sql .= " WHERE ".$where." ";
       }
       $results = $this->db->rawQuery($sql);
       if(count($results) > 0){
         $objData = $results[0];
             return $objData['rec_count'];
       } else {
         return 0;
       }
    }

    /**
     * Method to add new Genre Record
     *
     * @param string $where SQL where clause if any or blank string (Default Blank)
     * @param integer $startIndex Start Index for the records (Default is 0 (zero) )
     * @param integer $numRecords Number of records to be fetched (Default is 10)
     *
     * @return array
     */
    public function getAllAlbum($where = '', $startIndex = 0, $numRecords = 10)
    {
       $params = array($startIndex, $numRecords);
	   $sql = "SELECT * FROM tbl_music_album ";
	   if(!empty($where)){
	     $sql .= " WHERE ".$where." ";
	   }
	   $sql .= " ORDER BY album_id DESC, album_title ";
           $sql .= " LIMIT ?, ?";
	   $results = $this->db->rawQuery($sql, $params);
       return $results;
    }
    
     /**
     * Method to add new Album Record
     *
     * @param array $arrValues Key/Value array for the album
     *
     * @return boolean
     */
    public function addAlbum($arrValues)
    {
       //Utility::p_print_die($arrValues);
        $results = $this->db->insert("tbl_music_album", $arrValues);
        if($results) {
          return true;
        } else {
          return false;
        }
    }
     
     /**
     * Method to update the Album record
     *
     * @param array $arrValues Key/Value array for the prefrence
     * @param integer $genre_id ID for the Album to be edited
     *
     * @return boolean
     */
     public function updateAlbum($arrValues, $album_id)
     {
        $this->db->where('album_id', $album_id);
        $results = $this->db->update("tbl_music_album", $arrValues);
        if($results) {
          return true;
        } else {
          return false;
        }
     }

     /**
     * Method to delete the Album record
     *
     * @param integer $album_id ID for the Album to be edited
     *
     * @return boolean
     */
     public function deleteAlbum($album_id)
     {
        $this->db->where('album_id', $album_id);
        $results = $this->db->delete("tbl_music_album");
        if($results) {
          return true;
        } else {
          return false;
        }
     }
}