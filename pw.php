	<form action="pw.php" method="post">
	Username: <input type="text" name="username" /><br>
	Password: <input type="password" name="password" /><br>
	<input type="submit" value="Login!"/>
	</form> 

<?php
	echo hash("sha512",$_POST['username'].$_POST['password']);
?>
