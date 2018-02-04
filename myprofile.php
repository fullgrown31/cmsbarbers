<?php
  require('connect.php');

  if(!isset($_SESSION))
  {
    session_start();
  }

  if(isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $query = "SELECT * FROM admin WHERE user_id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch();
  }

  function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
  }
  function file_upload_path($original_filename, $upload_subfolder_name = 'haircutimages') {
       $current_folder = dirname(__FILE__);
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

  if($_POST && isset($_POST['submit']))
  {
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    $target = "haircutimages/".basename($_FILES['image']['name']);

    $image = $_FILES['image']['name'];

    $user_id = $_SESSION['user_id'];

    $postdate = date('Y-m-d H:i:s');

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

    if ($image_upload_detected) { 

        $max = 200;

        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        list($width, $height, $type, $attr) = getimagesize($image);

        $resizeimage = $_FILES['image']['name'];

        $size = getimagesize($resizeimage);

        $ratio = $size[0]/$size[1];

        if($ratio > 1) {
          $width = $max;
          $height = $max/$ratio;
        } else {
          $width = $max*$ratio;
          $height = $max;
        }

        $src = imagecreatefromstring(file_get_contents($resizeimage));
        $dst = imagecreatetruecolor($width, $height);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagedestroy($src);
        imagepng($dst, $temporary_image_path);
        imagedestroy($dst);

        if (file_is_an_image($temporary_image_path, $new_image_path)) { 
            move_uploaded_file($temporary_image_path, $target);
        }
    }

    $query = "INSERT INTO posts (title, content, image, user_id, postdate) VALUES (:title, :content, :image, :user_id, :postdate)";

    $statement = $db->prepare($query);

    $statement->bindValue('title', $title);
    $statement->bindValue('content', $content);
    $statement->bindValue('image', $image);
    $statement->bindValue('user_id', $user_id);
    $statement->bindValue('postdate', $postdate);

    $statement->execute();
    header("Location: myprofile.php");
  }
  if($_POST && isset($_POST['update']))
  {
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    $avatar = $_FILES['avatar']['name'];

    $target = "avatars/".basename($_FILES['avatar']['name']);
    
    $avatar = $_FILES['avatar']['name'];

    $user_id = $_SESSION['user_id'];

    $image_upload_detected = isset($_FILES['avatar']) && ($_FILES['avatar']['error'] === 0);
    if ($image_upload_detected) { 

        $image_filename       = $_FILES['avatar']['name'];
        $temporary_image_path = $_FILES['avatar']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        if (file_is_an_image($temporary_image_path, $new_image_path)) { 
          move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        }
    }

    $query = "UPDATE admin SET bio = :bio, avatar = :avatar, email = :email WHERE user_id = :user_id";

    $statement = $db->prepare($query);

    $statement->bindValue('email', $email);
    $statement->bindValue('bio', $bio);
    $statement->bindValue('avatar', $avatar);
    $statement->bindValue('user_id', $user_id);

    $statement->execute();
    header("Location: myprofile.php");
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
    <div id="newpost">
      <form method="post" action="myprofile.php" enctype="multipart/form-data">
      <h2>New Post?</h2>
          <label for="title">Name </label>
          <input id="title" name="title" type="text">
          <label for="content">Content </label>
          <input id="content"  name="content" type="text">
          <label for="Image">Image </label>
          <input name="image" type="file">
          <input type="submit" name="submit" value="Post">
      </form>
    </div>
    <div id="myprofile">
      <form method="post" action="myprofile.php" enctype="multipart/form-data">
      <h2>Your Profile</h2>
          <p>Username: <?=$row['username'] ?></p>
          <label for="bio">Bio </label>
          <input id="bio"  name="bio" type="text" value="<?=$row['bio']?>">
          <label for="email">Email</label>
          <input type="text" name="email" value="<?=$row['email']?>">
          <label for="avatar">Avatar</label>
          <input name="avatar" type="file">
          <input type="submit" name="update" value="Update">
      </form>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>