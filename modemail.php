<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//recupero informazioni
	$email = $_POST['email'];
	$password = hash('sha256', $_POST['password']);
	session_start();
	$id = $_SESSION["user"];
	
	$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
	$fromObj = mysqli_fetch_assoc($query);  
	$queryVar = $fromObj["password"];
	
	if ($queryVar == $password) {
		$sql = "UPDATE utenti SET email = '$email' WHERE user_id = '$id'";
		
		if ($conn->query($sql) === TRUE) {
			echo "email cambiato con successo <br>";
			echo 'Proseguite <a href="http://ferme.eu5.org/profile.php">qui</a>';
		}
	} else echo 'Password sbagliato, <a href="http://ferme.eu5.org/modemail.html">ricarica</a>';
?>
