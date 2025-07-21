<?php

function construct()
{
    load_model('index');
    load('lib', 'validation');
    load('lib', 'email');
    // get_header('header');
}

function indexAction()
{
    // get_header();
    load_view('list_post');
}


function regAction()
{
    global $error, $username, $password, $email, $fullname;
    if (isset($_POST['btn-reg'])) {
        $error = array();

        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Không được để trống họ tên";
        } else {
            $fullname = $_POST['fullname'];
        }

        #Kiểm tra username
        if (empty($_POST['username'])) {
            $error['username'] = "Không được để trống tên đăng nhập";
        } else {
            if (!is_username($_POST['username'])) {
                $error['username'] = "Tên đăng nhập không đúng định dạng";
            } else {
                $username = $_POST['username'];
            }
        }
        #Kiểm tra password
        if (empty($_POST['password'])) {
            $error['password'] = "Không được để trống mật khẩu";
        } else {
            if (!is_password($_POST['password'])) {
                $error['password'] = "Mật khẩu không đúng định dạng";
            } else {
                $password = $_POST['password'];
            }
        }

        #Kiểm tra email
        if (empty($_POST['email'])) {
            $error['email'] = "Không được để trống email";
        } else {
            if (!is_email($_POST['email'])) {
                $error['email'] = "Email không đúng định dạng";
            } else {
                $email = $_POST['email'];
            }
        }

        #Kết luận
        if (empty($error)) {
            if (!user_exists($username, $email)) {
                $active_token = $username . time();
                $data = array(
                    'fullname' => $fullname,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'active_token' => $active_token,
                    'reg_date' => time()
                );
                add_user($data);
                $link_active = base_url("?mod=users&action=active&active_token={$active_token}");
                $content = "<p>Chào bạn {$fullname}</p>
                            <p>Bạn vui lòng click vào đường link này để kích hoạt tài khoản: {$link_active}</p>
                            <p>Nếu bạn không đăng ký tài khoản này hãy bỏ qua</p>";
                send_email('berper2003@gmail.com', "Lương Nguyễn Nam Trường", 'Kích hoạt tài khoản PHP', $content);

                //Chuyển hướng vào trong hệ thống
                redirect("?mod=users&action=login");
            } else {
                $error['account'] = "Email hoặc username đã tồn tại trên hệ thống";
            }
        }
    }
    load_view('reg');
}

function loginAction()
{
    global $error, $username, $password;
    if (isset($_POST['btn-login'])) {
        $error = array();

        #Kiểm tra username
        if (empty($_POST['username'])) {
            $error['username'] = "Không được để trống tên đăng nhập";
        } else {
            if (!is_username($_POST['username'])) {
                $error['username'] = "Tên đăng nhập không đúng định dạng";
            } else {
                $username = $_POST['username'];
            }
        }
        #Kiểm tra password
        if (empty($_POST['password'])) {
            $error['password'] = "Không được để trống mật khẩu";
        } else {
            if (!is_password($_POST['password'])) {
                $error['password'] = "Mật khẩu không đúng định dạng";
            } else {
                $password = $_POST['password'];
            }
        }

        #Kết luận
        if (empty($error)) {
            if (check_login1($username, $password)) {
                //Lưu trữ phiên đăng nhập
                $_SESSION['is_login'] = true;
                $_SESSION['user_login'] = $username;
                //Chuyển hướngvào trong hệ thống
                redirect();
            } else {
                $error['account'] = "Tên đăng nhập hoặc mật khẩu không tồn tại";
            }
        }
    }

    load_view('login');
}

function activeAction()
{
    $link_login = base_url("?mod=users&action=login");
    $active_token = $_GET['active_token'];
    if (check_active_token($active_token)) {
        active_user($active_token);
        echo "Yêu cầu kích hoạt thành công, Vui lòng click vào Link sau để đăng nhập: <a href='{$link_login}'>Đăng nhập</a>";
    } else {
        echo "Yêu cầu kích hoạt không hợp lệ hoặc tài khoản đã kích hoạt trước đó!, Vui lòng click vào Link sau để đăng nhập: <a href='{$link_login}'>Đăng nhập</a>";
    }
}

function logoutAction()
{
    unset($_SESSION['is_login']);
    unset($_SESSION['user_login']);
    redirect("?mod=users&action=login");
}

function resetAction()
{
    load_view('reset');
}

function resetSuccess()
{

    load_view('resetSuccess');
}

function updateAction()
{
    /**
     * Cập nhật tài khoản:
     * B1: Tạo giao diện
     * B2: Load lại thông tin cũ
     * B3: Validation form
     * B4: Cập nhật thông tin
     */
    // global $error, $phone_number, $email, $fullname, $address;


    if (isset($_POST['btn-update'])) {
        show_array($_POST);
        $error = array();

        # Kiểm tra fullname
        if (empty($_POST['fullname'])) {
            $error['fullname'] = "Không được để trống họ tên";
        } else {
            $fullname = $_POST['fullname'];
        }

        #Kiểm tra email
        if (empty($_POST['email'])) {
            $error['email'] = "Không được để trống email";
        } else {
            if (!is_email($_POST['email'])) {
                $error['email'] = "Email không đúng định dạng";
            } else {
                $email = $_POST['email'];
            }
        }

        # Kiểm tra address
        if (empty($_POST['address'])) {
            $error['address'] = "Không được để trống địa chỉ";
        } else {
            if (!is_address($_POST['address'])) {
                $error['address'] = "Địa chỉ không hợp lệ";
            } else {
                $address = $_POST['address'];
            }
        }

        # Kiểm tra phone_number
        if (empty($_POST['phone_number'])) {
            $error['phone_number'] = "Không được để trống số điện thoại";
        } else {
            if (!is_phone_number($_POST['phone_number'])) {
                $error['phone_number'] = "Số điện thoại không hợp lệ";
            } else {
                $phone_number = $_POST['phone_number'];
            }
        }



        if (empty($error)) {
            // update
            $data = array(
                'fullname' => $fullname,
                'email' => $email,
                'address' => $address,
                'phone_number' => $phone_number
            );
            update_user_login(user_login(), $data);
        }
    }

    $info_user = get_user_by_username(user_login());
    $data['info_user'] = $info_user;
    load_view('update', $data);
}

// Hàm load trang

function menuAction()
{
    load_view('menu');
}

function homeAction()
{
    load_view('home');
}

function productAction()
{
    load_view('product');
}

function add_productAction()
{
    load_view('add_product');
}

function postAction()
{
    load_view('post');
}

function add_pageAction()
{
    load_view('add_page'); // file: modules/users/views/add_pageView.php
}

function list_pageAction()
{
    load_view('list_page');
}

function list_productAction()
{
    load_view('list_product');
}

function add_postAction()
{
    load_view('add_post');
}

function list_postAction()
{
    load_view('list_post');
}

function list_catAction()
{
    load_view('list_cat');
}


function list_orderAction()
{
    load_view('list_order');
}

function list_customerAction()
{
    load_view('list_customer');
}

function add_widgetAction()
{
    load_view('add_widget');
}

function list_widgetAction()
{
    load_view('list_widget');
}

function add_sliderAction()
{
    load_view('add_slider');
}

function list_sliderAction()
{
    load_view('list_slider');
}

function list_mediaAction()
{
    load_view('list_media');
}
