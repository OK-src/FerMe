<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//recupero informazioni
	$password = hash('sha256', $_POST['Cpassword']);
	session_start();
	$id = $_SESSION["user"];
	
	$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
	$fromObj = mysqli_fetch_assoc($query);  
	$queryVar = $fromObj["password"];
	
	if ($queryVar == $password) {
		
		$passwordMod = $_POST['modPass'];
		$passwordModConf = $_POST['modPassConf'];
		
		if ($passwordMod == $passwordModConf) {
			$password = hash('sha256', $passwordMod);
			$sql = "UPDATE utenti SET password = '$password' WHERE user_id = '$id'";
			
			if ($conn->query($sql) === TRUE) {
				echo "password cambiato con successo <br>";
				echo 'Proseguite <a href="http://ferme.eu5.org/profile.php">qui</a>';
			}
			
		} else echo 'I due password non sono uguali, <a href="http://ferme.eu5.org/modpass.html">ricarica</a> <br>';
		
	} else echo 'Password sbagliato, <a href="http://ferme.eu5.org/modpass.html">ricarica</a>';
?>
