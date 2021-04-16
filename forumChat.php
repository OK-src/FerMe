<?php
    //connessione al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//recupero sessione
	session_start();
	$id = $_SESSION['user'];
	$forum = $_SESSION['forum'];
	$query = mysqli_query($conn, "SELECT ruolo FROM `utenti` WHERE user_id = '$id'");
	$fromObj = mysqli_fetch_assoc($query);
	if($fromObj['ruolo'] == 3){
		$moderatore = 1;
	}
	
	//assegnazione ai moderatori del potere di cancellare un messaggio
	if(isset($_POST['delete'])){
		$messaggioDaCancellare = $_POST['delete'];
		$sql = "DELETE FROM `$forum` WHERE numeratore='$messaggioDaCancellare'";
		
		if ($conn->query($sql) === TRUE) {
			echo "<br>Messaggio cancellato con successo";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	//assegnazione ai moderatori del potere di modificare un messaggio
	if(isset($_POST['modifica'])){
		$_SESSION['modifica'] = $_POST['modifica'];
		header('Location: /modmess.php');
	}
?>

<html>
	<body>
		<form method="post">
			<input type="submit" name="more" class="button" value="Cliccate qui per vedere tutti i messaggi"><br>
			<h2>Inserite qui un messaggio da inviare in "<?php echo $forum; ?>":</h2><br>
			<textarea name="messaggio" rows="12" cols="120" maxlength="1024" placeholder="Potete inserire al massimo 1024 caratteri."></textarea>
			<br><input type="submit" value="Invia">
		<br>
		  <a href="/forum.php"> Torna alla lista dei forum </a><br>
		</form>
	</body>
</html>

<?php
	if($id == 0){
	    echo'
	    <h2> Mi spiace, ma prima di partecipare alle discussioni dovrete accedere al sito con il vostro account </h2>
	    <h2> Cliccate <a href="http://ferme.eu5.org/signin.html">qui</a> per accedere oppure <a href="http://ferme.eu5.org/signup.html">qua</a> per creare un nuovo account.<h2>
	    <h2> Tornate presto con noi! </h2>';
	} else {
		//ricezione delle informazioni da html
		$messaggio = san($conn, $_POST['messaggio']);
		
		
		//inserimento del messaggio nella tabella
		if($messaggio != NULL){
			if($messaggio != $_SESSION['messaggio']){
				$sql = "INSERT INTO $forum (id, messaggi) VALUES ('$id', '$messaggio')";
				if ($conn->query($sql) === TRUE) {
					echo "Pronto per inviare un altro messaggio!<br>";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		} else {
			echo '<h2> Ricordate di inserire il testo nei messaggi che inviate. </h2>';
		}
	}
	
	//resa impossibile dello spamming ed evitazione dell'invio di messaggi ad ogni ricarica di pagina
	$_SESSION['messaggio'] = $messaggio;
	
	//selezione degli ultimi 50 messaggi inviati
	$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM $forum");
	$fromObj = @mysqli_fetch_array($query);
	$max = $fromObj["MaxNumeratore"];
	if(array_key_exists('more', $_POST)) {
		$contatore = 1;
	} else {
		$contatore = $max - 50;
	}
    while($max >= $contatore){
        $query = mysqli_query($conn, "SELECT id, messaggi, data FROM `$forum` WHERE numeratore = '$max'");
		$fromObj = mysqli_fetch_assoc($query);
		$idMittente = $fromObj["id"];
		if($idMittente != 0){
			$data = $fromObj["data"];
			$messaggio = $fromObj["messaggi"];
			$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$idMittente'");
			$fromObj = mysqli_fetch_assoc($query);
			$username = $fromObj["username"];
			$ruolo = $fromObj['ruolo'];
			if($ruolo == 1){
				$ruolo = 'Donatore';
			} else if($ruolo == 2){
				$ruolo = 'Sviluppatore';
			} else if($ruolo == 3){
				$ruolo = 'Moderatore';
			}
			$pic = $fromObj["picture"];
			echo "<img src=/profili/im$pic.jpg>";
			echo "<h3><form method='post'><input type='submit' name='descrizione' value='$idMittente'>$username</input> <strong>$ruolo</strong> </form>$data</h3>";
			echo "<h4>$messaggio</h4>";
			if($moderatore == 1){
				echo "<form method='post'><input type='submit' name='delete' value='$max'>Cancella Messaggio</input></form>";
				echo "<form method='post'><input type='submit' name='modifica' value='$max'>Modifica Messaggio</input></form>";
			}
		}
		$max--;
	}
	if(isset($_POST['descrizione'])){
		//recupero input html
		$descrizione = $_POST['descrizione'];
		//implementazione della sessione
		$_SESSION['descrizione'] = $descrizione;
		header('Location: /descrizione.php');
	}
?>
