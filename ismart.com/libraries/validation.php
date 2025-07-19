<?php
function is_username($username)
{
    $partten = "/^[A-Za-z0-9_\.]{6,32}$/";
    if (!preg_match($partten, $username, $matchs)) {
        return FALSE;
    };
    return true;
}

function is_password($password)
{
    $partten = '/^[A-Za-z0-9_\.!@#$%^&*()]{6,32}$/';
    if (!preg_match($partten, $password, $matchs)) {
        return FALSE;
    };
    return true;
}

function is_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

function form_error($lable_field)
{
    global $error;
    if (!empty($error[$lable_field])) {
        return "<p class='error'>{$error[$lable_field]}</p>";
    }
}

function set_value($lable_field)
{
    global $$lable_field;
    if (!empty($$lable_field)) return $$lable_field;
}
