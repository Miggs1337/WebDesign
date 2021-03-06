<?php
	//Import config file
	include("config.php");
	session_start();
 
   /*Verify the user isn't already logged in, and if so, direct user to the source code page
	if(isset($_SESSION["loggedin"] && $_SESSION["loggedin"] == true)) {
		header("location: welcome.html");
		exit;
	}*/
   
   //Initialize variables with empty values.
   $username = $password = $username_error = $password_error = "";
   
   //Validate the username and password fields are not empty
   if($_SERVER["REQUEST_METHOD"] == "POST") {
			//Check for empty username
			if(empty(trim($_POST["username"]))) {
				$username_error = "Please enter a username.";
			}
			else {
				$username = trim($_POST["username"]);
			}
			
			//Check for empty password
			if(empty(trim($_POST["password"]))) {
				$password_error = "Please enter a password.";
			}
			else {
				$password = trim($_POST["password"]);
			}


			//Validate username and password
			if(empty($username_error) && empty($password_error)) {
				
				//Prepare the SELECT statement 
				$sql = "SELECT id, username, password FROM users WHERE username = ?";
				
				if($stmt = mysqli_prepare($link,$sql)) {
					mysqli_stmt_bind_param($stmt, 's', $param_username);
					
					//Assign paramters for log in
					$param_username = $username;
					
					//Execute SELECT statement
					if(mysqli_stmt_execute($stmt)) {
						//Store the results
						mysqli_stmt_store_result($stmt);
						//Verify if the username exists
						if(mysqli_stmt_num_rows($stmt) == 1) {
							//Bind results
							mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
							
							if(mysqli_stmt_fetch($stmt)) {
								//Verify password
								if(password_verify($password, $hashed_password)) {
									//Start session once password is validated
									echo "Password verified test<br>";
									session_start();
									
									//Update session variables
									$_SESSION["loggedin"] = true;
									$_SESSION["id"] = $id;
									$_SESSION["username"] = $username;

									//Redirect user to source code page
									header("location: welcome.php");
								}
								
								else {
									//Display password error message if unable to validate password
									$password_error = "The password is not valid";
								}
							}
						}
						
						else {
							//Display username error if unable to validate username
							$username_error = "Username does not exist";
						}
					}
					
					else {
						echo "Something went wrong! Please try again later";
					}
					
				}
			}
		mysqli_close($link);
	}
?>
<html>
<head>
      
    <meta charset="utf-8"/>
	<title> Page Title </title>
	<!--We can create a new stylesheet that will hold all the different
		styling that we want to use for specific sections of the website-->
	<link rel="stylesheet" href="styles.css">
</head>
   
<body>
	<div class="nav-wrapper"><!--Create nav wrapper class to enclose
									all the nav bar information and links-->
			<!--Create class for left side of nav bar-->						
			<div class="nav-left-side">
				<div class = "nav-link-wrapper">
					<a href="index.html">Home</a>
				</div>
				<div class = "nav-link-wrapper">
					<a href="about.html">About</a>
				</div>
				<div class = "nav-link-wrapper">
					<a href = "Photos.html">Photography</a>
				</div>
				<div class = "nav-link-wrapper">
					<a href = "login.php">Log In</a>
				</div>
			</div>
			<!--Create class for right side of nav bar-->
			<div class = "nav-right-side">
				<div class = "nav-name-title">
					<div>Miguel Hernandez</div>
				</div>
			</div>
		</div>
		
      <div align = "center">
         <div style = "width:300px; border: solid 1px #A9A9A9; " align = "left">
            <div style = "background-color:#A9A9A9; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <label>Username  :</label><input type = "text" name = "username" class="login-text-box" value="<?php echo $username;?>">
                  <label>Password  :</label><input type = "password" name = "password" class = "login-text-box">
                  <input type = "submit" value = "  Login  "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
            </div>
				
         </div>
			
      </div>

   </body>
</html>