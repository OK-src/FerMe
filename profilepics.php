<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	echo $_SESSION["user"];
	$im = $_POST['immagini'];
	/*
	$sql = "INSERT INTO utenti (picture) VALUES ('$im')";
		
	if ($conn->query($sql) === TRUE) {
		//ciao octy
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}*/

?>
