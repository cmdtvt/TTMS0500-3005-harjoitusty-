<?php require_once __DIR__."/settings.php"; ?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);





//Get setting value from database
class DAO {
 
 	private $connection;
	public $db_location;
	public $db_database;
	public $db_username;
	public $db_password;
	public $db_backup_location;

	function __construct($db_location,$db_database,$db_username,$db_password,$db_backup_location) {
		$this->db_location = $db_location;
		$this->db_database = $db_database;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
		$this->db_backup_location = $db_backup_location;



		//Check that database exsists and it has a setting table. This does not mean the database is valid but it works as small safety check.
		try {
			$this->connection = new PDO("mysql:dbname=".$this->db_database.";host=".$this->db_location, $this->db_username, $this->db_password);

    		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$dbcheck = $this->connection->prepare("SELECT * FROM settings LIMIT 1");



			$dbcheck->execute();


		} catch (PDOException $e) {
			echo "error connection to the database it might not be installed?";
			header("Location: install/index.php?msg=Manager was unable to connect to the database. Fix the database in settings.php or install manager from the settings below.");
			die();
		}
	}

	function test() {
		echo "Test was successfull! (I hope so).<br><br>";
		echo $this->db_username;
		echo "<br><br>########";
	}


 
}

//Initialize DAO class.
$dao_obj = new DAO($db_location,$db_database,$db_username,$db_password,$db_backup_location);

//Format copyemails setting correctly. Make $a a array().
//$dao_obj->setSetting("copyemails",serialize($a));

//Test that the class works.
//$dao_obj->test();
?>
