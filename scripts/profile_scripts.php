<?php

//Check user's balance
function check_balance($connect)
{
    $balance_query = "SELECT user_balance FROM users WHERE user_id = '" . $_SESSION['user_data']['user_id'] . "'";
    $result = mysqli_fetch_assoc(mysqli_query($connect, $balance_query));
    return $result['user_balance'];
}

//Displaying a shopping list for a specific user
function goods_list($connect)
{
    $goods_query = "SELECT * FROM trade_list WHERE user_id = '" . $_SESSION['user_data']['user_id'] . "'";
    $result = mysqli_query($connect, $goods_query);
    $result_arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $i = 1;
    foreach ($result_arr as $key => $value) {
        echo "<p class=\"goods_list_row\">";
        echo "<b>" . $i . "</b>&nbsp;";
        $i++;
        goods_cat($result_arr[$key], $connect);
        echo "</p>";
    }
}

//Outputting lines containing data about purchases to the browser
function goods_cat($array, $connect)
{
    foreach ($array as $k => $v) {
        if ($k === 'goods_id') {
            $query = "SELECT * FROM goods_list WHERE goods_id = '" . $v . "'";
            $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
            echo "<b>Goods name:</b>&nbsp;{$result['goods_name']};&nbsp;";
        } elseif ($k === 'goods_value') {
            echo "<b>Number of goods:</b>&nbsp;{$v};&nbsp;";
        } elseif ($k === 'trade_costs') {
            echo "<b>Purchase cost:</b>&nbsp;{$v};&nbsp;";
        } elseif ($k === 'trade_date') {
            echo "<b>Purchase date:</b>&nbsp;" . date('d-', strtotime($v)) . month_ua(date('F', strtotime($v))) . date('-Y в H:i:s', strtotime($v)) . ";&nbsp;";
        }
    }
}
