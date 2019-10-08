<?php
class Preferences
{
    protected $db;
    
    protected static $_instance;

    /**
     * Array that contains the prefrence values
     */
    protected $prefArray = array();
    
    public function __construct()
    {
        $this->db = MysqliDb::getInstance();
        
        $results = $this->db->get('tbl_preferences', 1);
        if (count($results) > 0){
          $this->prefArray = $results[0];
        }
    }

    /**
     * A method of returning the static instance to allow access to the
     * instantiated object from within another class.
     * Inheriting this class would require reloading connection info.
     *
     * @return object Returns the current instance.
     */
    public static function getInstance()
    {
        if (self::$_instance){
          return self::$_instance;
        } else {
          return new Preferences();
        }
    }
    
    /**
     * Method to get the Base URL for the Application
     *
     * @param string $key Key for the prefrence
     *
     * @return string Prefrence value for the application
     */
     public function getPrefValForKey($key)
     {
         if(array_key_exists($key, $this->prefArray)){
             return $this->prefArray[$key];
         } else {
             throw new Exception('Invalid key for prefrences. Key: ' . $key);
         }
     }

    /**
     * Method to update the Application Prefrences
     *
     * @param array $arrValues Key/Value array for the prefrence
     *
     * @return boolean
     */
     public function updatePrefrences($arrValues)
     {
       $this->db->where('id', $this->prefArray['id']);
       return $this->db->update('tbl_preferences', $arrValues);
     }

}