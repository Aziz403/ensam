<?php
require('connection.inc.php');
require('functions.inc.php');
$msg='';
if(isset($_POST['submit'])){
	$username=get_safe_value($con,$_POST['username']);
	$password=get_safe_value($con,$_POST['password']);

   $stmt = $con->prepare("SELECT * FROM useraccounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password_hash'];
        
        if (password_verify($password, $hashedPassword)) {
            if ($row['status'] == '0') {
                $msg = "Account deactivated";
            } else {
                $_SESSION['ADMIN_LOGIN'] = 'yes';
                $_SESSION['ADMIN_ID'] = $row['id'];
                $_SESSION['ADMIN_USERNAME'] = $username;
                $_SESSION['ADMIN_ROLE'] = $row['role'];
                header('location: index.php');
                die();
            }
        } else {
            $msg = "Incorrect password";
        }
   } else {
      $msg = "Username not found";
   }
}
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>LOGIN PAGE</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
<style>
   body{
	   background-image:url('images/background.jpg');
	   background-repeat:no-repeat;
	   background-attachment:fixed;
	    background-size:100% 100%;
   }
   </style>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post">
                     <div class="form-group">
                        <label><b>USERNAME</b></label>
                        <input type="text" name="username" class="form-control" placeholder="        " required>
                     </div>
                     <div class="form-group">
                        <label><b>PASSWORD</b></label>
                        <input type="password" name="password" class="form-control" placeholder="          " required>
                     </div>
                     <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">SIGN IN</button>
					</form>
					<div class="field_error"><?php echo $msg?></div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>