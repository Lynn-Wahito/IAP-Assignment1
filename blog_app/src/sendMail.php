<?php 
date_default_timezone_set('Africa/Nairobi');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPException;

require "../../vendor/autoload.php";
require_once '../../config/db_connection.php';

class SignUpMail{
    private $mail;

    public function __construct(){
        $this->mail = new PHPMailer();
    }

    public function sendMail($email, $Fname, $Lname, $subject, $token, $password, $role){
        try{
        $this->mail->isSMTP();
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "ian.njihia@strathmore.edu";
        $this->mail->Password = "bkom rdsm pyem dcwf";
        $this->mail->SMTPSecure = "tls";
        $this->mail->Port = 587;

        $this->mail->setFrom("ian.njihia@strathmore.edu", "Don't Reply");
        $this->mail->addAddress($email, $Fname);

        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;

        
        $confirmationLink = "http://localhost/blog_app_org%20-Mailer/src/RegProcesses/confirm_email.php?token=$token" ;        
        $confirmationLink = htmlspecialchars($confirmationLink);
        //style the next 3 lines
        $this->mail->Body = '<div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">';
        $this->mail->Body .= "Hello $Fname,<br><br>";
        $this->mail->Body .= "Welcome to our website! Please click the following link to confirm your email address:<br>";
        $this->mail->Body .= '<a href="' . $confirmationLink . '" style="color: #007bff; text-decoration: none; font-weight: bold;">Click here</a>';
        $this->mail->Body .= '</div>';


        $pass = md5($password);
        
        if($this->mail->send()){
            $msg = "Check your email to complete your registration.";
            // header('./RegProcesses/confirm_email.php');
        } else {
            $msg = "Email could not be sent.";
        }

        return $msg;
    }catch(Exception $e){
        return 'Email error: ' .$e->getMessage();
    }
    }
}

if(isset($_POST["submit"]))
    $subject = "Account Set Up";
    echo "<div style=\"text-align:centre; align-items:centre; justify-content:centre; \" > <h4>Account Set up <span style=\"font-size:17px; font-family: Arial, sans-serif;\">$subject</span></h4></div>";

    
    $signUpMail = new SignUpMail();

    // Get the email and other necessary data from the form submission
    $email = $_POST["email"];
    $Fname = $_POST["Fname"];
    $Lname = $_POST["Lname"];
    $name = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $token = bin2hex(random_bytes(32));
    $token_expiry = date("Y-m-d H:i:s", strtotime("+24 hours"));

   if(empty($password)){
    echo "Password cannot be empty";
    exit();
   }

    
    $msg = $signUpMail->sendMail($email, $Fname, $Lname, $subject, $token, $password, $role);

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
    } else {
        $stmt = $db_connect->prepare("INSERT INTO users (Fname, Lname, username, email, password, role, token, token_expiry) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        
        if ($stmt) {
            $pass =md5($password);
            
            $stmt->bind_param("ssssssss", $Fname, $Lname, $name, $email, $pass, $role, $token, $token_expiry);

            
            if ($stmt->execute()) {
                // Redirect back to the form with a message
                header("Location: ../../sign_up.php?msg=" . urlencode($msg));
                exit();
            } else {
                echo "Error while inserting data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $db_connect->error;
        }
    }
}
?>
