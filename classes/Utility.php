<?php
class Utility
{
    protected $db;
    
    protected static $_instance;

    public function __construct()
    {
        $this->db = MysqliDb::getInstance();
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
          return new Utility();
        }
    }
    
    /**
     * Method Show the success message box UI
     *
     * @param string $messege Message to be showing in UI
     *
     * @return string HTML formatted string for message box.
     */
    public function showSuccess($messege) 
    {
        $messege = trim($messege);
        if(empty($messege)) {
          return '&nbsp;';
        }
        $messageHTML = "<div class='OKmessegeBody'>" . $messege . "</div>";
        return $messageHTML;
    }
    
    /**
     * Method Show the error message box UI
     *
     * @param string $messege Message to be showing in UI
     *
     * @return string HTML formatted string for message box.
     */
    public function showError($messege) 
    {
        $messege = trim($messege);
        if(empty($messege)) {
          return '&nbsp;';
        }
        $messageHTML = "<div class='ErrormessegeBody'>" . $messege . "</div>";
        return $messageHTML;
    }
    
    /**
     * Method to trim a string in number of characters.
     *
     * @param string $str String to be terminated
     * @param int $minCharacters Minimum number of charactes needed in the trinmmed strin
     *
     * @return string
     */
    public static function subStrWords($str, $minCharacters)
    {
        $str = trim(stripslashes($str));
        if (strlen($str) > $minCharacters) {
            $minCharacters = $minCharacters + 2;
            $tempStr = substr($str, 0, $minCharacters);
            $lpos = strpos(strrev($tempStr), " ");
            $returnStr =  substr($tempStr, 0, strlen($tempStr)-$lpos);
            return $returnStr."...";
        } else {
            return $str;
        }
    }
	
    /**
     * Method to remove the slashes from the data (array or string)
     *
     * @param mixed $arr Data to be applied to stripslashes
     *
     * @return mixed
     */
    public static function fixSlashes($arr = '')
    {
        if (is_null($arr) || empty($arr)) {
            return $arr;
        }
        return is_array($arr) ? array_map('Utility::fixSlashes', $arr) : stripslashes($arr);
    }

    /**
     * Capitalize the first letter of the given string
     * @param string $string string to be capitalized
     * @return string capitalized string
     */
    public static function capitalize($string) {
        return ucfirst(mb_strtolower($string));
    }

    /**
     * Escape the given string
     * @param string $string string to be escaped
     * @return string escaped string
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /**
     * Get the GMT Datetime string
     * 
     * @return string 
     */
    public static function GetGMTDateTime() {
        return gmdate('Y-m-d H:i:s');
    }
    /**
     * Prints an array for debugging
     * @param array $arr
     */
    public static function p_print_die($arr)
    {
      echo '<pre>';
      print_r($arr);
      echo '</pre>';
      die;
    }

}