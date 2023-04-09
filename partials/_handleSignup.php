<?php
$showError = "false";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($user_email, $v_code)
{
    require("phpmailer/PHPMailer.php");
    require("phpmailer/SMTP.php");
    require("phpmailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'satodiyanishit2002@gmail.com';                  //SMTP username
        $mail->Password   = 'qqcmmiiyhunrgzdh';                             //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('satodiyanishit2002@gmail.com', 'Satodiya Nishit');
        $mail->addAddress($user_email);     //Add a recipient
       
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email verification from iDiscuss';
        $mail->Body    = "Thanks for the Registration
                          Click the link below to verify your email address
                          <a href='http://localhost/forum/verify.php?email=$user_email&v_code=$v_code'>Verify</a>";
                          
        $mail->send();
        echo 'Message has been sent';
    } 
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];
    
    //check whether this email exists or not

    $existSql = "SELECT * from `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "Email is already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $v_code = bin2hex(random_bytes(16));
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `verification_code`, `is_verified`,
             `timestamp`) VALUES ('$user_email', '$hash', '$v_code','0', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            
            if($result && sendmail($_POST['signupEmail'],$v_code))
            {
                $showAlert = true;  
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Passwords do not match";
            header("Location: /forum/index.php?signupsuccess=false&error=$showError");
            
        }
    }
    header("Location: /forum/index.php?signupsuccess=true&error=$showError");
}
?>