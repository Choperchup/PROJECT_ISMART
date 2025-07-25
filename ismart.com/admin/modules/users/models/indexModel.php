<?php

function get_user_by_username($username)
{
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `username` = '{$username}'");
    if (!empty($item)) {
        return $item;
    }
}

function update_user_login($username, $data)
{
    db_update('tbl_users', $data, "`username` = '{$username}'");
}

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


// ==================== MODEL: tbl_pages ====================

// Lấy tất cả trang
function get_list_pages()
{
    return db_fetch_array("SELECT * FROM `tbl_pages`");
}

// Lấy thông tin trang theo ID
function get_page_by_id($id)
{
    return db_fetch_row("SELECT * FROM `tbl_pages` WHERE `id_page` = {$id}");
}

// Thêm trang mới
function add_page($data)
{
    return db_insert('tbl_pages', $data);
}

// Cập nhật trang
function update_page($id, $data)
{
    return db_update('tbl_pages', $data, "`id` = {$id}");
}

// Xóa trang và ảnh nếu có
function delete_page($id)
{
    $page = get_page_by_id($id);
    if (!empty($page['thumbnail'])) {
        @unlink("public/uploads/{$page['thumbnail']}");
    }
    return db_delete('tbl_pages', "`id_page` = {$id}");
}

// ==================== MODEL: tbl_categories ====================

// Lấy tất cả danh mục
function get_list_categories()
{
    return db_fetch_array("SELECT * FROM `tbl_categories`");
}

// Lấy danh mục theo ID
function get_category_by_id($id)
{
    return db_fetch_row("SELECT * FROM `tbl_categories` WHERE `id` = {$id}");
}

// Thêm danh mục mới
function add_category($data)
{
    return db_insert('tbl_categories', $data);
}

// Cập nhật danh mục
function update_category($id, $data)
{
    return db_update('tbl_categories', $data, "`id` = {$id}");
}

// Xóa danh mục
function delete_category($id)
{
    return db_delete('tbl_categories', "`id` = {$id}");
}


function get_list_page()
{
    return db_fetch_array("SELECT * FROM `tbl_pages`");
}
