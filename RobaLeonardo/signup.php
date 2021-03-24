<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $valid = true;
    
    if (strlen($username)>12) {
				$valid = false;
        echo '<br>username troppo lungo';
    }
    
    if (strlen($username)<4) {
				$valid = false;
				echo '<br>username troppo corto';
		}
		
		if (!ctype_alnum($username)){
				$valid = false;
				echo '<br>il username puo\' contenere solo lettere e numeri';
		}
		
		if (strlen($password) > 60) {
				$valid = false;
				echo '<br>il password e\' troppo lungo';
		}
		
		if (strlen($password) < 8) {
				$valid = false;
				echo '<br>il password e\' troppo corto, scegliete uno piu\' potente';
		}
		
		if (strlen($email) > 40) {
			  $valid = false;
			  echo '<br>l\'email e\' troppo lungo';
		}
		
		if ($valid) {
			
		}
		
?>
