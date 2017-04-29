<?php
    
include("connection.php");
    session_start();

    $diaryContent = "";

    if (array_key_exists("id", $_COOKIE)) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
        

        $query = "SELECT diary FROM users WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";

        $row = mysqli_fetch_array(mysqli_query($link, $query));

        $diaryContent = $row['diary'];

    } else {
        
        header("Location: http://yammine94webdev-com.stackstaging.com/8.9.php/index.php");
        
    }

    include("header.php");
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Secret Diary</a>
    </div>    
      <a class="btn btn-default navbar-btn" href='http://yammine94webdev-com.stackstaging.com/8.9.php/index.php?logout=1'>Log Out</a>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    <div class="container-fluid">
    
        <textarea id="diary" class="form-control"><?php echo $diaryContent;?></textarea>

    </div>


    <?php include("footer.php"); ?>