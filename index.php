<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cssFolder/index.css">
    <link rel="shortcut icon" type="image/png" href="./imagesFolder/faviconImg.png">
    <title>FerMe</title>
</head>
<body>
    <input type="checkbox" id="showMenu">
    <div class="cookiePopup">
        <img class="cookieImg" src="imagesFolder/cookieIcon.png">
        <div class="content">
            <h3>Cookie</h3>
            <p>Usiamo i cookie per permettervi di avere un'esperienza<br> individualmente propria all'interno di FerMe.
            Ti ricordiamo che questo sito è <strong>OPEN SOURCE</strong> e puoi controllare come gestiamo i tuoi dati nella nostra pagina GitHub. In alternativa puoi guardare la nostra Privacy Policy.</p>
            <button type="button" class="popupBtn">OK</button><br>
            <a href="./privacyPolicy.html" target="_blank" rel="noopener noreferrer" class="linkPrivacyPolicy">Privacy policy</a><a href="https://github.com/scratchx98/ferme" class="linkGithub" target="_blank" rel="noopener noreferrer">Github</a>
        </div>
    </div>

    <script>
        const cookiePopup = document.querySelector(".cookiePopup");
        popupBtn = cookiePopup.querySelector(".content button");

        popupBtn.onclick = () => {
            document.cookie = "FerMe";
            if(document.cookie){
                // If cookie is there
                cookiePopup.classList.add("hide");
            }else{
                alert("Il cookie non può essere creato!");
            }
        }
        // This function will hide the cookie popup is there is the cookie
        let ifCookie = document.cookie.indexOf("FerMe");
        // If the string can't be found on the cookies of the user, return -1
        ifCookie != -1 ? cookiePopup.classList.add("hide") : cookiePopup.classList.remove("hide");
    </script>
</html>

<?php
	//connessione al database
	require_once '/home/vhosts/ferme.eu5.org/connect.php';
	$conn = new mysqli('localhost', $usernameSql, $passwordSql, $usernameSql);
	if ($conn->connect_error) {
		die("Errore di connessione!");
	}
	
	session_start();
	$id = $_SESSION['user'];
	if($id == NULL){
		echo '<header>
				<label for="showMenu" class="showMenuBtn"><img src="./imagesFolder/ShowMenuIcon.png"></label>
				<img class="fermeLogo" src="./imagesFolder/fermeLogo.png">
				<a type="button" href="./signup.html" target="_blank" rel="noopener noreferrer" class="regBtn">Registrati</a>
			</header>';
	} else {
		$query = mysqli_query($conn, "SELECT username FROM `utenti` WHERE user_id = '$id'");
		$fromObj = mysqli_fetch_assoc($query);
		$username = $fromObj['username'];
		echo "<header>
				<label for=\"showMenu\" class=\"showMenuBtn\"><img src=\"./imagesFolder/ShowMenuIcon.png\"></label>
				<img class=\"fermeLogo\" src=\"./imagesFolder/fermeLogo.png\">
				<p class=\"welcomeTxt\">Benvenuto, $username!</p>
			</header>";
	}
?>

<html>
    <div class="sidebar">
        <ul>
            <li>
                <a href="/index.html">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M21 13v10h-6v-6h-6v6h-6v-10h-3l12-12 12 12h-3zm-1-5.907v-5.093h-3v2.093l3 3z"/></svg>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="/incontri.php">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M17.997 18h-11.995l-.002-.623c0-1.259.1-1.986 1.588-2.33 1.684-.389 3.344-.736 2.545-2.209-2.366-4.363-.674-6.838 1.866-6.838 2.491 0 4.226 2.383 1.866 6.839-.775 1.464.826 1.812 2.545 2.209 1.49.344 1.589 1.072 1.589 2.333l-.002.619zm4.811-2.214c-1.29-.298-2.49-.559-1.909-1.657 1.769-3.342.469-5.129-1.4-5.129-1.265 0-2.248.817-2.248 2.324 0 3.903 2.268 1.77 2.246 6.676h4.501l.002-.463c0-.946-.074-1.493-1.192-1.751zm-22.806 2.214h4.501c-.021-4.906 2.246-2.772 2.246-6.676 0-1.507-.983-2.324-2.248-2.324-1.869 0-3.169 1.787-1.399 5.129.581 1.099-.619 1.359-1.909 1.657-1.119.258-1.193.805-1.193 1.751l.002.463z"/></svg>
                    <span>Incontri</span>
                </a>
            </li>
            <li>
                <a href="/forum.php">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.738 4.063 2.047 5.625.055 1.83-1.023 4.456-1.993 6.368 2.602-.47 6.301-1.508 7.978-2.536 9.236 2.247 15.968-3.405 15.968-9.457 0-5.812-5.701-10.007-12-10.007zm0 14h-6v-1h6v1zm6-3h-12v-1h12v1zm0-3h-12v-1h12v1z"/></svg>
                    <span>Forum</span>
                </a>
            </li>
            <li>
                <a href="/profile.php">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z"/></svg>
                    <span>Profilo</span>
                </a>
            </li>
            <li>
                <a href="/progettiEsterni.html">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7 16h10v1h-10v-1zm0-1h10v-1h-10v1zm15-13v22h-20v-22h3c1.229 0 2.18-1.084 3-2h8c.82.916 1.771 2 3 2h3zm-11 1c0 .552.448 1 1 1s1-.448 1-1-.448-1-1-1-1 .448-1 1zm9 1h-4l-2 2h-3.898l-2.102-2h-4v18h16v-18zm-13 9h10v-1h-10v1zm0-2h10v-1h-10v1z"/></svg>
                    <span>Progetti esterni</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="mainContent">
        <div class="welcomeBlock">
            <h1>Benvenuto a FerMe</h1>
            <p>Benvenuto in FerMe, il sito in cui conoscere persone,<br> fare amici e coltivare i tuoi hobby.</p>
            <img src="./imagesFolder/homeImg.svg">
        </div>
    </div>
</body>
</html>
