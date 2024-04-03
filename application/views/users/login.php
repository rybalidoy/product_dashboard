<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login Page </title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/login_register.css')?>">
</head>
<body>
    
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/register"> Register </a>
    </div>
    <div class="contents">
        <form action="login/validate" method="post">
            <h1>Login</h1>
            <label for="email_address">Email Address:</label>
            <input type="text" name="email_address">
            <label for="password">Password:</label>
            <input type="text" name="password">
            <input type="submit" name="login" id="login-btn" value="Login">
            <a href="/register" id="status-msg"> Don't have an account? Register </a>
        </form>
        <div id="errors">
            <?=$this->session->flashdata('input_errors'); ?>
        </div>  
    </div>
    
    
</body>
</html>