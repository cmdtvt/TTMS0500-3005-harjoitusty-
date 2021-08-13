<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

//Tarkistetaan onko haluttua tiedostoa olemassa. Jos ei palauta 404 sivu jollei muuten ole määrätty.
function givePage($page,$error="includes/pages/404.php") {
	if (file_exists($page)) {
		include_once($page);
	} else {
		include_once($error);
	}
}

//Sammuta sivuston headeri tai footteri (Esim kirjautumis sivulla.).
$setting_RemoveHeader = false;
$setting_RemoveNavigation = false;
$setting_RemoveFooter = false;
$setting_requireLogin = true;

?>


<!DOCTYPE html>
<html lang="en">
<?php include_once('includes/header.php'); ?>
<body>


	<input type="hidden" id="hidden_username" value="<?php echo $_SESSION['username']; ?>">
	<?php include_once('includes/navigation.php'); ?>
	<main id="main">
		<div class="main-content container-fluid">
			<?php
				//Katsotaan halusiko käyttäjä jonkin sivun?
				$page = "login";
				if (isset($_GET['page'])) {
					$page = $_GET['page'];
				}

				//Ladataam haluttu sivu
				switch ($page) {
					case 'home':
						//include_once('includes/pages/home.php');
						$setting_requireLogin = false;
						givePage('includes/pages/home.php');
						break;

					case 'login':
						$setting_requireLogin = false;
						givePage('includes/pages/login.php');
						break;

					case 'logout':

						//En ole varma tarvitaanko tätä kaikkea ulos kirjautumisessa mutta stackoverflown mukaan tämä on hyvä tapa varmistaa että mitään ei jää jälkeen.
						//https://stackoverflow.com/questions/3512507/proper-way-to-logout-from-a-session-in-php

						// Unset all of the session variables.
						$_SESSION = array();
						// If it's desired to kill the session, also delete the session cookie.
						// Note: This will destroy the session, and not just the session data!
						if (ini_get("session.use_cookies")) {
							$params = session_get_cookie_params();

							setcookie(session_name(), '', time() - 42000,
								$params["path"], $params["domain"],
								$params["secure"], $params["httponly"]
							);
						}

						// Finally, destroy the session.
						session_destroy();
						header("Location: index.php?page=login");

					case 'chat':
						$setting_RemoveFooter = true;
						givePage('includes/pages/chat.php');
						break;

					case 'settings':
						$setting_RemoveFooter = true;
						givePage('includes/pages/settings.php');
						break;
						
					default:
						givePage('includes/pages/404.php');
						break;
				}

				if ($setting_requireLogin) {
					if (!isset($_SESSION['username'])) {
						header("Location: index.php");
					}
				}
			
			
			
			?>
		</div>
	</main>

	<?php 
		if ($setting_RemoveFooter == false) {
			include_once('includes/footer.php');
			
		}
		
	?>
</body>
</html>