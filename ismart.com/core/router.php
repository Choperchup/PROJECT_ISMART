<?php
//Triệu gọi đến file xử lý thông qua request

$request_path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . get_controller() . 'Controller.php';

if (file_exists($request_path)) {
    require $request_path;
} else {
    echo "Không tìm thấy:$request_path ";
}

$action_name = get_action() . 'Action';

call_function(array('construct', $action_name));

if (!is_login() && get_action() != 'login' && get_action() != 'reg' && get_action() != 'active' && get_action() != 'reset' && get_action() != 'resetSuccess') {
    redirect("?mod=users&action=login");
}
