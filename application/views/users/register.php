<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration Page </title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/login_register.css')?>">
</head>
<body>
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/login"> Login </a>
    </div>
    <div class="contents">
        <form action="register/validate" method="post">
            <h1>Register</h1>
            <label for="email_address">Email address:</label>
            <input type="text" name="email_address">
            <label for="first_name">First name:</label>
            <input type="text" name="first_name">
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name">
            <label for="password">Password:</label>
            <input type="text" name="password">
            <label for="confirm_password">Confirm password:</label>
            <input type="text" name="confirm_password">
            <input type="submit" name="register" id="register-btn" value="Register">
            <a href="/login" id="status-msg"> Already have an account? Login </a>
        </form>
        <div id="errors">
            <?=$this->session->flashdata('input_errors'); ?>
        </div>  
    </div>
    
</body>
</html>