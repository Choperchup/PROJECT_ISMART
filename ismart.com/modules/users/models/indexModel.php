<?php
function check_login1($username, $password)
{
    $check_user = db_num_rows("SELECT * FROM `tbl_users` WHERE `username`= '{$username}' AND `password` = '{$password}'");
    if ($check_user > 0) {
        return true;
    }
    return false;
}

function info_user1($lable = 'id')
{
    $user_login = $_SESSION['username'];
    $user = db_fetch_array("SELECT * FROM `tbl_users` WHERE `username` = '{$user_login}' ");
    return $user[$lable];
}


function check_email($email)
{
    $check_email = db_num_rows("SELECT * FROM `tbl_users` WHERE `email`= '{$email}' ");
    if ($check_email > 0) {
        return true;
    }
    return false;
}

function update_reset_token($data, $email)
{
    db_update('tbl_users', $data, "`email` = '{$email}'");
}

function add_user($data)
{
    return db_insert('tbl_users', $data);
}

function check_reset_token($reset_token)
{
    $check = db_num_rows("SELECT * FROM `tbl_users` WHERE `reset_token` = '{$reset_token}' ");
    if ($check > 0) {
        return true;
    }
    return false;
}
function update_pass($data, $reset_token)
{
    db_update('tbl_users', $data, "`reset_token` = '{$reset_token}'");
}

function user_exists($username, $email)
{
    $check_user = db_num_rows("SELECT * FROM `tbl_users` WHERE `email` = '{$email}' OR `username` = '{$username}'");
    echo $check_user;
    if ($check_user > 0) {
        return true;
    }
    return false;
}


function get_list_users()
{
    $result = db_fetch_array("SELECT * FROM `tbl_users`");
    return $result;
}

function get_user_by_id($id)
{
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `user_id` = {$id}");
    return $item;
}

function active_user($active_token)
{
    return db_update('tbl_users', array('is_active' => 1), "`active_token`= {$active_token}");
}

function check_active_token($active_token)
{
    $check_token = db_num_rows("SELECT * FROM `tbl_users` WHERE `active_token` = '{$active_token}' AND `is_active` = '0' ");
    if ($check_token > 0) {
        return true;
    }
    return false;
}


