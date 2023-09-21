<?php
 require_once 'config/db_connection.php';
 include 'navigations/header.php';

if($_SERVER["REQUEST_METHOD"]=='POST'){
    $Fname = mysqli_real_escape_string($db_connect, $_POST['Fname']);
    $Lname = mysqli_real_escape_string($db_connect, $_POST['Lname']);
    $name = mysqli_real_escape_string($db_connect, $_POST['username']);
    $email = mysqli_real_escape_string($db_connect, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $role = $_POST['role'];

    $select = "SELECT * FROM users WHERE email = '$email' && password = '$pass'";

    $result = mysqli_query($db_connect, $select);
    $error = array();
    if(mysqli_num_rows($result) > 0){

        $error[] = 'user already exist!';
    }
    else{
        if($pass != $cpass){
            $error[] = 'password not matched!';
        }
        else{
            $insert = "INSERT INTO users(Fname, Lname, username, email, password, role) VALUES ('$Fname', '$Lname', '$name', '$email', '$pass', '$role')";
            mysqli_query($db_connect, $insert);
            header('location:sign_in.php');
        }
    }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up page</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="main">
            <section class="reg01">
                <div class="combined01">
                    
                    <div class="contained">
                        <h2>SIGN UP</h2>

                        <?php
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<span class="error-msg">'.$error.'</span>';
                            }
                        }
                        ?>
            
                        <form  action="" method="post">
                           <div class="form-group">
                                <input type="text" name="Fname" required>
                                <span></span>
                                <label>First name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="Lname" required>
                                <span></span>
                                <label>Last name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" required>
                                <span></span>
                                <label>Username</label>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email"required>
                                <span></span>
                                <label>Email</label>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password"required>
                                <span></span>
                                <label>Password</label>
                            </div>
                            <div class="form-group">                                    
                                <input type="password" name="cpassword"required>
                                <span></span>
                                <label>Confirm Password</label>
                            </div>
                            <div class="form-group">
                                <select name="role">
                                    <option value="user">user</option>
                                    <option value="author">author</option>
                                </select>
                            </div>
                            <input type="submit" name="submit" value="Sign Up">
                            <div class="login-link">
                                <p>Already have an account? <a href="sign_in.php">Log-in here</a></p>
                            </div>
                        </form>
                        
                    </div>
                    <div class="hoodie-img01">
                    <img src="https://images.sportsdirect.com/images/imgzoom/53/53602403_xxl.jpg">
                    </div>
                </div>        
            </section>
        </div>
    </div>

</body>
</html>