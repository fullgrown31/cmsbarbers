<?php
	require('connect.php');

	$query = "SELECT * FROM clients";

	$statement = $db->prepare($query);
	$statement->execute();

	$row = $statement->fetch();

	if ($_POST) {

		$error = 0;
    	// Filter user input
    	$username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
	    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
	    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
	    $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

	    while ($row = $statement->fetch()) {
	    	if($username == $row['username'])
	    	{
	    		$error = 1;
	    	}
	    }
	    if($error == 0)
	    {
	    	if($confirmpassword == $password)
		    {
		    	$hash = crypt($password);
				// Declare query to database
				$query = "INSERT INTO clients (username, password, email, hash) VALUES (:username, :password, :email, :hash)";

				$statement = $db->prepare($query);

				$statement->bindValue('username', $username);
				$statement->bindValue('password', $password);
				$statement->bindValue('email', $email);
				$statement->bindValue('hash', $hash);
				$statement->execute();
				
				header("Location: client_login.php");
			    exit;
		    } else {
		    	echo "Password Mismatched.";
		    }
	    } else {
	    	echo "Username already taken.";
	    }
	    

	    
    } 
?>
<!DOCTYPE html>
<html>
	<title>The Gentleman's Cut</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="webstyle.css">
	<?php include('font.php') ?>
	<body>

	<?php include('header.php') ?>
	<div id = "maincontent">
		<h2>Sign Up</h2>
		<div id="form">
			<form method="post" action="client_signup.php">
		        <label for="username">Username </label>
		        <input id="username" name="username" type="text">
		        <label for="password">Password </label>
		        <input id="password"  name="password" type="text">
		        <label for="confirmpassword">Confirm Password </label>
		        <input id="confirmpassword"  name="confirmpassword" type="text">
		        <label for="email">Email </label>
		        <input id="email"  name="email" type="text">
		        <input type="submit" value="Sign Up">
		      </form>
		      <p>Already a client? <a href="client_login.php">Login</a></p>
		</div>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>