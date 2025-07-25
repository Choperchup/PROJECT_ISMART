<?php

function construct()
{
    load_model('index');
    load('lib', 'validation');
    load('lib', 'email');
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
    global $error, $email;
    $reset_token = $_GET['reset_token'];
    if (!empty($reset_token)) {
        if (check_reset_token($reset_token)) {
            if (check_reset_token($reset_token)) {
                if (isset($_POST['btn-new-pass'])) {
                    $error = array();

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

                    if (empty($error)) {
                        $data = array(
                            'password' => $password
                        );

                        update_pass($data, $reset_token);
                        redirect("?mod=users&action=resetSuccess");
                    }
                }
            }
            load_view('newPass');
        } else {
            echo "Yêu cầu lấy lại mật khẩu không hợp lệ";
        }
    } else {
        if (isset($_POST['btn-reset'])) {
            $error = array();

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
                if (check_email($email)) {
                    //Lưu trữ phiên đăng nhập
                    $reset_token = $email . time();
                    $data = array(
                        'reset_token' => $reset_token,
                    );
                    // Cập nhật reset pass cho user cần khôi phục mật khẩu
                    update_reset_token($data, $email);

                    // Gửi link khôi phục vào email của người dùng
                    $link_reset = base_url("?mod=users&action=reset&reset_token={$reset_token}");
                    $content = "<p>Bạn vui lòng cick vào đây để khôi phục mật khẩu: {$link_reset} !<p/>";

                    send_email($email, '', 'Khôi phục mật khẩu', $content);
                } else {
                    $error['account'] = "Email không tồn tại";
                }
            }
        }

        load_view('reset');
    }
}

function resetSuccess()
{
    load_view('resetSuccess');
}

function indexAction()
{
    load_view('index');
}

function blogAction()
{
    load_view('blog');
}

function category_productAction()
{
    load_view('category_product');
}

function detail_blogAction()
{
    load_view('detail_blog');
}

function cartAction()
{
    load_view('cart');
}

function checkoutAction()
{
    load_view('checkout');
}

function detail_productAction()
{
    load_view('detail_product');
}
