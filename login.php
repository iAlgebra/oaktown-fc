<?php
if (isset($_POST["Login"])) {
    checkLogin($_POST["Name"],$_POST["Password"]);
}

function checkLogin($Username, $Password) {
    $servername = "localhost";
    $DB_username = "root";
    $DB_password = "";

    try {
        $conn = new PDO("mysql:host=" . $servername . ";dbname=oaktown_fc", $DB_username, $DB_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $conn->query("SELECT * FROM user WHERE Username='" . $Username . "' AND Password='" . $Password . "'");
        $result = $statement->fetch();

        if ($result == null) { //customer id and password doesn't match
            echo '<script type="text/javascript">alert("The ID or password entered is not valid. Please enter a valid username and password");</script>';
        } else {
            session_start(); //start the session
            $_SESSION['Name']=$Username;
            header("location: admin.php"); //redirect user to admin.php
        }
    }
    catch (PDOException $e){
        echo "An error occurred " . $e->getMessage();
    }

    $conn = null;
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="utf-8">
		<title>Login | Oaktown Football Club</title>
	</head>
	<body>
		<div id="wrapper">
			<header>
				<a href="index.html"><img src="images/logo.png" alt="logo of oaktown football club"/></a>
				<h2>Oaktown Football Club</h2>
			</header>
			<nav>
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="competitions.php">Competitions</a></li>
					<li><a href="contact.html">Contact</a></li>
					<li><a href="login.php">Login</a></li>
				</ul>
			</nav>
			<div id="content">
                <h1>Login</h1>
                <p>Login to access your account</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="login_form">
                    <div class="form_field">
                        <label>Username:</label>
                        <input type="text" name="Name">
                    </div>
                    <div class="form_field">
                        <label>Password:</label>
                        <input type="password" name="Password">
                    </div>
                    <input type="submit" name="Login" value="Login" id="submit">
                </form>
			</div>
		</div>
	</body>
</html>
