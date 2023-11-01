<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- add icon link -->
  <link rel = "icon" href = 
  "https://img.freepik.com/free-vector/music-design-yellow-illustration_24877-49373.jpg?auto=format&h=200" 
          type = "image/x-icon">
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        font-family: Arial, sans-serif;
      }
      
      li {
        float: right;
      }
      
      li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
      }
      
      li a:hover {
        background-color: #111;
      }
      h1 {
        font-size: 3em;
        text-align: center;
        margin: 1em 0;
        color: white;
      }
      
      p {
        font-size: 1.5em;
        line-height: 1.5;
        margin: 0.5em 0;
        color: white;
      }
      .message{
        color: red;
        text-align: center;
      }
    </style>
    <?php
      include 'config.php';
      
      if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $cpassword = md5($_POST['passwordConfirm']);
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' .$image;

        $check_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE username='$username' AND password='$password'") or die('query failed');
        $check_email = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email'") or die('query failed');
        if(mysqli_num_rows($check_user)>0){          
          $message[] = 'USER ALREADY EXIST';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $message[] = 'INVALID EMAIL FORMAT';
        }elseif(mysqli_num_rows($check_email)){
          $message[] = 'EMAIL ALREADY USED';
        }elseif($password != $cpassword){
          $message[] = 'CONFIRM PASSWORD NOT MATCHED!';          
        }elseif($image_size > 2000000){
          $message[] = 'IMAGE IS TOO LARGE';          
        }else{
          $insert = mysqli_query($conn, "INSERT INTO `user_form`(username, email, password, image) VALUES('$username', '$email', '$password', '$image')") or die('query failed');
          if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'REGISTERED SUCCESSFULLY!';              
          }else{
              $message[] = 'REGISTRATION FAILED!';
          }
        }        
      }
    ?>
  </head>

  <body>    
    <div class="login-box">  
      <form class="d-flex" action="" method="post" enctype="multipart/form-data">
        <div class="left">
            <img src="https://thevisiblegirl01home.files.wordpress.com/2018/12/c76f92554791df779c35dbb5e4a53c45.jpg" alt="">
        </div>
        <div class="right">
          <h2>Register</h2>
          <div class="row">
            <div class="col">
              <div class="user-box">
                <input type="text" name="username" placeholder="Username" required=""/>
              <div class="user-box">
            </div>
            <div class="col">
              <div class="user-box">
                <input type="text" name="email" placeholder="Email" required=""/>
              </div> 
            </div>
            <div class="col">
              <div class="user-box">
                <input type="password" name="password" id="password" placeholder="Password" required=""/>
              </div>
            </div>
            <div class="col">
              <div class="user-box">
                <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Password confirm" required=""/>
              </div>
            </div>
            <div class="col">
              <div class="user-box">
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">   
              </div>
            </div>
            <div class="col">
                <?php
                  if(isset($message)){
                    foreach($message as $message){
                      echo '<div class="message">'.$message.'<div>';
                    }
                  }
                ?>
            </div>
            <div class="col">
              <div class="button-form">
                <input type="submit" name="submit" value="Register" id="submit">          
                  <div id="register">
                  Already have an account?
                  <a id="btn-login" href="login.php">Login here</a>                  
                  </div>
              </div>
            </div>            
          </div>
        </div>
      </form>
    </div>
    <script src="../models/User.js"></script>
    <script src="../scripts/register.js"></script>
  </body>
</html>
          
                 
          
          