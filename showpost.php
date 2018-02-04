<?php
  require('connect.php');
  session_start();
  if(isset($_GET['id']))
  {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $commentquery = "SELECT * FROM comments WHERE post_id = :post_id ORDER BY postdate DESC";

    $commentstatement = $db->prepare($commentquery);
    $commentstatement->bindValue(':post_id', $id, PDO::PARAM_INT);
    $commentstatement->execute();
    $commentrow = $commentstatement->fetch();
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

  if(isset($_GET['id'])){

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
          
    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT posts.image, posts.title, posts.content, admin.username , posts.id, posts.postdate FROM posts, admin WHERE posts.id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $row = $statement->fetch();
  }
  if (isset($_POST['delete'])) {
    $post_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM comments WHERE post_id = :post_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':post_id', $post_id);
    $statement->execute();

    $query = "DELETE FROM posts WHERE id = :post_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':post_id', $post_id);
    $statement->execute();

    header("Location: index.php");
  } elseif(isset($_POST['submit'])  && isset($_POST['post_id'])) {
    $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

    $postdate = date('Y-m-d H:i:s');



    // Declare query to database
    $commentquery = "INSERT INTO comments (name, comment, post_id, postdate) VALUES (:name, :comment, :post_id, :postdate)";
    
    $commentstatement = $db->prepare($commentquery);

    $commentstatement->bindValue(':postdate', $postdate);
    $commentstatement->bindValue(':name', $name);
    $commentstatement->bindValue(':comment', $comment);
    $commentstatement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $commentstatement->execute();
    $commentrow = $commentstatement->fetch();
    
    $commentstatement->execute();
    $commentrow = $commentstatement->fetch();
    header("Location: showpost.php?id=$post_id");
  }

  if (isset($_GET['delete_id'])) {
    $delete_id = filter_input(INPUT_GET, 'delete_id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM comments WHERE comment_id = :delete_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':delete_id', $delete_id);
    $statement->execute();
  }

  if(isset($_POST['title']) && isset($_POST['update']))
  {

    $target = "haircutimages/".basename($_FILES['image']['name']);

    $image = $_FILES['image']['name'];

    $user_id = $_SESSION['user_id'];

    $updatedate = date('Y-m-d H:i:s');

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

    if ($image_upload_detected) { 
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        if (file_is_an_image($temporary_image_path, $new_image_path)) { 
            move_uploaded_file($temporary_image_path, $new_image_path);
        }
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    $query     = "UPDATE posts SET title = :title, content = :content, image = :image, user_id = :user_id, updatedate = :updatedate WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue('image', $image);
    $statement->bindValue('user_id', $user_id);
    $statement->bindValue('updatedate', $updatedate);
    $statement->execute();
    header("Location: index.php");
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
    <div id = "fullpost">
      <img src="haircutimages/<?= $row['image'] ?>">
      
      <?php if(isset($_SESSION['Barber'])) : ?>
        <div id="form">
          <form method="post" action="showpost.php" enctype="multipart/form-data">
            <label for="title"> Title</label>
            <input type="text" name="title" value="<?=$row['title']?>">
            <label for="content"> Content</label>
            <input type="text" name="content" value="<?=$row['content']?>">
            <label for="Image"> Image</label>
            <input type="file" name="image" value="<?=$row['image']?>">
            <input type="hidden" name="id" value="<?=$row['id'] ?>">
            <input type="submit" name="update" value= "Update">
            <input type="submit" name="delete" value= "Delete">
          </form>
        </div>
      <?php else: ?>
        <h2><?= $row['title'] ?></h2>
        <p><?= $row['content'] ?></p>
        <p>By <?= $row['username'] ?></p>
        <p>Created <?= $row['postdate'] ?></p>
        <?php endif;?>
      <div id="commentsection">
        <p>Comment?</p>
        <div id="form">
          <form method="post" action="showpost.php">
            <label for="name">Name</label>
            <input type="text" name="name">
            <label for="comment">Comment</label>
            <input type="text" name="comment">
            <input type="hidden" name="post_id" value="<?=$row['id'] ?>">
            <input type="submit" name="submit" value= "Post">
          </form>
        </div>
        <p>Comment Section</p>
        <?php while($commentrow = $commentstatement->fetch()):?>
          <div id="commentblock">
            <span>Name: <?= $commentrow['name'] ?></span>
            <p><?= $commentrow['comment'] ?></p>
            <?php if(isset($_SESSION['Barber']) && $_SESSION['Barber'] == "True"): ?>
              <a href="showpost.php?id=<?=$row['id']?>&delete_id=<?= $commentrow['comment_id']?>">Delete</a>
            <?php endif; ?>
            <span><?= $commentrow['postdate'] ?></span>
          </div>
        <?php endwhile?>
      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>