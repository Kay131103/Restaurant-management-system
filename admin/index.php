<?php 
	session_start();
	$pageTitle = 'Admin Login';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
		header('Location: dashboard.php');
	}
?>

<!-- PHP INCLUDES -->

<?php include 'connect.php'; ?>
<?php include 'Includes/functions/functions.php'; ?>
<?php include 'Includes/templates/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url('OIP.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh; /* Set the height to full viewport height */
            margin: 0; /* Remove default margin */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login {
            background-color: rgba(255, 255, 255, 0.8); /* Set a semi-transparent background for the login form */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .form-input {
            margin-bottom: 15px;
        }

        /* Add any additional styling for your login container or form elements */
    </style>
</head>
<body>

    <!-- LOGIN FORM -->

    <div class="login">
        <form class="login-container validate-form" name="login-form" action="index.php" method="POST" onsubmit="return validateLoginForm()">
            <span class="login100-form-title p-b-32">
                Admin Login
            </span>
            <?php
                //Check if user click on the submit button
                if(isset($_POST['admin_login']))
                {
                    $username = test_input($_POST['username']);
					$password = test_input($_POST['password']);
					$hashedPass = sha1($password);

					//Check if User Exist In database

					$stmt = $con->prepare("Select user_id, username, password from users where username = ? and password = ?");
					$stmt->execute(array($username,$hashedPass));
					$row = $stmt->fetch();
					$count = $stmt->rowCount();

					// Check if count > 0 which mean that the database contain a record about this username

					if($count > 0)
					{

						$_SESSION['username_restaurant_qRewacvAqzA'] = $username;
						$_SESSION['password_restaurant_qRewacvAqzA'] = $password;
						$_SESSION['userid_restaurant_qRewacvAqzA'] = $row['user_id'];
						header('Location: dashboard.php');
						die();
					}
					else
					{
						?>
							<div class="alert alert-danger">
								<button data-dismiss="alert" class="close close-sm" type="button">
									<span aria-hidden="true">×</span>
								</button>
								<div class="messages">
									<div>Username and/or password are incorrect!</div>
								</div>
							</div>
						<?php 
					}
                }
            ?>

            <!-- USERNAME INPUT -->

            <div class="form-input">
                <span class="txt1">Username</span>
                <input type="text" name="username" class="form-control username" oninput="document.getElementById('username_required').style.display = 'none'" id="user" autocomplete="off">
                <div class="invalid-feedback" id="username_required">Username is required!</div>
            </div>

            <!-- PASSWORD INPUT -->
            
            <div class="form-input">
                <span class="txt1">Password</span>
                <input type="password" name="password" class="form-control" oninput="document.getElementById('password_required').style.display = 'none'" id="password" autocomplete="new-password">
                <div class="invalid-feedback" id="password_required">Password is required!</div>
            </div>

            <!-- SIGNIN BUTTON -->
            
            <p>
                <button type="submit" name="admin_login">Sign In</button>
            </p>

            <!-- FORGOT PASSWORD PART -->

            <span class="forgotPW">Forgot your password ? <a href="#">Reset it here.</a></span>

        </form>
    </div>

</body>
</html>

<?php include 'Includes/templates/footer.php'; ?>
