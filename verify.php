<?php

include 'partials/_dbconnect.php';

if(isset($_GET['email']) && isset($_GET['v_code']))
{
    $query = "SELECT * from `users` WHERE `user_email` = '$_GET[email]' AND `verification_code` = '$_GET[v_code]'";
    $result=mysqli_query($conn, $query);
    if($result)
    {
        $result_fetch = mysqli_fetch_assoc($result);
        if($result_fetch['is_verified']==0)
        {
            $update = "UPDATE `users` SET `is_verified`='1' WHERE `user_email`='$_GET[email]'";
            if(mysqli_query($conn, $update))
            {
                echo "
                <script>
                alert('Email verification successfull');
                window.location.href='index.php';
                </script>";
            }
            else{
                echo "
                <script>
                alert('Cannot run query');
                window.location.href='index.php';
                </script>";
            }
            
        }
    }
}
?>