<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiết lập mật khẩu mới</title>
    <link rel="stylesheet" href="./public/css/reset.css">
    <link rel="stylesheet" href="./public/css/login.css">
</head>

<body>
    <div id="wp-form-login">
        <h1 class="page-title">MẬT KHẨU MỚI</h1>
        <form id="form-login" action="" method="POST">
            <input type="password" name="password" id="password" value="" placeholder="Password" autocomplete="false">
            <?php echo form_error('password'); ?>

            <input type="submit" id="btn-login" name="btn-new-pass" value="CẬP NHẬT">
            <?php echo form_error('account') ?>
        </form>
        <a href="<?php echo base_url("?mod=users&action=login") ?>" id="lost-pass">Đăng nhập</a> |
        <a href="<?php echo base_url("?mod=users&action=reg") ?>" id="lost-pass">Đăng ký</a>
    </div>

</body>

</html>