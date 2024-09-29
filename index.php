<?php
require_once './config/dbcon.php';
require_once './config/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = $_POST['email'];
	$password = $_POST['password'];

	if (login($email, $password, false)) {
		// Assuming the login function stores the role in the session
		session_start();
		$role = $_SESSION['role'] ?? null; // Retrieve the role from the session

		if ($role === 'admin') {
			header('Location: ./admin/index.php');
		} elseif ($role === 'teacher') {
			header('Location: ./teacher/index.php');
		} elseif ($role === 'parent') {
			header('Location: ./parent/index.php');
		}
		exit;
	} else {
		$error = "Invalid email or password.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png">

	<link rel="canonical" href="pages-sign-in.html">

	<title>ISUPAY</title>

	<link href="css2.css?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<!-- Choose your prefered color scheme -->
	<!-- <link href="css/light.css" rel="stylesheet"> -->
	<!-- <link href="css/dark.css" rel="stylesheet"> -->

	<!-- BEGIN SETTINGS -->
	<!-- Remove this after purchasing -->
	<link class="js-stylesheet" href="css/light.css" rel="stylesheet">
	<style>
		body {
			opacity: 0;
		}
	</style>
	<!-- END SETTINGS -->
	<script async="" src="gtag/js.js?id=UA-120946860-10"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());

		gtag('config', 'UA-120946860-10', { 'anonymize_ip': true });
	</script>
</head>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->

<body>
	

	
	


	<main>
		<div class="row h-75 justify-content-center align-items-center" style="margin: 60px">
			<div class="col-md-8">
				<div class="card px-5 py-5" style="height: 350px">
					<div class="row ">
						<div class="col-12 col-md-7 col-lg-6 col-xl-5">
							<div class="d-table-cell align-middle">

								<div class="text-center mt-4">
									<h1
										style="font-weight:600; font-size: clamp(1.875rem, -0.4688rem + 7.5vw, 3.75rem);">
										ISUPAY</h1>
									<p class="lead">
										Login your credentials.
									</p>
								</div>
							</div>

						</div>
						<div class="col-12 col-md-8 col-lg-7 col-xl-7 border border-2 p-4" style="">
							<?php if (isset($error)): ?>
								<p><?php echo $error; ?></p>
							<?php endif; ?>
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<div class="mb-3">
									<label class="form-label">Username</label>
									<input class="form-control form-control-lg" type="email" name="email"
										placeholder="Enter your email">
								</div>
								<div class="mb-3">
									<label class="form-label">Password</label>
									<input class="form-control form-control-lg" type="password" name="password"
										placeholder="Enter your password">

								</div>

								<div class="text-center mt-3">
									<!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
									<input type="submit" value="Login">
								</div>
							</form>
						</div>

					</div>
				</div>


			</div>


		</div>

	</main>

	<script src="js/app.js"></script>

</body>

</html>