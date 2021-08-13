<?php
//Tämä tiedosto hakee tietokannasta tavaroita.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




require_once 'db.php';

header('Content-Type: application/json');
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request'])) {
    $request = $_GET['request'];
    //Katsotaan mihin pyyntö matchaa.
    switch ($request) {
        case 'servers':
            //Listataan kaikki palvelimet. Sisältää vähän hassuttelua sillä tieto ei tullut kannasta täysin oikeassa muodossa.
            $db_data = $dao_obj->getServers();
            $data = array();
    
            //Asetetaan dictionaryn avaimeksi palvelimen ID numero. 
            foreach ($db_data as $d) {
                $data['servers'][$d['ID']] = $d;
                //$data['servers'][$d['ID']]['messages'] = "{}";
            }
    
            echo json_encode($data);
    
            //echo file_get_contents('testdata/test-data-servers.json');
            break;
    
        case 'messages':
            //List of all messages
            $serverID = $_GET['serverID'];
            if (!isset($serverID)) {
                echo "Pyyntöä ei määritelty.";
                die();
            }
    
            $db_data = $dao_obj->getMessages($serverID);
            $data = array();
    
    
            foreach ($db_data as $d) {
                $data['messages'][$d['ID']] = $d;
                $data['messages'][$d['ID']]['userdata'] = $dao_obj->getUser($d['userID']);
            }
    
            echo json_encode($data);
    
            //echo file_get_contents('testdata/test-data-messages.json');
            break;
    
        case 'user':
            $userID = $_GET['userID'];
            if (!isset($userID)) {
                echo "Pyyntöä ei määritelty.";
                die();
            }

            
            echo $dao_obj->getUsers($userID);
            break;
    
        case 'pages':
            echo "{pages:[home,chat,login]}";
            break;
    
        default:
            # code...
            break;
    }





}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request'])) {    

    switch ($_POST['request']) {
        case 'createServer':
            
            $temp_avatar = $_POST['avatar'];
            if (empty($_POST['avatar'])) {
                $temp_avatar = "storage/cat-icon.PNG";
            }

            $response = $dao_obj->createServer($_POST['name'],$_SESSION['userID'],$temp_avatar);
            if ($response) {
                echo '{"success":"true"}';
            } else {
                echo '{"success":"false"}';
            }

            break;

        case 'createMessage':
            $dao_obj->createMessage($_POST['message'],$_SESSION['userID'],$_POST['serverID']);
            echo "{}";
            break;

        case 'createUser':
            $response = $dao_obj->createUser($_POST['username'],$_SESSION['password']);
            break;

        case 'deleteServer':
            $dao_obj->deleteServer($_POST['serverID']);
            break;

        case 'login':

            $response = $dao_obj->checkLogin($_POST['username'],$_POST['password']);
            //var_dump($response);
            

            if($response) {
                //session_start();
                echo '{"loginValid":"true"}';
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['userID'] = $response['ID'];
                //$_SESSION['userID'] = $dao_obj->getUser($_POST['userID']);



            } else {
                echo '{"loginValid":"false"}';
            }
            break;

        case 'register':
            $response = $dao_obj->createUser($_POST['username'],$_POST['password']);

            echo '{"registerValid":"true"}';
            /*
            if($response) {
                echo '{"registerValid":"true"}';
            } else {
                echo '{"registerValid":"false"}';
            }
            */
            break;
        
        default:
            # code...
            break;
    }

}




?>