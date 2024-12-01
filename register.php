<?php 

include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    // Check if the email ends with the allowed domains
    if (strpos($email, '@stfrancis.edu.com') === false && strpos($email, '@stfrancis.ph.education') === false) {
        echo "<script>alert('You can only register with an email address that ends with @stfrancis.edu.com or @stfrancis.ph.education.'); window.location.href='index.php';</script>";
        exit(); // Stop further execution
    }

    $checkEmail="SELECT * From users where email='$email'";
    $result=$conn->query($checkEmail);
    if($result->num_rows>0){
        echo "<script>alert('Email Address Already Exists!'); window.location.href='index.php';</script>";
    }
    else{
        $insertQuery="INSERT INTO users(firstName,lastName,email,password)
                       VALUES ('$firstName','$lastName','$email','$password')";
        if($conn->query($insertQuery)==TRUE){
            header("location: index.php");
        }
        else{
            echo "Error:".$conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $password=md5($password) ;
   
   $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
   $result=$conn->query($sql);
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: homepage.php");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }

}
?>