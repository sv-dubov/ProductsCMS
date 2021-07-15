<?php
//Check user's auth
function verify_user($user_data)
{
    if (!isset($user_data)) {
        $fold_path = 'all/';
    } elseif (isset($user_data)) {
        $fold_path = 'auth/';
    }
    return $fold_path;
}

//Path checker to further generate a complete relative path from current directory
function verify_path()
{
    if ($_SERVER['REQUEST_URI'] === '/') {
        $path_to_dir = '';
    } else {
        $path_to_dir = '../';
    }
    return $path_to_dir;
}

//Connecting page content depending on the selected path
function get_path_to_page()
{
    $folder = verify_user($_SESSION['user_data']);
    $dir = verify_path();
    $link = $_POST['link'];
    if (($link == '') || (!isset($link))) {
        $path_to_page = $folder . '/home.php';
    } elseif ((isset($link)) && ($link !== 'exit')) {
        $path_to_page = $dir . $folder . $link . ".php";
    } elseif ((isset($link)) && ($link !== 'exit')) {
        $path_to_page = 'all/home.php';
    }
    return $path_to_page;
}

//Destroy session
function ses_destroy()
{
    if ($_POST['link'] === 'exit') {
        $_SESSION = [];
        $_POST['link'] = null;
        $_POST = null;
        unset($_COOKIE[session_name()]);
        session_destroy();
        header('Location: /');
    }
}

//Determining the UA name of the month
function month_ua($month)
{
    if ($month === 'January') $month = 'Січня';
    elseif ($month === 'February') $month = 'Лютого';
    elseif ($month === 'March') $month = 'Березня';
    elseif ($month === 'April') $month = 'Квітня';
    elseif ($month === 'May') $month = 'Травня';
    elseif ($month === 'June') $month = 'Червня';
    elseif ($month === 'July') $month = 'Липня';
    elseif ($month === 'August') $month = 'Серпня';
    elseif ($month === 'September') $month = 'Вересня';
    elseif ($month === 'October') $month = 'Жовтня';
    elseif ($month === 'November') $month = 'Листопада';
    elseif ($month === 'December') $month = 'Грудня';
    return $month;
}