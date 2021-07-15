<?php
//Connect to DB
$connect = mysqli_connect('localhost', 'root', 'root', 'products_cms') or die('Connection error: ' . mysqli_error());

//User registration
function user_register($connect)
{
    $new_user_login = trim(htmlspecialchars($_POST['new_login']));
    $new_user_password = password_hash(trim(htmlspecialchars($_POST['new_password'])), PASSWORD_DEFAULT);
    $new_user_date = date('Y-m-d H:i:s');

    if ((isset($_POST['new_user'])) && (isset($_POST['new_login'])) && (isset($_POST['new_password']))) {
        $check_query = "SELECT * FROM users WHERE user_login = '" . $new_user_login . "'";
        $result_arr = mysqli_fetch_assoc(mysqli_query($connect, $check_query));

        if (!isset($result_arr['user_login'])) {
            $register_query = "INSERT INTO users VALUES (NULL, '" . $new_user_login . "', '" . $new_user_password . "', '0', '" . $new_user_date . "', 'user')";
            $result = mysqli_query($connect, $register_query);
        }
    }
}

//User login
function user_login($connect)
{
    if ((isset($_POST['login_user'])) && (isset($_POST['login'])) && (isset($_POST['password']))) {
        $user_login = trim(htmlspecialchars($_POST['login']));
        $user_password = trim(htmlspecialchars($_POST['password']));

        $login_query = "SELECT * FROM users WHERE user_login = '" . $user_login . "' AND user_status = 'user'";
        $result_arr = mysqli_fetch_assoc(mysqli_query($connect, $login_query));

        $user_login_db = $result_arr['user_login'];
        $user_password_db = $result_arr['user_pass'];

        if (isset($result_arr['user_login'])) {
            if (($user_login === $user_login_db) && (password_verify($user_password, $user_password_db))) {
                $_SESSION['user_data']['user_id'] = $result_arr['user_id'];
                $_SESSION['user_data']['user_login'] = $result_arr['user_login'];
                $_SESSION['user_data']['user_status'] = 1;
                $_SESSION['user_data']['user_balance'] = $result_arr['user_balance'];
                $_SESSION['user_data']['user_data_reg'] = $result_arr['user_data_reg'];
                header('Location: /');
            }
        }
    }
}
