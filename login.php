<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Datamex College of Saint Adeline</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="icon" href="data_logo-removebg-preview.png">

	<link rel="stylesheet" href="/school-management-system/testing/ai_style.css?v=<?= time(); ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>


<style>
    body.body-login {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('bggg.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        position: relative;
        overflow: hidden;
    }

    body.body-login::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
        pointer-events: none;
        z-index: 0;
    }

    .login-container {
        background: rgba(8,10,12,0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 18px;
        padding: 42px 48px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6);
        transition: all 0.25s ease;
        position: relative;
        z-index: 1;
        color: #fff;
    }

    .login-container:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.65);
    }

    .login-container h3 {
        text-align: center;
        margin-bottom: 22px;
        font-weight: 600;
        color: #fff;
    }

    .login-container .form-label {
        color: rgba(255,255,255,0.88);
        font-weight: 500;
    }

    .login-container .form-control {
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 15px;
        border: 1px solid rgba(255,255,255,0.08);
        background: rgba(255,255,255,0.06);
        color: #fff;
        transition: 0.2s;
    }

    .login-container .form-control::placeholder {
        color: rgba(255,255,255,0.65);
    }

    .login-container .form-control:focus {
        border-color: rgba(0,123,255,0.8);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.18);
        background: rgba(255,255,255,0.04);
        color: #fff;
    }

    /* Updated select styles without arrow */
    .login-container select.form-control,
    .login-container .form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background: rgba(255,255,255,0.06);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.12);
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 15px;
        cursor: pointer;
        transition: 0.2s;
    }

    .login-container select.form-control:focus,
    .login-container .form-select:focus {
        outline: none;
        border-color: rgba(0,123,255,0.8);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.18);
        background: rgba(255,255,255,0.04);
    }

    .login-container select.form-control option,
    .login-container .form-select option {
        background: rgba(8,10,12,0.95);
        color: #fff;
        padding: 8px;
    }

    .login-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 20px;
    }

    .login-actions button,
    .login-actions a {
        flex: 1;
        text-align: center;
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
        transition: 0.25s;
    }

    .login-actions button {
        background-color: #0d6efd;
        border: none;
        color: #fff;
    }

    .login-actions button:hover {
        background-color: #0b5ed7;
    }

    .login-actions a {
        background-color: rgba(255,255,255,0.18);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.18);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .login-actions a:hover {
        background-color: rgba(255,255,255,0.28);
        color: #000;
    }

    .footer-text {
        position: absolute;
        bottom: 15px;
        width: 100%;
        text-align: center;
        font-size: 13px;
        color: rgba(255,255,255,0.85);
        z-index: 1;
    }
</style>

</head>

<?php
// ...existing code...
// include chatbot markup (file lives in testing/)
include_once __DIR__ . '/testing/index.php';
?>

<body class="body-login">
	<div class="login-container">
		<form class="login" method="post" action="req/login.php">
			<div class="text-center mb-3">
				<img src="data_logo-removebg-preview.png" width="90" alt="Datamex Logo">
			</div>
			<h3>LOGIN</h3>

			<?php if (isset($_GET['error'])) { ?>
				<div class="alert alert-danger" role="alert">
					<?= $_GET['error'] ?>
				</div>
			<?php } ?>

			<div class="mb-3">
				<label class="form-label">Username</label>
				<input type="text" class="form-control" name="uname" placeholder="Enter your username" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Password</label>
				<input type="password" class="form-control" name="pass" placeholder="Enter your password" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Login As</label>
				<select class="form-control" name="role" required>
					<option value="1">Admin</option>
					<option value="2">Teacher</option>
					<option value="3">Student</option>
					<option value="4">Registrar Office</option>
				</select>
			</div>

			<div class="login-actions">
				<button type="submit">Login</button>
				<a href="index.php">Home</a>
			</div>
		</form>
	</div>

	<div class="footer-text">
		Copyright &copy; 2025 Datamex College of Saint Adeline. All rights reserved.
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="/school-management-system/testing/ai_script.js?v=<?= time(); ?>"></script>
</body>
</html>
