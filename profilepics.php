<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	session_start();
	$userID = $_SESSION["user"];
	$im = $_POST["immagini"];
	$set = $im;
	$sql = "UPDATE utenti SET picture = '$im' WHERE user_id = '$userID'";
		
	if ($conn->query($sql) === TRUE) {
		if (isset($set)) {
			echo "immagine profilo cambiato con successo <br>";
			echo 'proseguite qui: <a href="http://ferme.eu5.org/profile.php">Profilo</a>';
		} 
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	

?>
