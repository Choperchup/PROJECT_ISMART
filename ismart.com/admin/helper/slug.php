<?php

/**
 * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url
 * @access  public
 * @param string 
 * @return string
 */

if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ể|ế|ệ|ễ)#',
            '#(|á|ạ|ả|ã|â|ầ)#'
        );
    }
}
