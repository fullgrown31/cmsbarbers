<?php

if(!isset($_SESSION))
{
	session_start();
}

require('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$username = '';


if($_GET['user_id'])
{
	$user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
	$query = "SELECT id, title, image FROM posts WHERE user_id = :user_id";
    $poststatement = $db->prepare($query);
    $poststatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $poststatement->execute();

	$query = "SELECT username, bio, avatar, user_id FROM admin WHERE user_id = :user_id";
    $barberstatement = $db->prepare($query);
    $barberstatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $barberstatement->execute();
    $brow = $barberstatement->fetch();

    $username = $brow['username'];
}

if($_POST && isset($_POST['book']))
{
	$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

	$client_id = filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);

	$specifics = filter_input(INPUT_POST, 'specifics', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

	$date = $_POST['appointmentdate'];

	$time = $_POST['appointmenttime'];

	$appointment_time = $date . " " . $time;

	$emailaddress = $_SESSION['email'];

	$query = "INSERT INTO appointments (user_id, client_id, appointment_time, specifics) VALUES (:user_id, :client_id, :appointment_time, :specifics)";

    $statement = $db->prepare($query);

    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':client_id', $client_id);
    $statement->bindValue(':appointment_time', $appointment_time);
    $statement->bindValue(':specifics', $specifics);

    $statement->execute();

	$mail = new PHPMailer(true);
	try {                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'thegentlemanscuts@gmail.com';                 // SMTP username
    $mail->Password = '@Fullgrown31';                           // SMTP password
    $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;

    $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
    // TCP port to connect to

    //Recipients
    $mail->setFrom('no-reply@thegentlemanscuts.com
	', "The Gentleman's Cut");
    $mail->addAddress($emailaddress);     // Add a recipient
    /*
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
	
    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	*/
    //Content
    $mail->isHTML(true);  
	
    // Set email format to HTML
    $mail->Subject = 'Hello ' . $_SESSION['username'] . ' and thank you for booking your appointment';
    $mail->Body    = 'Your appointment is booked! You have an appointment with ' . $username . ' Remember: It is on ' . $appointment_time . '. We have saved your specifics: '. $specifics . '.';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

	} catch (Exception $e) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
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
	<div id="gallery">
		<h1>My Cuts</h1>
		<?php while($row = $poststatement->fetch()):?>
	        <div id="image">
	          <a href="showpost.php?id=<?= $row['id'] ?>">
	            <img src="haircutimages/<?= $row['image'] ?>">
	            <div id="desc"><?=$row['title']?>
	            </div>
	          </a>
	        </div>
      <?php endwhile?>
	</div>
	
	<div id="myprofile">
		<h1 style="text-align: center;"><?=$brow['username']?></h1>
		<img src="avatars/<?=$brow['avatar']?>">
		<p><?=$brow['bio']?></p>
		<div id="form">
		<?php if(isset($_SESSION['username'])):?>
			<form method="post" action="showbarber.php?user_id=<?=$brow['user_id']?>" >
			<h2>Book Appointment</h2>
			<input type="hidden" name="user_id" value="<?=$brow['user_id']?>">
			<input type="hidden" name="client_id" value="<?=$_SESSION['client_id']?>"
			<label for="name">Name</label>
			<input type="text" name="name">
			<label for="appointmentdate">Date</label>
			<input type="date" name="appointmentdate">
			<label for="appointmenttime">Time</label>
			<input type="time" name="appointmenttime">
			<label for="specifics">Specifics</label>
			<input type="text" name="specifics">
			<input type="submit" name="book" value = "Book">
			</form>
		<?php endif; ?>
		</div>
	</div>

	</div>
	<?php include('footer.php'); ?>
</body>
</html>