<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	$desc = san($conn, $_POST['desc']);
	session_start();
	$id = $_SESSION["user"];
	
	if (isset($desc)) {
		$sql = "UPDATE utenti SET description = '$desc' WHERE user_id = '$id'";
		
		if ($conn->query($sql) === TRUE) {
		
			echo "Descrizione cambiata con successo <br>";
			echo 'tornate qui: <a href="http://ferme.eu5.org/profile.php">Profilo</a>';
			
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}	
	} else echo 'Inserite qualcosa, <a href="http://ferme.eu5.org/description.html">ricarica</a>';
