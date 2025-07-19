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
        <h1 class="page-title">Đăng nhập</h1>
        <form id="form-login" action="" method="POST">
            <input type="text" name="username" id="username" value="<?php echo set_value('username') ?>" placeholder="Username">
            <?php echo form_error('username'); ?>

            <input type="password" name="password" id="password" value="<?php echo set_value('password') ?>" placeholder="Password" autocomplete="">
            <?php echo form_error('password'); ?>

            <input type="submit" id="btn-login" name="btn-login" value="ĐĂNG NHẬP">
            <?php echo form_error('account'); ?>
        </form>
        <a href="<?php echo base_url("?mod=users&action=lost_pass"); ?>" id="lost-pass">Quên mật khẩu?</a> |
        <a href="<?php echo base_url("?mod=users&action=reg"); ?>" id="lost-pass">Đăng ký</a>
    </div>

</body>

</html>