<?php
// require MODULESPATH . DIRECTORY_SEPARATOR . 'global.php';
//Triệu gọi đến file xử lý thông qua request

$request_path = MODULESPATH . DIRECTORY_SEPARATOR . get_module() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . get_controller() . 'Controller.php';

if (file_exists($request_path)) {
    require $request_path;
    // echo "Đã load controller: $request_path<br>";
} else {
    echo "Không tìm thấy:$request_path ";
}

$action_name = get_action() . 'Action';

call_function(array('construct', $action_name));

if (!is_login() && get_action() != 'login') {
    redirect("?mod=users&action=login");
}
