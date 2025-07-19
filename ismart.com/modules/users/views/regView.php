<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đăng nhập</title>
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/login.css">
</head>

<body>
    <div id="wp-form-login">
        <h1 class="page-title">ĐĂNG KÝ TÀI KHOẢN</h1>
        <form id="form-login" action="" method="POST">
            <input type="text" name="fullname" id="fullname" value="<?php echo set_value('fullname') ?>" placeholder="Fullname">
            <?php echo form_error('fullname'); ?>

            <input type="text" name="email" id="email" value="<?php echo set_value('email') ?>" placeholder="Email">
            <?php echo form_error('email'); ?>

            <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>" placeholder="Username">
            <?php echo form_error('username'); ?>

            <input type="password" name="password" id="password" value="" placeholder="Password" autocomplete="false">
            <?php echo form_error('password'); ?>

            <input type="submit" id="btn-login" name="btn-reg" value="ĐĂNG KÝ">
            <?php echo form_error('account') ?>
        </form>
        <a href="<?php echo base_url("?mod=users&action=login") ?>" id="lost-pass">Đăng nhập</a>
    </div>

</body>

</html>