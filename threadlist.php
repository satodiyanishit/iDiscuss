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
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <?php
     $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //Insert into thread to database
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, 
                `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    }

    ?>


    <div class="container">
        <div class="my-5">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum.
            Keep it friendly.
            Be courteous and respectful. Appreciate that others may have an opinion different from yours.
            Stay on topic. ...
            Share your knowledge. ...
            Refrain from demeaning, discriminatory, or harassing behaviour and speech.
            </p>
            <a class="btn btn-success btn-sm" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
    <h1 class="py-2">Start a Discussion</h1>

    <form action="'. $_SERVER["REQUEST_URI"] .'"  method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Problem Title</label>
            <input required type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as possible.</small>
        </div>
        <input type="hidden" name="sno" value="'. $_SESSION["sno"] .'">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
            <textarea required class="form-control" id="desc" name="desc" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container">
        <h1 class="py-2">Start a Discussion</h1>
        <p class="lead">You are not logged in. Please login to be able to start a Discussion</p>
        </div>';
    }

    ?>

    

    <div class="container">
        <h1 class="py-2 mt-5">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $id = $row['thread_id'];    
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
            

        echo '<div class="media my-4">
            <img src="img/userdefault.png" class="mr-3" alt="..." width="50px">
            <div class="media-body">
            
                <h5 class="mt-0"> <a class="text-dark" href="thread.php?threadid=' . $id . '">' . $title . ' </a></h5>
                ' . $desc . ' </div> <div class="font-weight-bold my-0">Asked by: ' . $row2["user_email"] . ' at ' . $thread_time . '
            </div>
        </div>';
        
        }

        // echo var_dump($noresult);
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                    <p class="display-4">No Threads Found</p>
                    <p class="lead">Be the first person to ask a question.</p>
                    </div>
                </div> ';
        }
        ?>
        
    </div>

    <?php include 'partials/_footer.php'; ?> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>