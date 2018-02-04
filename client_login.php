<?php
	require('connect.php');
	

	if($_POST && isset($_POST['login']))
	{
		$username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
	    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

	    $query = "SELECT * FROM clients WHERE username = :username";
	    $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $row = $statement->fetch();

        if($row['hash'] != null && hash_equals($row['hash'], crypt($password, $row['hash'])))
        {
        	if(!isset($_SESSION))
			{
				session_start();
			}
        	$_SESSION['LoggedIn'] = "True";
        	$_SESSION['client_id'] = $row['client_id'];
        	$_SESSION['username'] = $row['username'];
        	$_SESSION['email'] = $row['email'];
        	header("Location: index.php");
        } else {
        	echo "Incorrect Username/Password.";
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
		<h2>Client Login</h2>
		<div id="form">
			<form method="post" action="">
		        <label for="username">Username </label>
		        <input id="username" name="username" type="text">
		        <label for="password">Password </label>
		        <input id="password"  name="password" type="text">
		        <input type="submit" name="login" value="Login">
		      </form>
		      <p>New Client? <a href="client_signup.php">Sign Up</a></p>
		</div>
	</div>
	<?php include('footer.php'); ?>
</body>
</html>