<?php
session_start();

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/forum">iDiscuss</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
        <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
    </li>
    </ul>
    <div class="row mx-2">';
        
    // if loggedin successfull
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        $email = $_SESSION['useremail'];
        $username = strstr($email,'@',true);
        echo '<form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        <p class="text-light my-0 mx-3">Welcome '. $username . '</p>
        <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
        </form>';
        
    }
    else{
       echo '<form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    
        </form>
    <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginModal">Login</button>
    <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupModal">SignUp</button>';

    }
    

    echo '</div>
         </div>
         </nav>';


include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

// signup success
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Please verify at your Email.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times</span>
  </button>
</div>';
}

// signup failed


// login success
if (isset($_GET['loginsuccess'])&& $_GET['loginsuccess'] == "true" ) {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You are logged in successfully.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times</span>
  </button>
</div>';
}

// login failed
if (isset($_GET['loginsuccess'])&& $_GET['loginsuccess'] == "false" ) {
    echo "<div class='alert alert-danger alert-dismissible fade show my-0' role='alert'>
    <strong>Failed!</strong> $_GET[error]
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'></button>
    <span aria-hidden='true'>&times</span>
  </div>";
}


?>