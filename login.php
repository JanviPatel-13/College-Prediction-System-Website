<?php
	session_start();
	if(isset($_SESSION['username']))
		unset($_SESSION['username']);
	session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<title>ShikshaDwaar</title>
	<link rel="stylesheet" type="text/css" href="Login.css">
	<link rel = "icon" href = "Logo.jpg" type = "image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>ShikshaDwaar</title>
</head>
<body>
   <nav class="navbar sticky-top navbar-expand-sm navbar-dark bg-dark">
		<a class="navbar-brand" href="home.php">
		<img src="Logo.jpg" width="30" height="30" class="d-inline-block align-top" alt=""> ShikshaDwaar
  		</a>
<!-- Links -->
<ul class="navbar-nav ml-auto">
    		
    		<li class="nav-item">
      			<a class="nav-link" href="practice.php">About Us</a>
    		</li>
			<li class="nav-item active">
      			<a class="nav-link" href="home.php">Home</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link" href="login.php">Not <?php
      			if(isset($_SESSION['username']))
      				{
      					echo $_SESSION['username'];
      				}
      			?>? Logout</a>
    		</li>
  		</ul>
	</nav>

<div class="background">
<div class="form" id="login">
	<div class="box">
	<h3>LOGIN</h3>
	<div class="social-container">
	<a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
    <a href="https://www.google.com" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
    <a href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
	</div>
	<div>
		<?php
			function test_input($data)
			{
				$data=trim($data);
				$data=stripcslashes($data);
				$data=htmlspecialchars($data);
				return $data;
			}
			if(isset($_POST['login']))
			{
				session_start();
				$username=$password="";
				if($_SERVER["REQUEST_METHOD"] == "POST")
				{
					$username = test_input($_POST['Username']);
					$password = test_input($_POST['Password']);
					//echo $username,"<br>";
					//echo $password;

					$link = mysqli_connect("localhost", "root", "");
					if (mysqli_connect_errno()) {
    					printf("Connect failed: %s\n", mysqli_connect_error());
    					exit();
					}
					mysqli_select_db($link,"test_db");
					$results=mysqli_query($link,"select * from usertable where Username='$username' and Password='$password'") or die("failed to connect".mysqli_connect_error());
					$row=mysqli_fetch_array($results);
					if ($row['Username'] == $username && $row['Password'] == $password) {
						header("location: http://localhost/project/home.php");
						$_SESSION['username'] = $username;
						$_SESSION['mes'] = "true";
					} 
					else {
					echo "Login failed";
					}
					mysqli_close($link);
				}
			} 
		?>	
	</div>
	<form action="login.php" method="POST">
		<input class="input" type="text" name="Username" placeholder="Username" required><br>
		<input class="input" type="password" name="Password" placeholder="Password" required><br>
		<input class="button" type="submit" name="login" value="LOGIN"><br>
		<a id="oksignup">Sign Up here</a> | <a href="#">Forgot Password?</a>
	</form>
    </div>
</div>
<div class="form reg" id="signup">
	<div class="box">
	<h3>SIGN UP</h3>
	<div class="social-container">
		<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
		<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
		<a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
	</div>
	<?php
		if(isset($_POST['signup']))
		{
			$usernameSub=$password1=$password2="";
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$usernameSub = test_input($_POST['Username']);
				$password1 = test_input($_POST['Password']);
				$password2 = test_input($_POST['ConfirmPassword']);

				$link = mysqli_connect("localhost", "root", "");
				if (mysqli_connect_errno()) {
    				printf("Connect failed: %s\n", mysqli_connect_error());
    				exit();
				}
				if(empty($usernameSub))
					array_push($error, "Please fill username");
				if(empty($password1))
					array_push($error, "Please fill password");
				if(empty($password2))
					array_push($error, "Please fill confirm password");
				if($password1 != $password2)
					echo "Password's don't match";
				else if($password1 == $password2)
				{
					mysqli_select_db($link,"test_db");
					$results=mysqli_query($link,"insert into usertable(Username,Password) values('$usernameSub','$password1')") or die("failed to connect".mysqli_connect_error());
					header('localhost: http://localhost/project/login.php');
					echo "Data Stored" ;
				}
				mysqli_close($link);
			}
		}
	?>
	<form action="login.php" method="POST">
		<input class="input" type="text" name="Username" placeholder="Username" required><br>
		<input class="input" type="password" name="Password" placeholder="Password" required><br>
		<input class="input" type="password" name="ConfirmPassword" placeholder="Confirm Password" required><br>
		<input class="button" type="submit" name="signup" value="SIGN UP"><br>
		<a id="oklogin">Login Here</a>
	</form>
    </div>
</div>
</div>
 <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="Login.js"></script>
<script>
  // Smooth scrolling for all anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });
</script>
</body>
</html>
