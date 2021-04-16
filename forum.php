<?php
	//connessione al database
	require_once 'connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	//avvio della sessione
	session_start();
	
	//recupero del numero di messaggi inviati nei forum
	$sql="select count(*) as total from anime'";
	$result=mysqli_query($conn,$sql);
	$data=@mysqli_fetch_assoc($result);
	$anime = $data['total'];
	
	$sql="select count(*) as total from arte";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$arte = $data['total'];
	
	$sql="select count(*) as total from cinema";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$cinema = $data['total'];
	
	$sql="select count(*) as total from compiti";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$compiti = $data['total'];
	
	$sql="select count(*) as total from cucina";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$cucina = $data['total'];
	
	$sql="select count(*) as total from gaming";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$gaming = $data['total'];
	
	$sql="select count(*) as total from hobby";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$hobby = $data['total'];
	
	$sql="select count(*) as total from informatica";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$informatica = $data['total'];
	
	$sql="select count(*) as total from musica";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$musica = $data['total'];
	
	$sql="select count(*) as total from sport";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$sport = $data['total'];
	
	$sql="select count(*) as total from altro";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$altro = $data['total'];
	
	$tot = $anime + $arte + $cinema + $compiti + $cucina + $gaming + $hobby + $informatica + $musica + $sport + $altro;
	function percent($var, $tot){
		$result = $var * 100 / $tot;
		return $result;
	}
	
	$animePercent = @percent($anime, $tot);
	$artePercent = @percent($arte, $tot);
	$cinemaPercent = @percent($cinema, $tot);
	$compitiPercent = @percent($compiti, $tot);
	$cucinaPercent = @percent($cucina, $tot);
	$gamingPercent = @percent($gaming, $tot);
	$hobbyPercent = @percent($hobby, $tot);
	$informaticaPercent = @percent($informatica, $tot);
	$musicaPercent = @percent($musica, $tot);
	$sportPercent = @percent($sport, $tot);
	$altroPercent = @percent($altro, $tot);
?>

<html>
	<body>
		<form method="POST">
			<input type="radio" name="forum" value="anime">Anime -<?php echo $anime;?> messaggi(<?php echo $animePercent;?>%)</input><br>
			<input type="radio" name="forum" value="arte">Arte -<?php echo $arte;?> messaggi(<?php echo $artePercent;?>%)</input><br>
			<input type="radio" name="forum" value="cinema">Cinema -<?php echo $cinema;?> messaggi(<?php echo $cinemaPercent;?>%)</input><br>
			<input type="radio" name="forum" value="compiti">Compiti -<?php echo $compiti;?> messaggi(<?php echo $compitiPercent;?>%)</input><br>
			<input type="radio" name="forum" value="cucina">Cucina -<?php echo $cucina;?> messaggi(<?php echo $cucinaPercent;?>%)</input><br>
			<input type="radio" name="forum" value="gaming">Gaming -<?php echo $gaming;?> messaggi(<?php echo $gamingPercent;?>%)</input><br>
			<input type="radio" name="forum" value="hobby">Hobby -<?php echo $hobby;?> messaggi(<?php echo $hobbyPercent;?>%)</input><br>
			<input type="radio" name="forum" value="informatica">Informatica -<?php echo $informatica;?> messaggi(<?php echo $informaticaPercent;?>%)</input><br>
			<input type="radio" name="forum" value="musica">Musica -<?php echo $musica;?> messaggi(<?php echo $musicaPercent;?>%)</input><br>
			<input type="radio" name="forum" value="sport">Sport -<?php echo $sport;?> messaggi(<?php echo $sportPercent;?>%)</input><br>
			<input type="radio" name="forum" value="altro">Altro -<?php echo $altro;?> messaggi(<?php echo $altroPercent;?>%)</input><br>
			<input type="submit" value="Scegliete il forum">
		</form>
	</body>
</html>

<?php
	if(isset($_POST['forum'])){
		//recupero input html
		$forum = $_POST['forum'];
		//implementazione della sessione
		$_SESSION['forum'] = $forum;
		header('Location: /forumChat.php');
	}
?>

<html>
	<body>
		<a href='/index.php'>Torna alla pagina home</a>
	</body>
</html>
