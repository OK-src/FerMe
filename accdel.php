<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//recupero informazioni
	$password = hash('sha256', $_POST['password']);
	session_start();
	$id = $_SESSION["user"];
	
	$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
	$fromObj = mysqli_fetch_assoc($query);  
	$queryVar = $fromObj["password"];
	
	if ($password == $queryVar) {
		$sql = "DELETE FROM utenti WHERE user_id='$id'";
		
		if ($conn->query($sql) === TRUE) {
			echo "<br>Account cancellato con successo";
			echo '<br><a href="http://ferme.eu5.org/index.html">Torna al sito</a>';
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else echo 'Ricontrollate il password, <a href="http://ferme.eu5.org/accdel.html">ricarica</a>';

?>
