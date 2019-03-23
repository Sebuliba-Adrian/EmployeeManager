<?php
require_once("Constants.php");
class Manager{
    
    function __construct() {
        try {
                return new PDO(DB_CONNECTION.':host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
            }
        catch (PDOException $e) {
            return FALSE;
        }
     }

}

?>
