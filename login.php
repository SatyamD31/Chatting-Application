<?php

	include('database_connection.php');
	session_start();

	$message1 = '';
	$message2 = '';
	$message3 = '';
	$message4 = '';
	$message5 = '';
    $message6 = '';
    $message7 = '';

	if(isset($_SESSION['user_id'])) {
        header('location:index.php');
	}
	
	if(isset($_POST["register"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $check_query = "SELECT * FROM login WHERE username = :username";
        $statement = $connect -> prepare($check_query);
        $check_data = array(
            ':username' => $username
		);
		if($statement -> execute($check_data)) {
            if($statement -> rowCount() > 0) {
                $message1 .= '<label>Username already taken.</label>';
            }
            else {
                if(empty($username)) {
                    $message1 .= '<label>Username is required.</label>';
                }
                if(empty($password)) {
                    $message2 .= '<label>Password is required.</label>';
                }
                else {
                    if($password != $_POST['confirm_password']) {
                        $message3 .= '<label>Passwords don\'t match.</label>';
                    }
                }
                if($message1 == '' && $message2 == '' && $message3 == '') {
                    $data = array(
                        ':username' => $username,
                        ':password' => password_hash($password, PASSWORD_DEFAULT)
                    );

                    $query = "INSERT INTO login (username, password) VALUES (:username, :password)";
                    $statement = $connect -> prepare($query);
                    if($statement -> execute($data)) {
                        $message4 = "<label>Registration Successful.<br><center>You can now login.</center></label>";
                    }
                }
            }
        }
	}
	
	else if(isset($_POST["login"])) {
        $query = "SELECT * FROM login WHERE username = :username";
        $statement = $connect -> prepare($query);         // this statement will make query for execution
        $statement -> execute(
            array(
                ':username' => $_POST["username"]
            )
        );
		$count = $statement -> rowCount();
        if($count > 0) {
            $result = $statement -> fetchAll();
            foreach($result as $row) {
                if(password_verify($_POST["password"], $row["password"])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $sub_query = "INSERT INTO login_details (user_id) VALUES('".$row['user_id']."')";
                    $statement = $connect -> prepare($sub_query);
                    $statement -> execute();
                    $_SESSION['login_details_id'] = $connect -> lastInsertId();
                    header("location:index.php");
                }
                else {
                    $message6 = "<label>Wrong Password</label>";
                }
            }
        }
        else if($count == 0){
            $message7 = "<label>Username doesn't exist.</label>";
        }
        else {
            $message5 = "<label>Wrong Username</label>";
        }
	}
	
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <!-- <link rel="stylesheet" type="text/css" href="form.css"> -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" defer></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="script.js" defer></script>

    <style>
        /* login/register page ============================================================================================= */

        @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400");

        @import url("https://fonts.googleapis.com/css?family=Playfair+Display");

        body, .message, .form, form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        body {
            height: 100vh;
            background: #E8E8E8;
            font-family: "Source Sans Pro", sans-serif;
            overflow: hidden;
            background-image: linear-gradient(to bottom, #5c0071ff, #00f0ff);;
        }

        .container {
            width: 700px;
            height: 400px;
            /* background: white; */
            /* background: #f1f1f1; */
            background: #202324;
            position: relative;
            display: grid;
            grid-template: 100% / 50% 50%;
            /* box-shadow: 2px 2px 10px 0 rgba(51, 51, 51, 0.2); */
            box-shadow: /*bottom shadow*/
            0px 20px 20px rgba(0, 0, 0, 0.05),
            0px 5px 10px rgba(0, 0, 0, 0.2),
            /*long bottom shadow*/
            0px 70px 50px rgba(0, 0, 0, 0.3),
            /*right shadow*/
            30px 50px 50px rgba(0, 0, 0, 0.2),
            /*left shadow*/
            -30px 50px 50px rgba(0, 0, 0, 0.2),
            /*right inset*/
            inset 20px 0px 60px rgba(0, 0, 0, 0.1),
            /*left inset*/
            inset -20px 0px 60px rgba(0, 0, 0, 0.1);
        }

        .message {
            position: absolute;
            /* background: white; */
            background: #181a1b;
            width: 50%;
            height: 100%;
            transition: 0.5s all ease;
            transform: translateX(100%);
            z-index: 4;
        }

        .message:before {
            position: absolute;
            content: '';
            /* width: 1px; */
            width: 0;
            height: 70%;
            background: #C3C3D8;
            /* background: #202324; */
            opacity: 0;
            left: 0;
            top: 15%;
        }

        .message .button {
            margin: 5px 0;
        }

        .signup:before {
            opacity: 0.3;
            left: 0;
            background: #202324;
        }

        .login:before {
            opacity: 0.3;
            left: 100%;
            background: #202324;
        }

        .btn-wrapper {
            width: 60%;
        }

        .form {
            width: 100%;
            height: 100%;
        }

        .form--heading {
            font-size: 25px;
            height: 50px;
            /* color: #809BCE; */
            color: #f1f1f1;
            font-family: 'Playfair Display', serif;
        }

        form {
            width: 70%;
        }

        form > * {
            margin: 10px;
        }

        form input {
            width: 90%;
            border: 0;
            /* border-bottom: 1px solid rgba(195, 195, 216, 0.5); */
            border-left: 1px solid red;
            border-bottom: 1.5px solid red;
            font-size: 15px;
            font-weight: 300;
            /* color: #797A9E; */
            color: white;
            background: black;
            /* letter-spacing: 0.05em; */
        }

        form input::placeholder {
            color: #C3C3D8;
            /* color: rgba(0, 0, 0, 0.5); */
            font-size: 14px;
        }

        form input:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        .button {
            width: 90%;
            height: 30px;
            border: 0;
            outline: 0;
            color: white;
            font-size: 15px;
            font-weight: 300;
            position: relative;
            z-index: 3;
            letter-spacing: 1px;
            /* background: linear-gradient(45deg, #809BCE, #9893DA); */
            background: linear-gradient(120deg, #3498db, #8e44ad);
            font-family: 'Playfair Display', serif;
            cursor: pointer;
        }

        @media (max-width: 750px) {
            .container {
                transform: scale(0.8);
            }
        }
    </style>
</head>
	<body>
		<div class="container">
			<div class="message signup">
				<div class="btn-wrapper">
					<button class="button" id="signup">Register</button>
                    <div style="height:5px"></div>
					<button class="button" id="login">Login</button>
				</div>
			</div>
			<div class="form form--signup">
				<div class="form--heading">Welcome! Register</div>
				<form autocomplete="on" method="POST">
					<input type="text" name="username" placeholder="Username">
					<span class="text-danger" style='margin:0;'><?php echo $message1; ?></span>
					<input type="password" name="password" placeholder="Password">
					<span class="text-danger" style='margin:0;'><?php echo $message2; ?></span>
					<input type="password" name="confirm_password" placeholder="Confirm Password">
					<span class="text-danger" style='margin:0;'><?php echo $message3; ?></span>
					<button class="button" name="register" formmethod="POST">Register</button>
					<span class="text-danger" style='margin:0;'><?php echo $message4; ?></span>
				</form>
			</div>
			<div class="form form--login">
				<div class="form--heading">Welcome back!</div>
				<form autocomplete="on" id="form" method="POST">
				<!-- <iframe name="frame" style="display:none;"></iframe> -->
					<input type="text" name="username" id="name" placeholder="Username" required>
					<span class="text-danger" style='margin:0;'><?php echo $message5; ?></span>
                    <span class="text-danger" style='margin:0;'><?php echo $message7; ?></span>
					<input type="password" name="password" id="pass" placeholder="Password" required>
					<span class="text-danger" style='margin:0;'><?php echo $message6; ?></span>
					<button class="button" type="submit" name="login" id="submit">Login</button>
                    <!-- <input type="submit" id="submit" class="button" value="Login"> -->
				</form>
			</div>
		</div>
	</body>
</html>