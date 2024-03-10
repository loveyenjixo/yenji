<?php
    session_start();
    if (isset($_SESSION["user"])){
        header("Location: index.html");
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header> 
        <h2 class="logo"> <i> Jenny </i> </h2>
        <nav class="navigation">
            <a href="login.php"> Home </a>
            <a href="login.php"> About </a>
            <a href="registration.php"> Gallery </a>
            <a href="registration.php"> Contact </a>
            <a href="registration.php"> Feedback </a>

            </nav>
    </header>

        <?php
        if(isset ($_POST["login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT * FROM user WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    if(password_verify($password, $user["password"])) {
                        $_SESSION["user"] = "yes";
                        header("Location: index.html");
                        die();
                    
                    } else {
                        echo "<div class = 'alert alert-danger'> Password does not match </div>";
                    }
                } else {
                    echo "<div class = 'alert alert-danger'> Email does not match </div>";
                }
            }    
        
        ?>
        
        <form action="login.php" method="post">
            <div class="form-box login">
            <h2><b> Login </b> </h2>
            <div class="input-box">
                <input type="email" id="email" name="email" required>
                <label >Email</label>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" required>
                <label >Password</label>
            </div>

                <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
                <div class="login-register">
                <p>  Don't have an account? 
                    <a href="registration.php" class="register-link"> Register </a>
                </p>
            </div>
            </div>

        
        </form>
        
    </div>

</body>
</html>