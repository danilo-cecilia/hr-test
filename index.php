<?php  
//Start the Session
session_start();
require('dbConnect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
$errorMsg = '';
if (isset($_POST['username']) and isset($_POST['password'])){
    $count = 0;
    //3.1.1 Assigning posted values to variables.
    $username = $_POST['username'];
    $password = $_POST['password'];
    //3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `user` WHERE username='".$username."' and password='".md5($password)."'";
    
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $userRow = mysqli_fetch_assoc($result);
    
    $count = mysqli_num_rows($result);
    //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    
    if ($count == 1){
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userRow['userid'];
        $_SESSION['first_name'] = $userRow['first_name'];
        $_SESSION['last_name'] = $userRow['last_name'];
        $_SESSION['email'] = $userRow['email'];
        $_SESSION['position'] = $userRow['position'];
        
        if ($userRow['personality'] == '0' && $userRow['bigfive'] == '0' && $userRow['optimism'] == '0') {
            header('Location: thanks.php');
        }
        else
        {
            header('Location: bigFive.php');
        }
    }else{
        //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        $errorMsg = "<span style='color:red'>Invalid Login Credentials.</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Login</title>
  </head>
  <body class="align">
    <div class="grid">
    <?php echo $errorMsg; ?>
      <form method="post" class="form login">
        <header class="login__header">
          <h3 class="login__title">Login</h3>
        </header>

        <div class="login__body">
          <div class="form__field">
            <input type="text" name="username" placeholder="Username" required />
          </div>

          <div class="form__field">
            <input type="password" name="password" placeholder="Password" required />
          </div>
        </div>

        <footer>
          <input type="submit" class="c__button" value="Login" />
        </footer>
      </form>
    </div>
  </body>
</html>
