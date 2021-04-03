<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//recupero input da signin.html
	$email = san($conn, $_POST['email']);
	$password = hash('sha256', $_POST['password']);
	
	$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE email='$email'") or die ("Ricontrollate l\'email inserito");
	$fromObj = mysqli_fetch_assoc($query);  
	$queryVar = $fromObj["password"];
	
	if ($queryVar == $password) {
		//iniziare session
		$query = mysqli_query($conn, "SELECT user_id FROM `utenti` WHERE email='$email'");
		$fromObj = mysqli_fetch_assoc($query);
		$sessionVar = $fromObj['user_id'];
		session_start();
		$_SESSION["user"] = $sessionVar;
		echo 'cliccare <a href="http://ferme.eu5.org/index.html">qui</a> per continuare al sito';
	
	} else {echo 'Ricontrollate il password o email <a href="http://ferme.eu5.org/signin.html">ricarica</a>';}
	
?>
