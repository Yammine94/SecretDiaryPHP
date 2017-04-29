<?php

    session_start();

    $error = "";    

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


if (strpos($url,'logout') !== false) {
        session_destroy($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";


    /*if (array_key_exists("logout", $_GET)) {
        
        ($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = ""; */ 
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: http://yammine94webdev-com.stackstaging.com/8.9.php/loggedinpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        $link = mysqli_connect("shareddb1a.hosting.stackcp.net","PercivalDatabase-3436a2","George1234","PercivalDatabase-3436a2");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        
        
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {

                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                        mysqli_query($link, $query);

                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

                        } 

                        header("Location: http://yammine94webdev-com.stackstaging.com/8.9.php/loggedinpage.php");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: http://yammine94webdev-com.stackstaging.com/8.9.php/loggedinpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }

include ("header.php");
?>

<div class="container" id="homePageContainer">

  <h1>Secret Diary</h1>
    <p><strong>Store your thoughts permanently and securely!</strong></p>
<?php
    if($error != ""){
        echo '<div id="error" class="alert alert-danger" role="alert">'.$error.'</div>';
    }

    ?>

<form method="POST" id="signUpForm">

        <p>Interested? Sign Up Now!</p>

            <fieldset class="form-group">
                <input name="email" type="text" placeholder="Email Adress" class="form-control">
            </fieldset>
            <fieldset class="form-group">
                <input name="password" type="password" placeholder="Password" class="form-control">
            </fieldset>
            <div class="form-inline checkbox">
                <label>
                    <input type="checkbox" name="stayLoggedIn" value= 1>
                    Stay Logged In
                </label>
            </div>           
            <fieldset class="form-group">
                <input type="hidden" name="signUp" value = '1'>
                <input type="submit" value="Sign Up" name="submit" class="btn btn-success">
            </fieldset>

            <p><a class="toggleForms">Log In</a></p>
        </form>


        <form method="POST" id="logInForm">

        <p>Log In using your Username and Password.</p>

            <fieldset class="form-group">
                <input name="email" type="text" placeholder="Email Adress" class="form-control">
            </fieldset>
            <fieldset class="form-group">
                <input name="password" type="password" placeholder="Password" class="form-control">
            </fieldset>
            <div class="form-inline checkbox">
                <label>
                    <input type="checkbox" name="stayLoggedIn" value= 1>
                    Stay Logged In
                </label>
            </div> 
            <fieldset class="form-group">
                <input type="hidden" name="signUp" value = '0'>
                <input type="submit" value="Log In" name="submit" class="btn btn-success">
            </fieldset>

            <p><a class="toggleForms">Sign Up</a></p>

        </form>
</div>

<?php include("footer.php"); ?>