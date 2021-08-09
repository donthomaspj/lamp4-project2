<!--File to connect database
Author: Kaur Arjinder-->
<?php
	define("DBHOST", "localhost");
    define("DBDB"  , "Employees");
	define("DBUSER"  , "project_Group17");
	define("DBPW"  , "!Project17!");
    
	function connectDB(){
		$dsn = "mysql:host=".DBHOST.";dbname=".DBDB.";charset=utf8";
		try{
			$db_conn = new PDO($dsn, DBUSER, DBPW);
			return $db_conn;
		} catch (PDOException $e){
			return FALSE;
		}
	}

?>