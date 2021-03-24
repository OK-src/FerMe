  <?php
	//connessione al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//creazione della variabile $valid
	$valid = true;
	
	//ricezione delle informazioni da html
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    
    $email = $_POST['email'];
	
    //validazione dell'username
    if (strlen($username)>25) {
		$valid = false;
        echo '<br>Username troppo lungo';
    }
    
    if (strlen($username)<4) {
		$valid = false;
		echo '<br>Username troppo corto';
	}
			
	//validazione della password	
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
	
	//validazione dell'email
	if (strlen($email) > 70) {
		$valid = false;
		echo '<br>L\'email e\' troppo lungo';
	}
	
	if (strlen($email) < 5) {
		$valid = false;
		echo '<br>Inserite un email vero';
	}
	
	//criptazione della password
	$password = hash('sha256', $password);
	
	//inserimento in mysql
	if ($valid) {
		
		$sql = "INSERT INTO utenti (username, password, email)
		VALUES ('$username', '$password', '$email')";
		
		if ($conn->query($sql) === TRUE) {
			//ciao octy //Bella!
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
			
    }
    
    //inizializzazione della sessione
	$query = mysqli_query($conn, "SELECT user_id FROM `utenti` WHERE email='$email'");
	$fromObj = mysqli_fetch_assoc($query);
	$sessionVar = $fromObj["user_id"];
	echo $sessionVar;
	session_id($sessionVar);
	session_start();
	header("Location: http://ferme.eu5.org/index.html");
?>
