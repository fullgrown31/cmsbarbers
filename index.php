<?php
  require('connect.php');
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
      <?php if(isset($_GET['bsearch'])): ?>
        <p>Barber results for <?=$_GET['bsearch']?></p>
      <?php elseif(isset($_GET['psearch'])):?>
        <p>Post results for <?=$_GET['psearch']?></p>
      <?php else: ?>
        <h1>Recent Posts</h1>
      <?php endif; ?>
      <?php while($row = $statement->fetch()):?>
        <div id="image">
          <a href="showpost.php?id=<?= $row['id'] ?>">
            <img src="haircutimages/<?= $row['image'] ?>">
            <div id="desc"><?=$row['title']?><br><br> by <?=$row['username']?></div>
          </a>
        </div>
      <?php endwhile?>
      
      <div id="pageno">
        <br>
        <br>
        <?php if(isset($number_of_pages) && $number_of_pages>1): ?>
          <?php if(isset($_GET['bsearch'])): ?>
            <?php for($i=1;$i<=$number_of_pages;$i++): ?>
              <a href="index.php?bsearch=<?=$name?>&page=<?=$i?>"><?=$i?></a>
            <?php endfor; ?>
          <?php elseif(isset($_GET['psearch'])): ?>
            <?php for($i=1;$i<=$number_of_pages;$i++): ?>
              <a href="index.php?psearch=<?=$name?>&page=<?=$i?>"><?=$i?></a>
            <?php endfor; ?>
          <?php else: ?>
            <?php for($i=1;$i<=$number_of_pages;$i++): ?>
              <a href="index.php?page=<?=$i?>"><?=$i?></a>
            <?php endfor; ?>
          <?php endif; ?>
      <?php endif; ?>
      </div>
    </div>
    <div id="side">
      <h1>Barbers</h1>
      <?php while($row = $barberstatement->fetch()):?>
        <div id="profile">
          <a href="showbarber.php?user_id=<?=$row['user_id']?>">
            <img src="avatars/<?= $row['avatar'] ?>">
            <div id="profilename"><?=$row['username']?>
            </div>
          </a>
        </div>
      <?php endwhile?>
    </div>
  </div>
  <?php include('footer.php'); ?>

</body>
</html>