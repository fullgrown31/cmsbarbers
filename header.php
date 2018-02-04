<script>

var sidebarIsOpen = false;

function sidebar(x) {
  if(sidebarIsOpen == false)
  {
    document.getElementById("mySidebar").style.width = "25%";
    document.getElementById("mySidebar").style.display = "inline";
    sidebarIsOpen = true;
  }
  else {
    document.getElementById("mySidebar").style.display = "none";
    sidebarIsOpen = false;
  }
  x.classList.toggle("change");
}
</script>

<style>
.openNav {
	display: inline-block;
    cursor: pointer;
    padding: 7.5px 10px;
}

.bar1, .bar2, .bar3 {
    width: 35px;
    height: 5px;
    background-color: #fff;
    margin: 6px 0;
    transition: 0.4s;
}

.change .bar1 {
    -webkit-transform: rotate(-45deg) translate(-9px, 6px) ;
    transform: rotate(-45deg) translate(-9px, 6px) ;
    background-color: gold;
}

.change .bar2 {opacity: 0;}

.change .bar3 {
    -webkit-transform: rotate(45deg) translate(-8px, -8px) ;
    transform: rotate(45deg) translate(-8px, -8px) ;
    background-color: gold;
}

<?php
  $name = '';

  if(!isset($_SESSION))
  {
    session_start();
  }

  $pagelimit = 6;

  if(isset($_GET['page']))
  {
    $page = $_GET['page'];
  } else {
    $page = 0;
  }
  
  if($page=="" || $page =="1")
  {
    $currentpage=0;
  }
  else{
    $currentpage=($page*$pagelimit)-$pagelimit;
  }

  if(!isset($_GET['psearch']) || !isset($_GET['bsearch']))
  {
    $query = "SELECT posts.image, posts.title, admin.username, admin.user_id, posts.id  FROM posts, admin WHERE posts.user_id = admin.user_id ORDER BY postdate DESC LIMIT $currentpage, $pagelimit";

    $statement = $db->prepare($query);

    $statement->execute();

    $query = "SELECT * FROM admin";

    $barberstatement = $db->prepare($query);

    $barberstatement->execute();

    $query = "SELECT * FROM posts ORDER BY postdate DESC";
    $pstatement = $db->prepare($query);

    $pstatement->execute();

    $number_of_pages = ceil($pstatement->rowCount()/$pagelimit);
  }

  if(isset($_GET['bsearch']))
  {
    $name = filter_input(INPUT_GET, 'bsearch', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    // Declare query to database
    $query = "SELECT posts.image, posts.title, admin.username, posts.id  FROM posts, admin WHERE posts.user_id = admin.user_id AND admin.username LIKE '%$name%' ORDER BY posts.postdate DESC LIMIT $currentpage, $pagelimit";

    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    
    $statement->execute();

    $query = "SELECT posts.image, posts.title, admin.username, posts.id  FROM posts, admin WHERE posts.user_id = admin.user_id AND admin.username LIKE '%$name%'";
    $pstatement = $db->prepare($query);

    $pstatement->execute();

    $number_of_pages = ceil($pstatement->rowCount()/$pagelimit);
  }

  if(isset($_GET['psearch']))
  {
    $name = filter_input(INPUT_GET, 'psearch', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    // Declare query to database
      $query = "SELECT posts.image, posts.title, admin.username, posts.id  FROM posts, admin WHERE posts.user_id = admin.user_id AND title LIKE '%$name%' ORDER BY title LIMIT $currentpage, $pagelimit";

      $statement = $db->prepare($query);

      $statement->bindValue(':name', $name);
      
      $statement->execute();

      $query = "SELECT posts.image, posts.title, admin.username, posts.id  FROM posts, admin WHERE posts.user_id = admin.user_id AND title LIKE '%$name%'";

      $pstatement = $db->prepare($query);

      $pstatement->execute();

      $number_of_pages = ceil($pstatement->rowCount()/$pagelimit);
  }

  
  if($_POST)
  {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);

    if($_POST['selection'] == "barber")
    {
      
      header("Location: index.php?bsearch=$name");
    }
    if($_POST['selection'] == "post")
    {
      
      header("Location: index.php?psearch=$name");
    }
  }
?>

</style>
<div id="header">
    <div class="openNav" onclick="sidebar(this)">
      <div class="bar1"></div>
      <div class="bar2"></div>
      <div class="bar3"></div>
    </div>
  <h1><a href="index.php">The Gentleman's Cut</a></h1>
  <?php if(isset($_SESSION['username'])): ?>
    <p>Hello <?=$_SESSION['username']?></p>
    <div id="searchbar">
      <form method="post" action="index.php">
        <select name="selection">
          <option value="post">Posts</option>
          <option value="barber">Barbers</option>
        </select>
        <input id="name" name="name" type="text">
        <input type="submit" name="search" value="Search">
      </form>
    </div>
  <?php endif; ?>
</div>

<div style="display:none" id="mySidebar">
	<nav>
		<a href="index.php">Home</a>
    <?php if(isset($_SESSION['Barber'])):?>
	 	 <a href="myprofile.php">My Profile</a>
    <?php elseif(!isset($_SESSION['username'])): ?>
  	 <a href="client_login.php">Clients</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['Barber']) && $_SESSION['Barber'] == "True" && $_SESSION['username'] == "admin") :?>
      <a href="#">MyAdmin</a>
    <?php elseif(!isset($_SESSION['username'])): ?>
      <a href="user_login.php">Barbers</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['username'])):?>
      <a href="log_out.php">Log Out</a>
    <?php endif; ?>
    <a href="#">Contact Us</a>
	</nav>
  
</div>