<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__."/settings.php"; 

//Get setting value from database
class DAO {
 
 	private $connection;
	public $db_location;
	public $db_database;
	public $db_username;
	public $db_password;
	public $db_backup_location;

	function __construct($db_location,$db_database,$db_username,$db_password) {
		$this->db_location = $db_location;
		$this->db_database = $db_database;
		$this->db_username = $db_username;
		$this->db_password = $db_password;

		//Kokeilen parempaa tapaa tehdä queryt. Tallennan ne tähän muuttujaan jotta niiden muokkaaminen on helpompaa.
		$this->db_queries = array(
			"select" => "SELECT * FROM %d",
			"update" => "UPDATE %t SET %c",
			"alter" => "ALTER TABLE %t ",
			"delete" => ""

		);

		//Check that database exsists and it has a setting table. This does not mean the database is valid but it works as small safety check.
		try {
			$this->connection = new PDO("mysql:dbname=".$this->db_database.";host=".$this->db_location, $this->db_username, $this->db_password);

    		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		} catch (PDOException $e) {
			echo "Could not connect to database.";
			die();
		}
	}

	function test() {
		echo "Test was successfull! (I hope so).<br><br>";
		echo $this->db_username;
		echo "<br><br>########";
	}

	/*
	function prepareQuery($type,$data) {

		if (array_key_exsists($type,$this->db_queries)) {
			# code...
		}

		return sprintf($this->db_queries,"test");
	}
	*/

	function checkLogin($username, $password) {
		$sel = $this->connection->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
		$sel->bindValue(":username",$username);
		$sel->bindValue(":password",$password);
		$sel->execute();
		$row = $sel->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	//Add and remove functions
	function createServer($name,$ownerID,$avatar) {
		$sel = $this->connection->prepare("INSERT INTO servers (name,ownerID,icon) VALUES (:name,:ownerID,:icon)");
		$sel->bindValue(":name",$name);
		$sel->bindValue(":ownerID",$ownerID);
		$sel->bindValue(":icon",$avatar);
		$sel->execute();	
	}

	function deleteServer($serverID, $ownerID) {

		//Tarkista onko oikeasti omistaja

		$sel = $this->connection->prepare("DELETE FROM servers WHERE ID=:id AND ownerID=:ownerID");
		$sel->bindValue(":id",$serverID);
		$sel->bindValue(":ownerID",$ownerID);
		$sel->execute();
	}

	function createMessage($message,$userID,$serverID) {

		// Date-time will have value of 'now'
		$dateTime = new DateTime();
		// Override current time
		$dateTime->setTime(20, 0);
		$timestamp = $dateTime->getTimestamp();


		$sel = $this->connection->prepare("INSERT INTO messages (serverID,userID,timestamp,message) VALUES (:serverID,:userID,:timestamp,:message)");
		$sel->bindValue(":serverID",$serverID);
		$sel->bindValue(":userID",$userID);
		$sel->bindValue(":timestamp",$timestamp);
		$sel->bindValue(":message",$message);
		$sel->execute();	
	}

	function deleteMessage($messageID,$ownerID) {
		$sel = $this->connection->prepare("DELETE FROM messages WHERE ID=:id AND userID=:ownerID");
		$sel->bindValue(":id",$messageID);
		$sel->bindValue(":userID",$ownerID);
		$sel->execute();
	}

	function createUser($username,$password,$rank="normal") {
		$sel = $this->connection->prepare("INSERT INTO users (username,password,rank) VALUES (:username,:password,:rank)");
		$sel->bindValue(":username",$username);
		$sel->bindValue(":password",$password);
		$sel->bindValue(":rank",$rank);
		$sel->execute();
	}

	function deleteUser($userID) {
		$sel = $this->connection->prepare("DELETE FROM users WHERE ID=:id");
		$sel->bindValue(":id",$userID);
		$sel->execute();
	}



	//Fetch data functions
	function getUser($userID) {
		$sel = $this->connection->prepare("SELECT ID,username,rank,avatar FROM users WHERE ID=:userID");
		$sel->bindValue(":userID",$userID);
		$sel->execute();
		$row = $sel->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	function getServers() {
		$sel = $this->connection->prepare("SELECT * FROM servers");
		$sel->execute();
		$row = $sel->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	function getMessages($serverID) {
		$sel = $this->connection->prepare("SELECT * FROM messages WHERE serverID=:serverID");
		$sel->bindValue(":serverID",$serverID);
		$sel->execute();
		$row = $sel->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}


}
header('Content-Type: application/json');
//Initialize DAO class.
$dao_obj = new DAO($db_location,$db_database,$db_username,$db_password);

//Test that the class works.
//$dao_obj->test();
//echo $dao_obj->checkLogin("cmdtvt","cookie");

//print_r($dao_obj->getMessages(1));


?>
