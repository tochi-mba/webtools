<?php require "head.php";
if(!isset($_SESSION)){
  header("location: index.php");
  die();
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Login Page</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

form{
    height: 520px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 50px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.social{
  margin-top: 30px;
  display: flex;
}
.social div{
  background: red;
  width: 150px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
}
.social div:hover{
  background-color: rgba(255,255,255,0.47);
}
.social .fb{
  margin-left: 25px;
}
.social i{
  margin-right: 4px;
}

  body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  }
  @keyframes animate {
    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }
    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}

.background {
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    margin: 0;
    padding: 0;
    background: #1e1f1f;
    overflow: hidden;
    z-index: -1;

}
.background li {
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 53s linear infinite;
}




.background li:nth-child(0) {
    left: 15%;
    width: 83px;
    height: 83px;
    bottom: -83px;
    animation-delay: 1s;
}
.background li:nth-child(1) {
    left: 48%;
    width: 144px;
    height: 144px;
    bottom: -144px;
    animation-delay: 5s;
}
.background li:nth-child(2) {
    left: 87%;
    width: 141px;
    height: 141px;
    bottom: -141px;
    animation-delay: 5s;
}
.background li:nth-child(3) {
    left: 41%;
    width: 47px;
    height: 47px;
    bottom: -47px;
    animation-delay: 11s;
}
.background li:nth-child(4) {
    left: 5%;
    width: 49px;
    height: 49px;
    bottom: -49px;
    animation-delay: 9s;
}
.background li:nth-child(5) {
    left: 79%;
    width: 47px;
    height: 47px;
    bottom: -47px;
    animation-delay: 25s;
}
.background li:nth-child(6) {
    left: 81%;
    width: 70px;
    height: 70px;
    bottom: -70px;
    animation-delay: 18s;
}
.background li:nth-child(7) {
    left: 18%;
    width: 156px;
    height: 156px;
    bottom: -156px;
    animation-delay: 16s;
}
.background li:nth-child(8) {
    left: 73%;
    width: 68px;
    height: 68px;
    bottom: -68px;
    animation-delay: 36s;
}
.background li:nth-child(9) {
    left: 18%;
    width: 153px;
    height: 153px;
    bottom: -153px;
    animation-delay: 42s;
}
.background li:nth-child(10) {
    left: 37%;
    width: 88px;
    height: 88px;
    bottom: -88px;
    animation-delay: 33s;
}
.background li:nth-child(11) {
    left: 56%;
    width: 69px;
    height: 69px;
    bottom: -69px;
    animation-delay: 51s;
}
.background li:nth-child(12) {
    left: 18%;
    width: 99px;
    height: 99px;
    bottom: -99px;
    animation-delay: 13s;
}
.background li:nth-child(13) {
    left: 57%;
    width: 124px;
    height: 124px;
    bottom: -124px;
    animation-delay: 37s;
}
.background li:nth-child(14) {
    left: 62%;
    width: 121px;
    height: 121px;
    bottom: -121px;
    animation-delay: 20s;
}
.background li:nth-child(15) {
    left: 18%;
    width: 105px;
    height: 105px;
    bottom: -105px;
    animation-delay: 15s;
}
.background li:nth-child(16) {
    left: 71%;
    width: 127px;
    height: 127px;
    bottom: -127px;
    animation-delay: 30s;
}
.background li:nth-child(17) {
    left: 36%;
    width: 73px;
    height: 73px;
    bottom: -73px;
    animation-delay: 31s;
}
.background li:nth-child(18) {
    left: 21%;
    width: 113px;
    height: 113px;
    bottom: -113px;
    animation-delay: 39s;
}
.background li:nth-child(19) {
    left: 52%;
    width: 85px;
    height: 85px;
    bottom: -85px;
    animation-delay: 65s;
}
.background li:nth-child(20) {
    left: 72%;
    width: 110px;
    height: 110px;
    bottom: -110px;
    animation-delay: 47s;
}
.background li:nth-child(21) {
    left: 72%;
    width: 50px;
    height: 50px;
    bottom: -50px;
    animation-delay: 43s;
}
.background li:nth-child(22) {
    left: 26%;
    width: 99px;
    height: 99px;
    bottom: -99px;
    animation-delay: 66s;
}
.background li:nth-child(23) {
    left: 23%;
    width: 147px;
    height: 147px;
    bottom: -147px;
    animation-delay: 1s;
}
.background li:nth-child(24) {
    left: 84%;
    width: 47px;
    height: 47px;
    bottom: -47px;
    animation-delay: 53s;
}
  .login-form {
    width: 300px;
    margin: 0 auto;
    padding: 25px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  .login-form h3 {
    margin-top: 0;
  }

  .form-control {
    margin-bottom: 15px;
    width: 100%;
  }

  .btn {
    background-color: #f4511e;
    color: #fff;
    width: 100%;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .login-form {
      width: 100%;
    }
  }
</style>
</head>
<body>

<?php
require "connect.php";
require "navbar.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Get the POSTed login details
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the login details match
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['uid']=$row['uid'];
            $_SESSION['username'] = $username;
            // Redirect to secured page
            ?>
            <script>
              window.location.replace("index.php");
            </script>
            <?php
        } else {
            echo "Incorrect login details";
        }
    } else {
        echo "Incorrect login details";
    }
}
?>
<form action="login.php" method="POST">
        <h3>Login Here</h3>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password">

        <button type="submit">Log In</button>
        <div class="social">
          <div class="go"><i class="fab fa-google"></i>  Google</div>
          <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div>
    </form>
  
  <ul class="background">
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
   <li></li>
</ul>

</body>
</html>
