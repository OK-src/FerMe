<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	session_start();
	$id = $_SESSION["user"];
	
	$query = mysqli_query($conn, "SELECT username, password, email, picture FROM utenti WHERE user_id='$id'");
	$fromObj = mysqli_fetch_assoc($query);
?>
<html>
	<head>
	</head>
	
	<body>
		<h3>Benvenuto <?php echo $fromObj['username']; ?></h3>
		
		<h2>Informazioni:</h2>
		
		<b>Email: </b><?php echo $fromObj['email'];?> <br>
		<b>Immagine profilo: </b><br><?php $pic = $fromObj['picture']; echo "<img src=\"/profili/im$pic.jpg\">";?>

		<h2>Modifica Informazioni:</h2>
		
		Cliccate <a href="http://ferme.eu5.org/modemail.html">qui</a> per modificare l'email<br>
		Cliccate <a href="http://ferme.eu5.org/profilepics.html">qui</a> per modificare l'immagine di profilo<br>
		Cliccate <a href="http://ferme.eu5.org/modpass.html">qui</a> per modificare il password<br>
		
		<h2>Cliccate <a href="http://ferme.eu5.org/logout.php">qui</a> per uscire dal account</h2> <br> <br>
		<h2>Cliccate <a href="http://ferme.eu5.org/accdel.html">qui</a> per distruggere l'account</h2> <br> <br>
		
		<a href="http://ferme.eu5.org/index.html">Torna al sito</a>
	</body>

</html>
