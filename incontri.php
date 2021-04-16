<?php
	//connettersi al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}

	//recupero session
	session_start();
	$id = $_SESSION["user"];
	
	//
	$query = mysqli_query($conn, "SELECT MAX(user_id) AS MaxPersone FROM utenti");
	$fromObj = @mysqli_fetch_array($query);
	$Persone = $fromObj["MaxPersone"];
	
	if(isset($_POST['descrizione'])){
		//recupero input html
		$descrizione = $_POST['descrizione'];
		//implementazione della sessione
		$_SESSION['descrizione'] = $descrizione;
		header('Location: /descrizione.php');
	}
?>

<html>
	<body>
		<form action="incontri.php" method="POST">
			<h2>Benvenuti alla pagina incontri</h2>
			<h4>Cerca persone per username:</h4>
			<br><input type="text" name="search" placeholder="cerca username"required>
			<input type="submit" value="Invia">
		</form>
	</body>
</html>

<?php
	//semplice programmino di ricerca
	if (isset($_POST["search"])) {
		$search = $_POST["search"];
		$counterId = 1;
		while($counterId <= $Persone){
			$query = mysqli_query($conn, "SELECT username FROM utenti WHERE user_id='$counterId'");
			$fromObj = mysqli_fetch_assoc($query);
			$username = $fromObj['username'];
			if($username == $search){
				$query = mysqli_query($conn, "SELECT description, picture, ruolo FROM utenti WHERE user_id='$counterId'");
				$fromObj = mysqli_fetch_assoc($query);
				$pic = $fromObj['picture'];
				$description = $fromObj['description'];
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
				echo "<h3><form method='post'><input type='submit' name='descrizione' value='$counterId'>$username</input> <strong>$ruolo</strong> </form>$data</h3>";
				echo "<h4>$description</h4>";
			}
			$counterId++;
		}
	}
?>

<html>
	<body>
		 <form action="incontri.php" method="POST">Oppure cliccate <input type="submit" value="qui" name="qui" class="button"> per generare una lista di utenti in ordine di affinità a voi</form>
	</body>
</html>

<?php
	if(array_key_exists('qui', $_POST)) {
		//funzione che preleva il numero di messaggi inviati in un forum da una persona
		function selectInterest($argomento, $conn, $id) {
			$sql="select count(*) as total from $argomento where id='$id'";
			$result=mysqli_query($conn,$sql);
			$data=mysqli_fetch_assoc($result);
			$returnVar = $data['total'];
			return $returnVar;
		}
		//recupero del numero di messaggi inviati nei forum
		$anime = selectInterest("anime", $conn, $id);
		$arte = selectInterest("arte", $conn, $id);
		$cinema = selectInterest("cinema", $conn, $id);
		$compiti = selectInterest("compiti", $conn, $id);
		$cucina = selectInterest("cucina", $conn, $id);
		$gaming = selectInterest("gaming", $conn, $id);
		$hobby = selectInterest("hobby", $conn, $id);
		$informatica = selectInterest("informatica", $conn, $id);
		$musica = selectInterest("musica", $conn, $id);
		$sport = selectInterest("sport", $conn, $id);
		
		//calcolazione della percentuale dell'utente
		$tot = $anime + $arte + $cinema + $compiti + $cucina + $gaming + $hobby + $informatica + $musica + $sport;
		if ($anime != 0) $animePercent = $anime * 100 / $tot; else $animePercent = 0;
		if ($arte != 0) $artePercent = $arte * 100 / $tot; else $artePercent = 0;
		if ($cinema != 0) $cinemaPercent = $cinema * 100 / $tot; else $cinemaPercent = 0;
		if ($compiti != 0) $compitiPercent = $compiti * 100 / $tot; else $compitiPercent = 0;
		if ($cucina != 0) $cucinaPercent = $cucina * 100 / $tot; else $cucinaPercent = 0;
		if ($gaming != 0) $gamingPercent = $gaming * 100 / $tot; else $gamingPercent = 0;
		if ($hobby != 0) $hobbyPercent = $hobby * 100 / $tot; else $animePercent = 0;
		if ($informatica != 0) $informaticaPercent = $informatica * 100 / $tot; else $informaticaPercent = 0;
		if ($musica != 0) $musicaPercent = $musica * 100 / $tot; else $musicaPercent = 0;
		if ($sport != 0) $sportPercent = $sport * 100 / $tot; else $sportPercent = 0;

		
		
		//appena capisco cosa sto facendo lo spiego anche a voi
		$userArray = array();
		$counterId = 1;
		while($counterId <= $Persone){
			//recupero del numero di messaggi inviati nei forum dall'utente di cui si sta calcolando l'affinità
			$animeTipo = selectInterest("anime", $conn, $counterId);
			$arteTipo = selectInterest("arte", $conn, $counterId);
			$cinemaTipo = selectInterest("cinema", $conn, $counterId);
			$compitiTipo = selectInterest("compiti", $conn, $counterId);
			$cucinaTipo = selectInterest("cucina", $conn, $counterId);
			$gamingTipo = selectInterest("gaming", $conn, $counterId);
			$hobbyTipo = selectInterest("hobby", $conn, $counterId);
			$informaticaTipo = selectInterest("informatica", $conn, $counterId);
			$musicaTipo = selectInterest("musica", $conn, $counterId);
			$sportTipo = selectInterest("sport", $conn, $counterId);
		
			//calcolazione della percentuale dell'utente di cui si sta calcolando l'affinità
			$totTipo = $animeTipo + $arteTipo + $cinemaTipo + $compitiTipo + $cucinaTipo + $gamingTipo + $hobbyTipo + $informaticaTipo + $musicaTipo + $sportTipo;
			if($totTipo != 0){
				if ($animeTipo != 0) $animePercentTipo = $animeTipo * 100 / $totTipo; else $animePercentTipo = 0;
				if ($arte != 0) $artePercentTipo = $arteTipo * 100 / $totTipo; else $artePercentTipo = 0;
				if ($cinema != 0) $cinemaPercentTipo = $cinemaTipo * 100 / $totTipo; else $cinemaPercentTipo = 0;
				if ($compiti != 0) $compitiPercentTipo = $compitiTipo * 100 / $totTipo; else $compitiPercentTipo = 0;
				if ($cucina != 0) $cucinaPercentTipo = $cucinaTipo * 100 / $totTipo; else $cucinaPercentTipo = 0;
				if ($gaming != 0) $gamingPercentTipo = $gamingTipo * 100 / $totTipo; else $gamingPercentTipo = 0;
				if ($hobby != 0) $hobbyPercentTipo = $hobbyTipo * 100 / $totTipo; else $animePercentTipo = 0;
				if ($informatica != 0) $informaticaPercentTipo = $informaticaTipo * 100 / $totTipo; else $informaticaPercentTipo = 0;
				if ($musica != 0) $musicaPercentTipo = $musicaTipo * 100 / $totTipo; else $musicaPercentTipo = 0;
				if ($sport != 0) $sportPercentTipo = $sportTipo * 100 / $totTipo; else $sportPercentTipo = 0;
			}
			
			//calcolo della differenza tra il tipo e l'utente
			$animePercentRelativ = abs($animePercentTipo - $animePercent) * $animePercent;
			$artePercentRelativ = abs($artePercentTipo - $artePercent) * $artePercent;
			$cinemaPercentRelativ = abs($cinemaPercentTipo - $cinemaPercent) * $cinemaPercent;
			$compitiPercentRelativ = abs($compitiPercentTipo - $compitiPercent) * $compitiPercent;
			$cucinaPercentRelativ = abs($cucinaPercentTipo - $cucinaPercent) * $cucinaPercent;
			$gamingPercentRelativ = abs($gamingPercentTipo - $gamingPercent) * $gamingPercent;
			$hobbyPercentRelativ = abs($hobbyPercentTipo - $hobbyPercent) * $hobbyPercent;
			$informaticaPercentRelativ = abs($informaticaPercentTipo - $informaticaPercent) * $informaticaPercent;
			$musicaPercentRelativ = abs($musicaPercentTipo - $musicaPercent) * $musicaPercent;
			$sportPercentRelativ = abs($sportPercentTipo - $sportPercent) * $sportPercent;
			$totDif = $animePercentRelativ + $artePercentRelativ + $cinemaPercentRelativ + $compitiPercentRelativ + $cucinaPercentRelativ + $gamingPercentRelativ + $hobbyPercentRelativ + $informaticaPercentRelativ + $musicaPercentRelativ + $sportPercentRelativ;
			array_push($userArray, $totDif);
			
			$counterId ++;
		}
		
		//stampaggio di una lista di persone simili
		$counter = 0;
		$userTrovati = array($id);
		while($counter < $Persone){
			$counterId = 0;
			$ValoreMinimoTrovato = 999999999999;
			while($counterId < $Persone){
				if(!in_array(($counterId + 1),$userTrovati)){
					$ValoreDaControllare = $userArray[$counterId];
					if($ValoreDaControllare < $ValoreMinimoTrovato){
						$ValoreMinimoTrovato = $ValoreDaControllare;
						$personaSimile = $counterId + 1;
					}
				}
				$counterId++;
			}
			$counter++;
			array_push($userTrovati, $personaSimile);
			
			//un po' di cose grafiche
			$query = mysqli_query($conn, "SELECT username, description, picture, ruolo FROM utenti WHERE user_id='$personaSimile'");
			$fromObj = mysqli_fetch_assoc($query);
			$pic = $fromObj['picture'];
			$description = $fromObj['description'];
			$ruolo = $fromObj['ruolo'];
			$username = $fromObj['username'];
			if($username != NULL){
				if($ruolo == 1){
					$ruolo = 'Donatore';
				} else if($ruolo == 2){
					$ruolo = 'Sviluppatore';
				} else if($ruolo == 3){
					$ruolo = 'Moderatore';
				}
				$pic = $fromObj["picture"];
				echo "<img src=/profili/im$pic.jpg>";
				echo "<h3><form method='post'><input type='submit' name='descrizione' value='$personaSimile'>$username</input> <strong>$ruolo</strong> </form>$data</h3>";
				echo "<h4>$description</h4>";
			}
		}
	}
?>
