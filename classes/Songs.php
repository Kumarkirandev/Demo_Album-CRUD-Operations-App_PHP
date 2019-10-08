<?php
class Songs
{
    protected $db;
       
    public function __construct()
    {
        $this->db = MysqliDb::getInstance();
    }

     
	/**
     * Method to get Channel Name added
     * @param string $channel_name Channel name to be searched
     * @return mixed Channel data array or <i>null</i>
     */
    public function getSongsByTitle($songs_name)
    {
        $sql = 'SELECT * FROM tbl_music_album_songs WHERE song_title = ?';
        $params = array($channel_name);
        $resulsSongs = $this->db->rawQuery($sql, $params);
        if(count($resulsSongs) > 0){
            return $resulsSongs[0];
        } else {
            return null;
        }
    }
	 
	/**
     * Method to get tbl_music_album_songs by ID
     * @param string $song_id to be searched
     * @return mixed tbl_music_album_songs data array or <i>null</i>
     */
    public function getSongsByID($songs_id)
    {
        $sql = 'SELECT * FROM tbl_music_album_songs WHERE song_id = ?';
        $params = array($songs_id);
        $resulsSongs = $this->db->rawQuery($sql, $params);
        if(count($resulsSongs) > 0){
            return $resulsSongs[0];
        } else {
            return null;
        }
    } 
	 
	 /**
     * Method to find a radio channel from its stream URL
     * 
     * @param string $streamURL Radio channel stream URL
     * 
     * @return mixed Returns an array of Channel Data or <i>null<i> if chanel not found 
     */
    public function getRadioForStream($streamURL)
    {
        $sql = 'SELECT * FROM tbl_music_album_songs WHERE channel_stream_url = ?';
        $params = array($streamURL);
        $resulsSongs = $this->db->rawQuery($sql, $params);
        if(count($resulsSongs) > 0){
            return $resulsSongs[0];
        } else {
            return null;
        }
    }

     /**
     * Method to get the Channels Count
     * 
     * @param string $where SQL where clause if any or blank string
     * @return integer
     */
    public function getSongsCount($where = '')
    {
       $sql = "SELECT COUNT(tbl_music_album_songs.song_id) AS rec_count FROM tbl_music_album_songs ";
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
     * Method to get tbl_music_album_songs Records
     *
     * @param string $where SQL where clause if any or blank string (Default Blank)
     * @param integer $startIndex Start Index for the records (Default is 0 (zero) )
     * @param integer $numRecords Number of records to be fetched (Default is 10)
     *
     * @return array
     */
    public function getAllSongs($where = '', $startIndex = 0, $numRecords = 10)
    {
       $params = array($startIndex, $numRecords);
	   $sql = "SELECT *
                   FROM tbl_music_album_songs ";
	   if(!empty($where)){
	     $sql .= " WHERE ".$where." ";
	   }
	   $sql .= " ORDER BY tbl_music_album_songs.song_datetime DESC, tbl_music_album_songs.song_title";
       $sql .= " LIMIT ?, ?";
	   $results = $this->db->rawQuery($sql, $params);
       return $results;
    }
    
     /**
     * Method to add new tbl_music_album_songs Record
     *
     * @param array $arrValues Key/Value array for the channel
     *
     * @return boolean
     */
    public function addChannel($arrValues)
    {
        $results = $this->db->insert("tbl_music_album_songs", $arrValues);
        if($results) {
          return $results;
        } else {
          return false;
        }
    }
     
     /**
     * Method to update the Channel record
     *
     * @param array $arrValues Key/Value array for the prefrence
     * @param integer $song_id ID for the tbl_music_album_songs to be edited
     *
     * @return boolean
     */
     public function updateChannel($arrValues, $songs_id)
     {
        $this->db->where('song_id', $songs_id);
        $results = $this->db->update("tbl_music_album_songs", $arrValues);
        if($results) {
          return true;
        } else {
          return false;
        }
     }

     /**
     * Method to delete the tbl_music_album_songs record
     *
     * @param integer $songs_id ID for the tbl_music_album_songs to be edited
     *
     * @return boolean
     */
     public function deleteChannel($songs_id)
     {
        $this->db->where('song_id', $songs_id);
        $results = $this->db->delete("tbl_music_album_songs");
        if($results) {
          return true;
        } else {
          return false;
        }
     }

}