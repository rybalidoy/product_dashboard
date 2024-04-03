<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/profile.css')?>">
</head>
<body>
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/dashboard"> Dashboard</a>
        <a href="/profile"> Profile </a>
        <a href="/logout" class="left-a"> Log off </a>
    </div>
    <div class="contents">
        <h1> Edit Profile </h1>
        <form action="/users/edit_information" method="post" class="form">
            <p> Edit Information </p>
            <label for="email_address"> Email address: </label>
            <input type="text" name="email_address">
            <label for="first_name"> First name: </label>
            <input type="text" name="first_name">
            <label for="last_name"> Last name: </label>
            <input type="text" name="last_name">
            <input type="submit" name="save" value="Save" class="save-btn">
        </form>
        <form action="/users/change_password" method="post" class="form">
            <p> Change Password </p>
            <label for="old_password"> Old Password: </label>
            <input type="password" name="old_password">
            <label for="new_password"> New Password: </label>
            <input type="password" name="new_password">
            <label for="confirm_password"> Confirm Password: </label>
            <input type="password" name="confirm_password">
            <input type="submit" name="save" value="Save" class="save-btn">
        </form>
        <div id="errors">
            <?=$this->session->flashdata('input_errors'); ?>
        </div>  
    </div>
</body>
</html>