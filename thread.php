<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendmail($user_email,$comment_by){
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;        
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'satodiyanishit2002@gmail.com';                     //SMTP username
        $mail->Password   = 'qqcmmiiyhunrgzdh';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('satodiyanishit2002@gmail.com', 'iDiscuss');
        $mail->addAddress($user_email);     //Add a recipient
         
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New comment in your view';
        $mail->Body    = "You got one comment from new user. Try this solution to fix your bug";
        
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }

}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>iDiscuss - Coding Forums</title>
  </head>
  <body>
    <?php include 'partials/_header.php'; ?> 
    <?php include 'partials/_dbconnect.php'; ?> 
    
    <?php
    // Display thread name and content on top
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        // $thread_user_id = $row['comment_by'];


            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){

        //Insert into comment to database
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`)
         VALUES ('$comment', '$id', '$sno', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        sendmail($posted_by,$row2['user_email']);
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }

    ?>



    <div class="container">
        <div class="my-5">
            <h1 class="display-4"> <?php echo $title; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum.
            Keep it friendly.
            Be courteous and respectful. Appreciate that others may have an opinion different from yours.
            Stay on topic. ...
            Share your knowledge. ...
            Refrain from demeaning, discriminatory, or harassing behaviour and speech.
            </p>
            <p>Posted by: <b><?php echo $posted_by; ?> </b></p>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
    <h1 class="py-2">Post your view</h1>

    <form action="' . $_SERVER["REQUEST_URI"] .'"  method="post">
        
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your view here</label>
            <textarea required class="form-control" id="comment" name="comment" rows="3"></textarea>
            <input type="hidden" name="sno" value="'. $_SESSION["sno"] .'">
        </div>
        <button type="submit" class="btn btn-success">Post comment</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Post Comment</h1>
        <p class="lead">You are not logged in. Please login to be able to post a comment</p>
        </div>';
    }

    ?>

    



    <div class="container">
        <h1 class="mt-4">Discussions</h1>
        
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $id = $row['comment_id'];    
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];

            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
                   

        echo '<div class="media my-4">
            <img src="img/userdefault.png" class="mr-3" alt="..." width="50px">
            <div class="media-body">
                <p class="font-weight-bold my-0">' . $row2['user_email'] .' at ' . $comment_time . '</p>
                ' . $content . '
            </div>
        </div>';
        
        }

        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                    <p class="display-4">No Comments Found</p>
                    <p class="lead">Be the first person to comment.</p>
                    </div>
                </div>';
        }

        ?>

    </div>

    <!-- category container starts here -->
    <div class="container my-3">
        
    </div>


    <?php include 'partials/_footer.php'; ?> 



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>