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

function is_address($address)
{
    $partten = "/^[A-Za-z0-9\s,\.-]{5,100}$/";
    if (!preg_match($partten, $address, $matchs)) {
        return false;
    }
    return true;
}

function is_phone_number($phone)
{
    $partten = "/^0[0-9]{9,10}$/";
    if (!preg_match($partten, $phone, $matchs)) {
        return false;
    }
    return true;
}
