<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//$valid
	$valid = true;
	
	//ricevere informazioni da html
    $username = $_POST['username'];
    
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    
    $email = $_POST['email'];
	
    //validazione username
    if (strlen($username)>25) {
		$valid = false;
        echo '<br>Username troppo lungo';
    }
    
    if (strlen($username)<4) {
		$valid = false;
		echo '<br>Username troppo corto';
	}
			
	//validazione password	
	if (strlen($password) > 250) {
		$valid = false;
		echo '<br>Il password e\' troppo lungo';
	}
		
	if (strlen($password) < 6) {
		$valid = false;
		echo '<br>Il password e\' troppo corto, scegliete uno piu\' potente';
	}
	
	if ($password !== $passwordConf) {
		$valid = false;
		echo '<br>I due password non sono uguali';
	}
	
	//validazione email
	if (strlen($email) > 70) {
		$valid = false;
		echo '<br>L\'email e\' troppo lungo';
	}
	
	if (strlen($email) < 5) {
		$valid = false;
		echo '<br>Inserite un email vero';
	}
	
	//cryptare password
	$password = hash('sha256', $password);
	
	//inserire in mysql
	if ($valid) {
		$query = mysqli_query($conn, "SELECT username, password, email FROM utenti WHERE email='$email'");
		$fromObj = mysqli_fetch_assoc($query);
		if(@count($fromObj) > 0) {
			echo"<br>Email gia\' in utilizzo";
			
		} else {
			$sql = "INSERT INTO utenti (username, password, email) VALUES ('$username', '$password', '$email')";
			
			if ($conn->query($sql) === TRUE) {
				echo "<br>registrazione completata con successo";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			//iniziare session
			$query = mysqli_query($conn, "SELECT user_id FROM `utenti` WHERE email='$email'");
			$fromObj = mysqli_fetch_assoc($query);
			$sessionVar = $fromObj['user_id'];
			session_start();
			$_SESSION["user"] = $sessionVar;
			
		}
			
    } else echo '<br><a href="http://ferme.eu5.org/signup.html">ricarica</a><br>';
    echo "<br>Se avete finito la registrazione, proseguite qui: <a href=\"http://ferme.eu5.org/profilepics.html\">cambia foto profilo</a>";
?>
